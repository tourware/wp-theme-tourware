<?php
namespace Tourware\Elementor\Widget\Travel;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Tourware\Elementor\Widget\Accordion\AbstractAccordion;

class Dates extends AbstractAccordion {
    /**
     * @return string
     */
    public function get_name()
    {
        return 'tourware-travel-dates';
    }

    /**
     * @return string
     */
    public function get_title()
    {
        return __( 'Travel Dates' );
    }

    /**
     * @return string
     */
    protected function getPostTypeName()
    {
        return 'tytotravels';
    }

    /**
     * @return string
     */
    protected function getRecordTypeName()
    {
        return 'travel';
    }

    /**
     * @return string
     */
    protected function getWidgetName()
    {
        return 'dates';
    }

    /**
     * @return array
     */
    public function get_script_depends() {
        return ['tourware-travel-dates'];
    }

    protected function _register_controls()
    {
        parent::_register_controls();

        $this->start_controls_section(
            'dates_options',
            [
                'label' => __( 'Dates Options', 'elementor-pro' )
            ]
        );

        $this->add_control(
            'heading_places',
            [
                'label' => __( 'Places Indicator', 'tourware' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_places',
            [
                'label' => __('Show', 'elementor-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'elementor-pro'),
                'label_off' => __('Hide', 'elementor-pro'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'places_low_tooltip',
            [
                'label'   => esc_html__( 'Low Quantity Tooltip', 'tourware' ),
                'type'    => Controls_Manager::TEXTAREA,
                'condition' => ['show_places' => 'yes']
            ]
        );

        $this->add_control(
            'places_average_tooltip',
            [
                'label'   => esc_html__( 'Average Quantity Tooltip', 'tourware' ),
                'type'    => Controls_Manager::TEXTAREA,
                'condition' => ['show_places' => 'yes']
            ]
        );

        $this->add_control(
            'places_high_tooltip',
            [
                'label'   => esc_html__( 'High Quantity Tooltip', 'tourware' ),
                'type'    => Controls_Manager::TEXTAREA,
                'condition' => ['show_places' => 'yes']
            ]
        );

        $tags_taxomomy = get_terms(['taxonomy' => 'tytotags', 'hide_empty' => false]);
        $tags = wp_list_pluck( $tags_taxomomy, 'name', 'name' );

        $this->add_control(
            'heading_information',
            [
                'label' => __( 'Additional Information', 'tourware' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_information',
            [
                'label' => __('Show', 'elementor-pro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'elementor-pro'),
                'label_off' => __('Hide', 'elementor-pro'),
                'default' => 'yes',
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control(
            'info_tags',
            [
                'label' => __( 'Tags', 'elementor' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'placeholder' => __( 'Tags', 'elementor' ),
                'default' => __( '', 'elementor' ),
                'multiple' => true,
                'dynamic' => [
                    'active' => true,
                ],
                'options' => $tags
            ]
        );

        $repeater->add_control(
            'info_icon',
            [
                'label' => __( 'Icon', 'elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'far fa-language',
                    'library' => 'fa-regular',
                ],
                'fa4compatibility' => 'icon',
            ]
        );

        $repeater->add_control(
            'info_tooltip',
            [
                'label' => __( 'Tooltip', 'elementor' ),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'info',
            [
                'label' => __( 'Items', 'elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ elementor.helpers.renderIcon( this, info_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ info_tags }}}',
                'condition' => ['show_information' => 'yes']
            ]
        );

        $this->end_controls_section();
    }

    protected function getTemplateData()
    {
        $settings = $this->get_settings();
        $post = $settings['post'] ? $settings['post'] : get_the_ID();
        $result = [];

        $repository = \Tourware\Repository\Travel::getInstance();
        $item_data = $repository->findOneByPostId($post);
        $dates = $item_data->getDates();

        foreach ($dates as $date) {
//            print_r($date);
            $date_format = 'D, d.m.Y';
            $start = date_create($date->start);
            $end = date_create($date->end);
            $dates_value = $start->format('d.m.Y').'-'.$end->format('d.m.Y');
            $price_value = number_format($date->price, 0, ',', '.');

            $tab_title = '<div class="col-auto"><div class="checkbox"><i class="far fa-circle"></i></div></div>';
            $tab_title .= '<div class="col"><div class="row">';
            $tab_title .= '<div class="dates" data-value="'.$dates_value.'">'.date_i18n($date_format, strtotime($date->start)).' - '.date_i18n($date_format, strtotime($date->end)).'</div>';
            $tab_title .= '<div class="days">'.date_diff($start, $end)->format('%d').' Tage</div>';

            $tab_title .= '<div class="places">';
            if ($settings['show_places'] === 'yes') {
                $color = 'green';
                $free_places = $date->maxPax - $date->bookedPax;
                $tooltip = $settings['places_high_tooltip'];
                if ($free_places === 0) {
                    $color = 'red';
                    $tooltip = $settings['places_low_tooltip'];
                } elseif ($free_places > 0 && $free_places < 4) {
                    $color = 'yellow';
                    $tooltip = $settings['places_average_tooltip'];
                }

                $tab_title .= '<i class="'.$color.' fas fa-circle"></i>';
                if (!empty($tooltip)) {
                    $tab_title .= '<span class="tooltip">'.$tooltip.'</span>';
                }
            }
            $tab_title .= '</div>';

            $tab_title .= '<div class="info">';
            if ($settings['show_information'] === 'yes' && !empty($date->tags)) {
                foreach ($settings['info'] as $info) {
                    foreach ($date->tags as $tag) {
                        if (array_search($tag->name, $info['info_tags']) !== false) {
                            $tab_title .= '<div class="info-wrapper">';
                            ob_start();
                            Icons_Manager::render_icon($info['info_icon'], ['aria-hidden' => 'true']);
                            $tab_title .= ob_get_clean();
                            if ($info['info_tooltip']) $tab_title .= '<span class="tooltip">'.$info['info_tooltip'].'</span>';
                            $tab_title .= '</div>';
                        }
                    }
                }
            }
            $tab_title .= '</div>';

            $tab_title .= '<div class="price" data-value="'.$price_value.'"><span class="value">'.$price_value.'</span>&nbsp;€</div>';
            $tab_title .= '</div></div>';

            $tab_content = '';
            if ($date->note) $tab_content .= '<div class="note">'.$date->note.'</div>';
            $tab_content .= '<h6>Zuschläge / Ermäßigungen</h6>';
            $tab_content .= '<div>* basierend auf dem Basispreis (1 Erwachsener im Doppelzimmer)</div>';
            if ($date->singleRoomSurcharge) {
                $tab_content .= '<div class="surcharge"><span class="h6-style">Einzelzimmer:</span> '.number_format($date->singleRoomSurcharge, 0, ',', '.').'&nbsp;€</div>';
            }
            if ($date->description) $tab_content .= '<div class="description">'.$date->description.'</div>';

            $result['accordion_data'][] = [
                'tab_title' => $tab_title,
                'tab_content' => $tab_content
            ];
        }

        return $result;
    }
}
