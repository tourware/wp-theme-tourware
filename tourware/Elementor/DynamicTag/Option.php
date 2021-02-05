<?php

namespace Tourware\Elementor\DynamicTag;

class Option extends \Elementor\Core\DynamicTags\Tag {

    /**
     * Get Name
     *
     * Returns the Name of the tag
     *
     * @since 2.0.0
     * @access public
     *
     * @return string
     */
    public function get_name() {
        return 'option';
    }

    /**
     * Get Title
     *
     * Returns the title of the Tag
     *
     * @since 2.0.0
     * @access public
     *
     * @return string
     */
    public function get_title() {
        return __( 'Unternehmen', 'elementor-pro' );
    }

    /**
     * Get Group
     *
     * Returns the Group of the tag
     *
     * @since 2.0.0
     * @access public
     *
     * @return string
     */
    public function get_group() {
        return 'tourware';
    }

    /**
     * Get Categories
     *
     * Returns an array of tag categories
     *
     * @since 2.0.0
     * @access public
     *
     * @return array
     */
    public function get_categories() {
        return [
            \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY,
            \Elementor\Modules\DynamicTags\Module::URL_CATEGORY
        ];
    }

    /**
     * Register Controls
     *
     * Registers the Dynamic tag controls
     *
     * @since 2.0.0
     * @access protected
     *
     * @return void
     */
    protected function _register_controls() {

        $variables = [];

        if ($tourware_company = get_option('tourware-company')) {
            foreach ( array_keys($tourware_company) as $variable ) {
                $variables[ $variable ] = ucwords( str_replace( '_', ' ', $variable ) );
            }
        }


        $this->add_control(
            'param_name',
            [
                'label' => __( 'Parameter', 'elementor-pro' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $variables,
            ]
        );
    }

    /**
     * Render
     *
     * Prints out the value of the Dynamic tag
     *
     * @since 2.0.0
     * @access public
     *
     * @return void
     */
    public function render() {
        $param_name = $this->get_settings( 'param_name' );
        $config = get_option('tourware-company');

        if ( ! $param_name ) {
            return;
        }

        if ( ! isset( $config[ $param_name ] ) ) {
            return;
        }

        $value = $config[ $param_name ];
        echo wp_kses_post( $value );
    }
}