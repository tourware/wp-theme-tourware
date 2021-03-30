<?php

namespace Tourware\Elementor\Widget\Flightprice;

use Tourware\Elementor\Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Utils;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Title extends Widget
{

    /**
     * @return string
     * @throws \Exception
     */
    public function get_name()
    {
        return 'tourware-flightprice-title';
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function get_title()
    {
        return __('Flightprice Title');
    }

    protected function _register_controls()
    {
        $this->sectionTitle();
        $this->sectionStyle();
    }

    private function sectionTitle()
    {
        $this->start_controls_section('section_title', [
            'label' => __('Field', 'tourware'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('form_id', [
            'label' => __('Form ID* (Required)', 'tourware'),
            'type' => Controls_Manager::TEXT,
            'description' => __('Enter the same form id for all fields in a form, with latin character and no space. E.g order_form', 'tourware'),
            'render_type' => 'none',
        ]);

        $this->add_control('airline_field_id', [
            'label' => __('Airline Field ID* (Required)', 'tourware'),
            'type' => Controls_Manager::TEXT,
            'description' => __('Field ID have to be unique in a form, with latin character and no space. Please do not enter Field ID = product. E.g your_field_id', 'tourware'),
            'default' => __('airline'),
            'render_type' => 'none',
        ]);

        $this->add_control('airport_field_id', [
            'label' => __('Airport Field ID* (Required)', 'tourware'),
            'type' => Controls_Manager::TEXT,
            'description' => __('Field ID have to be unique in a form, with latin character and no space. Please do not enter Field ID = product. E.g your_field_id', 'tourware'),
            'default' => __('airport'),
            'render_type' => 'none',
        ]);

        $this->add_control('title', [
            'label' => __('Title', 'tourware'),
            'type' => Controls_Manager::TEXTAREA,
            'dynamic' => [
                'active' => true,
            ],
            'description' => __('Shortcodes: [airline] & [airport]', 'tourware'),
            'placeholder' => __('Enter your title', 'tourware'),
            'default' => __('Add Your Heading Text Here', 'tourware'),
        ]);

        $this->add_control('link', [
            'label' => __('Link', 'tourware'),
            'type' => Controls_Manager::URL,
            'dynamic' => [
                'active' => true,
            ],
            'default' => [
                'url' => '',
            ],
            'separator' => 'before',
        ]);

        $this->add_control('size', [
            'label' => __('Size', 'tourware'),
            'type' => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => __('Default', 'tourware'),
                'small' => __('Small', 'tourware'),
                'medium' => __('Medium', 'tourware'),
                'large' => __('Large', 'tourware'),
                'xl' => __('XL', 'tourware'),
                'xxl' => __('XXL', 'tourware'),
            ],
        ]);

        $this->add_control('header_size', [
            'label' => __('HTML Tag', 'tourware'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
                'div' => 'div',
                'span' => 'span',
                'p' => 'p',
            ],
            'default' => 'h2',
        ]);

        $this->add_responsive_control('align', [
            'label' => __('Alignment', 'tourware'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'tourware'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'tourware'),
                    'icon' => 'eicon-text-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'tourware'),
                    'icon' => 'eicon-text-align-right',
                ],
                'justify' => [
                    'title' => __('Justified', 'tourware'),
                    'icon' => 'eicon-text-align-justify',
                ],
            ],
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}' => 'text-align: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    private function sectionStyle()
    {
        $this->start_controls_section('section_title_style', [
            'label' => __('Title', 'elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('title_color', [
            'label' => __('Text Color', 'tourware'),
            'type' => Controls_Manager::COLOR,
            'global' => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [
                '{{WRAPPER}} .flightprice-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'global' => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '{{WRAPPER}} .flightprice-title',
        ]);

        $this->add_group_control(Group_Control_Text_Shadow::get_type(), [
            'name' => 'text_shadow',
            'selector' => '{{WRAPPER}} .flightprice-title',
        ]);

        $this->add_control('blend_mode', [
            'label' => __('Blend Mode', 'tourware'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '' => __('Normal', 'tourware'),
                'multiply' => 'Multiply',
                'screen' => 'Screen',
                'overlay' => 'Overlay',
                'darken' => 'Darken',
                'lighten' => 'Lighten',
                'color-dodge' => 'Color Dodge',
                'saturation' => 'Saturation',
                'color' => 'Color',
                'difference' => 'Difference',
                'exclusion' => 'Exclusion',
                'hue' => 'Hue',
                'luminosity' => 'Luminosity',
            ],
            'selectors' => [
                '{{WRAPPER}} .flightprice-title' => 'mix-blend-mode: {{VALUE}}',
            ],
            'separator' => 'none',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if ($settings['title'] === '') {
            return;
        }

        $this->add_render_attribute('title', 'class', 'flightprice-title');

        if (!empty($settings['size'])) {
            $this->add_render_attribute('title', 'class', 'elementor-size-' . $settings['size']);
        }

        $this->add_inline_editing_attributes('title');
        $data = $this->getDataFromGet();

        $title = $settings['title'];
        if ($data) {
            $title = str_replace('[airport]', $data->zielort, $title);
            $title = str_replace('[airline]', $data->airline_name, $title);
        }

        if (!empty($settings['link']['url'])) {
            $this->add_link_attributes('url', $settings['link']);

            $title = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('url'), $title);
        }

        $title_html = sprintf('<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag($settings['header_size']), $this->get_render_attribute_string('title'), $title);
        if ($settings['form_id'] !== '' && $data) {
            if ($settings['airline_field_id'] && $data->airline_name) {
                $this->add_render_attribute('input_airline', 'data-pafe-form-builder-form-id', $settings['form_id']);
                $this->add_render_attribute('input_airline', 'name', 'form_fields[' . $settings['airline_field_id'] . ']');
                $this->add_render_attribute('input_airline', 'value', $data->airline_name);
                $this->add_render_attribute('input_airline', 'type', 'hidden');
                $title_html .= '<input ' . $this->get_render_attribute_string('input_airline') . '>';
            }
            if ($settings['airport_field_id'] && $data->zielort) {
                $this->add_render_attribute('input_airport', 'data-pafe-form-builder-form-id', $settings['form_id']);
                $this->add_render_attribute('input_airport', 'name', 'form_fields[' . $settings['airport_field_id'] . ']');
                $this->add_render_attribute('input_airport', 'value', $data->zielort);
                $this->add_render_attribute('input_airport', 'type', 'hidden');
                $title_html .= '<input ' . $this->get_render_attribute_string('input_airport') . '>';
            }
        }

        echo $title_html;
    }

    private function getDataFromGet()
    {
        global $wpdb;

        if ($id = (int)$_GET['id']) {
            return $wpdb->get_row("
                SELECT * FROM `web18mts_fpreise` as fpreise
                INNER JOIN (SELECT `select_value` as airline_name, select_id as airline_select_id FROM web18mts_fpreise_values WHERE `select_type` = 'airline' AND `select_del` = 0) as airline
                    ON airline.airline_select_id = fpreise.fpreise_airline
                INNER JOIN (SELECT `select_value` as zielort, select_id as zielort_select_id FROM web18mts_fpreise_values WHERE `select_del` = 0 AND select_type = 'flughafen') as zielorte
                    ON zielorte.zielort_select_id = fpreise.fpreise_flughafen
                WHERE `fpreise_id` = $id");
        }

        return null;
    }
}
