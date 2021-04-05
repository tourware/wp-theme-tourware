<?php

namespace Tourware\Elementor\Widget\Travel;

use Tourware\Elementor\Widget;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

class Breadcrumbs extends Widget
{
    private $css = [
        'module' => '.tourware-breadcrumbs',
        'title' => '.tourware-breadcrumbs__title',
        'content' => '.tourware-breadcrumbs__content',
        'browse' => '.tourware-breadcrumbs__browse',
        'item' => '.tourware-breadcrumbs__item',
        'sep' => '.tourware-breadcrumbs__item-sep',
        'link' => '.tourware-breadcrumbs__item-link',
        'target' => '.tourware-breadcrumbs__item-target',
    ];

    /**
     * @return string
     * @throws \Exception
     */
    public function get_name()
    {
        return 'tourware-travel-breadcrumbs';
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function get_title()
    {
        return __('Travel Breadcrumbs');
    }

    protected function _register_controls()
    {
        $this->sectionGeneralSetting();
        $this->sectionCountriesSetting();
        $this->sectionPageTitleStyle();
        $this->sectionBreadcrumbsStyle();
    }

    private function sectionGeneralSetting()
    {

        $this->start_controls_section(
            'section_breadcrumbs_settings',
            [
                'label' => __('General Settings'),
            ]
        );

        $this->add_control(
            'show_on_front',
            [
                'label' => __('Show on Front Page'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'prefix_class' => 'jet-breadcrumbs-on-front-',
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __('Show Page Title'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'render_type' => 'template',
                'prefix_class' => 'jet-breadcrumbs-page-title-',
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => __('Title HTML Tag'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                ],
                'default' => 'h3',
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_browse',
            [
                'label' => __('Show Prefix'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'browse_label',
            [
                'label' => __('Prefix for the breadcrumb path'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => __('Browse:'),
                'condition' => [
                    'show_browse' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'enabled_custom_home_page_label',
            [
                'label' => __('Custom Home Page Label'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'custom_home_page_label',
            [
                'label' => __('Label for home page'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => __('Home'),
                'condition' => [
                    'enabled_custom_home_page_label' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'separator_type',
            [
                'label' => __('Separator Type'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'icon' => __('Icon'),
                    'custom' => __('Custom'),
                ],
                'default' => 'icon',
            ]
        );

        $this->add_control(
            'icon_separator',
            [
                'label' => __('Icon Separator'),
                'type' => Controls_Manager::ICONS,
                'default' => 'fa fa-angle-right',
                'fa5_default' => [
                    'value' => 'fas fa-angle-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'separator_type' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'custom_separator',
            [
                'label' => __('Custom Separator'),
                'type' => Controls_Manager::TEXT,
                'default' => '/',
                'condition' => [
                    'separator_type' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'path_type',
            [
                'label' => __('Path type'),
                'type' => Controls_Manager::SELECT,
                'default' => 'full',
                'options' => [
                    'full' => __('Full'),
                    'minified' => __('Minified'),
                ],
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => __('Alignment'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['content'] => 'justify-content: {{VALUE}};',
                ],
                'prefix_class' => 'jet-breadcrumbs-align%s-',
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,
                'default' => '-1',
                'options' => [
                    '-1' => __('Page Title / Breadcrumbs Items'),
                    '1' => __('Breadcrumbs Items / Page Title'),
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['title'] => 'order: {{VALUE}};',
                ],
                'condition' => [
                    'show_title' => 'yes',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'breadcrumbs_settings_desc',
            [
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-descriptor',
            ]
        );

        $this->end_controls_section();
    }

    private function sectionCountriesSetting()
    {
        $this->start_controls_section(
            'section_countries_settings',
            [
                'label' => __('Countries Settings'),
            ]
        );

        $this->add_control(
            'enabled_countries_item',
            [
                'label' => __('Show country item'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'enabled_custom_multi_countries_label',
            [
                'label' => __('Custom Multi Countries Label'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'condition' => [
                    'enabled_countries_item' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'custom_multi_countries_label',
            [
                'label' => __('Label for multi countries item'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => __('Multi countries'),
                'condition' => [
                    'enabled_custom_multi_countries_label' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function sectionPageTitleStyle()
    {
        $this->start_controls_section(
            'title_style',
            [
                'label' => __('Page Title'),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} ' . $this->css['title'],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['title'] => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_bg_color',
            [
                'label' => __('Background Color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['title'] => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => __('Margin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => __('Padding'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_border',
                'label' => __('Border'),
                'placeholder' => '1px',
                'selector' => '{{WRAPPER}} ' . $this->css['title'],
            ]
        );

        $this->add_responsive_control(
            'title_border_radius',
            [
                'label' => __('Border Radius'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['title'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function sectionBreadcrumbsStyle()
    {
        $this->start_controls_section(
            'breadcrumbs_style',
            [
                'label' => __('Breadcrumbs'),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'breadcrumbs_crumbs_heading',
            [
                'label' => __('Crumbs Style'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('breadcrumbs_item_style');

        $this->start_controls_tab(
            'breadcrumbs_item_normal',
            [
                'label' => __('Normal'),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'breadcrumbs_item_typography',
                'selector' => '{{WRAPPER}} ' . $this->css['item'] . ' > *',
            ]
        );

        $this->add_control(
            'breadcrumbs_link_color',
            [
                'label' => __('Color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['link'] => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'breadcrumbs_link_bg_color',
            [
                'label' => __('Background Color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['link'] => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'breadcrumbs_item_hover',
            [
                'label' => __('Hover'),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'breadcrumbs_link_hover_typography',
                'selector' => '{{WRAPPER}} ' . $this->css['link'] . ':hover',
            ]
        );

        $this->add_control(
            'breadcrumbs_link_hover_color',
            [
                'label' => __('Color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['link'] . ':hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'breadcrumbs_link_hover_bg_color',
            [
                'label' => __('Background Color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['link'] . ':hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'breadcrumbs_link_hover_border_color',
            [
                'label' => __('Border Color'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'breadcrumbs_item_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['link'] . ':hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'breadcrumbs_item_target',
            [
                'label' => __('Current'),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'breadcrumbs_target_item_typography',
                'selector' => '{{WRAPPER}} ' . $this->css['target'],
            ]
        );

        $this->add_control(
            'breadcrumbs_target_item_color',
            [
                'label' => __('Color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['target'] => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'breadcrumbs_target_item_bg_color',
            [
                'label' => __('Background Color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['target'] => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'breadcrumbs_target_item_border_color',
            [
                'label' => __('Border Color'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'breadcrumbs_item_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['item'] . ' ' . $this->css['target'] => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'breadcrumbs_item_padding',
            [
                'label' => __('Padding'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['link'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} ' . $this->css['target'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'breadcrumbs_item_border',
                'label' => __('Border'),
                'placeholder' => '1px',
                'selector' => '{{WRAPPER}} ' . $this->css['link'] . ', {{WRAPPER}} ' . $this->css['target'],
            ]
        );

        $this->add_responsive_control(
            'breadcrumbs_item_border_radius',
            [
                'label' => __('Border Radius'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['link'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} ' . $this->css['target'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'breadcrumbs_sep_heading',
            [
                'label' => __('Separators Style'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'breadcrumbs_sep_gap',
            [
                'label' => __('Gap'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['sep'] => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'breadcrumbs_sep_icon_size',
            [
                'label' => __('Icon Size'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['sep'] => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'separator_type' => 'icon',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'breadcrumbs_sep_typography',
                'selector' => '{{WRAPPER}} ' . $this->css['sep'],
                'condition' => [
                    'separator_type' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'breadcrumbs_sep_color',
            [
                'label' => __('Color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['sep'] => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'breadcrumbs_sep_bg_color',
            [
                'label' => __('Background Color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['sep'] => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'breadcrumbs_sep_padding',
            [
                'label' => __('Padding'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['sep'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'breadcrumbs_sep_border',
                'label' => __('Border'),
                'placeholder' => '1px',
                'selector' => '{{WRAPPER}} ' . $this->css['sep'],
            ]
        );

        $this->add_responsive_control(
            'breadcrumbs_sep_border_radius',
            [
                'label' => __('Border Radius'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['sep'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'breadcrumbs_browse_heading',
            [
                'label' => __('Prefix Style'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_browse' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'breadcrumbs_browse_gap',
            [
                'label' => __('Gap'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['browse'] => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_browse' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'breadcrumbs_browse_typography',
                'selector' => '{{WRAPPER}} ' . $this->css['browse'],
                'condition' => [
                    'show_browse' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'breadcrumbs_browse_color',
            [
                'label' => __('Color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['browse'] => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_browse' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'breadcrumbs_browse_bg_color',
            [
                'label' => __('Background Color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['browse'] => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_browse' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'breadcrumbs_browse_padding',
            [
                'label' => __('Padding'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['browse'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_browse' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'breadcrumbs_browse_border',
                'label' => __('Border'),
                'placeholder' => '1px',
                'selector' => '{{WRAPPER}} ' . $this->css['browse'],
                'condition' => [
                    'show_browse' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'breadcrumbs_browse_border_radius',
            [
                'label' => __('Border Radius'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $this->css['browse'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_browse' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $breadcrumbs = [
            $this->getHomePage(),
            $this->getArchivePage(),
            $this->getTravelCountryPage(),
            $this->getCurrentPage(),
        ];

        echo '<div class="' . $this->getCss('module') . '">';
        if ($settings['show_title']) {
            echo '<' . $settings['title_tag'] . ' class="' . $this->getCss('title') . '">' . get_the_title() . '</' . $settings['title_tag'] . '>';
        }
        echo '<div class="' . $this->getCss('content') . '">';
        if ($settings['show_browse'] === 'yes') {
            echo '<div class="' . $this->getCss('browse') . '">' . $settings['browse_label'] . '</div>';
        }
        $separator = $this->getSeparator();
        foreach ($breadcrumbs as $i => $breadcrumb) {
            if (!$breadcrumb['label']) continue;

            echo '<div class="' . $this->getCss('item') . '">';
            if ($breadcrumb['url'] && $i < count($breadcrumbs) - 1) {
                echo '<a href="' . $breadcrumb['url'] . '" class="' . $this->getCss('link') . '">' . $breadcrumb['label'] . '</a>';
            } else {
                echo '<span class="' . $this->getCss('target') . '">' . $breadcrumb['label'] . '</span>';
            }
            echo '</div>';

            if ($i < count($breadcrumbs) - 1) {
                echo $separator;
            }
        }

        echo '</div>';
        echo '</div>';
    }

    private function getHomePage()
    {
        $settings = $this->get_settings_for_display();

        $customHomePageEnabled = !empty($settings['enabled_custom_home_page_label']) ? $settings['enabled_custom_home_page_label'] : false;
        $customHomePageLabel = $customHomePageEnabled
            ? !empty($settings['custom_home_page_label'])
                ? $settings['custom_home_page_label']
                : __('Home')
            : false;
        $homePageId = get_option('page_on_front');
        $homePageLabel = $homePageId
            ? get_the_title($homePageId)
            : get_bloginfo('name');

        return [
            'id' => $homePageId,
            'url' => get_bloginfo('url'),
            'label' => $customHomePageLabel !== false
                ? $customHomePageLabel
                : $homePageLabel,
        ];
    }

    private function getArchivePage()
    {
        $settings = $this->get_settings_for_display();
        $postType = get_post_type_object(get_post_type());

        return $settings['path_type'] === 'full' && $postType
            ? [
                'id' => '',
                'url' => get_post_type_archive_link($postType->name),
                'label' => $postType->label,
            ]
            : [];
    }

    private function getTravelCountryPage()
    {
        $settings = $this->get_settings_for_display();

        $terms = get_the_terms(get_the_ID(), 'tytocountries');
        $customMultiCountriesEnabled = !empty($settings['enabled_custom_multi_countries_label']) ? $settings['enabled_custom_multi_countries_label'] : false;
        $customMultiCountriesLabel = $customMultiCountriesEnabled
            ? !empty($settings['custom_multi_countries_label'])
                ? $settings['custom_multi_countries_label']
                : __('Multi countries')
            : false;

        return count($terms) === 0 || empty($settings['enabled_countries_item'])
            ? []
            : [
                'id' => null,
                'url' => null,
                'label' => count($terms) > 1 && $customMultiCountriesLabel !== false
                    ? $customMultiCountriesLabel
                    : $terms[0]->name,
            ];

    }

    private function getCurrentPage()
    {
        $currentPageId = get_the_ID();
        $homePageId = get_option('page_on_front');

        return $currentPageId == $homePageId
            ? []
            : [
                'id' => $currentPageId,
                'url' => get_permalink($currentPageId),
                'label' => get_the_title($currentPageId),
            ];
    }

    private function getSeparator()
    {
        $settings = $this->get_settings_for_display();

        $separator = '<div class="' . $this->getCss('item') . '">';
        $separator .= '<div class="' . $this->getCss('sep') . '">';
        if ($settings['separator_type'] === 'icon') {
            ob_start();
            Icons_Manager::render_icon($settings['icon_separator'], ['aria-hidden' => 'true', 'class' => 'fa-fw']);
            $separator .= ob_get_clean();
        } else {
            $separator .= $settings['custom_separator'];
        }
        $separator .= '</div>';
        $separator .= '</div>';

        return $separator;
    }

    private function getCss($selector)
    {
        return str_replace(['#', '.'], '', $this->css[$selector]);
    }
}
