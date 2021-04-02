<?php

namespace Tourware;

class Theme
{
    /**
     * A reference to an instance of this class.
     */
    private static $instance = null;

    /**
     * Returns the instance.
     */
    public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * @return \Tourware\Theme
     */
    public function run() {
        add_filter( 'query_vars', function($vars) {
            $vars[] = 'booking';
            return $vars;
        } );

        add_action('generate_rewrite_rules', function($wp_rewrite) {
            $rules = array(
                'buchung\/([0-9a-zA-Z-]+)?[\/]?$' => 'index.php?p=4391&booking=' . $wp_rewrite->preg_index(1)
            );

            $wp_rewrite->rules = $rules + $wp_rewrite->rules;
        });

        add_action( 'init', function () {
            register_taxonomy_for_object_type( 'category', 'page' );
            register_taxonomy_for_object_type('post_tag', 'page');
        } );

        add_action( 'template_redirect', function () {
            if ('tytotravels' == get_post_type() && post_password_required()) {
                get_template_part('/tourware-resources/layouts/travel/protected');
                die;
            }
        }, 99 );

        add_action( 'wp_enqueue_scripts', function () {
            wp_register_script('tourware-js', get_parent_theme_file_uri() . '/public/tourware.js', 'vue', null, true);
            wp_enqueue_style('tourware', get_parent_theme_file_uri() . '/public/tourware.css', null, time());
        } );

        add_action('elementor/frontend/before_register_scripts', function () {
            wp_register_script('lodash-adt', get_parent_theme_file_uri() . '/tourware-resources/js/widget/travel/lodash.js', ['jquery']);
            wp_register_script('tourware-travel-map', get_parent_theme_file_uri() . '/tourware-resources/js/widget/travel/Map.js', ['lodash-adt']);
            wp_register_script('tourware-travel-dates', get_parent_theme_file_uri() . '/tourware-resources/js/widget/travel/dates-accordion.js', ['jquery']);
        });

        // Legacy
        add_filter( 'kava-theme/customizer/options', array(new Customizer\Typography(), 'register'), 99 );
        add_filter( 'kava-theme/customizer/options', array(new Customizer\Page\Header(), 'register'), 99 );
        add_filter( 'kava-theme/customizer/options', array(new Customizer\Buttons(), 'register'), 99 );
        add_filter( 'kava-theme/customizer/options', array(new Customizer\Travel\Single(), 'register'), 99 );
        add_filter( 'kava-theme/customizer/options', array(new Customizer\Travel\Sidebar(), 'register'), 99 );
        add_filter( 'kava-theme/customizer/options', array(new Customizer\Accommodation\Single(), 'register'), 99 );
        add_filter( 'kava-theme/customizer/options', array(new Customizer\Brick\Single(), 'register'), 99 );

        // Correct way
        add_action( 'customize_register', function ($wp_customize) {
            new Customizer\Page\General($wp_customize);
        } );

        include get_theme_file_path( 'inc/tourware/tcpdf/generate.php' );
        include get_theme_file_path( 'inc/tourware/form-action-hook.php' );
//        include get_theme_file_path( 'inc/tourware/functions-pipedrive.php' );
//        include get_theme_file_path( 'inc/tourware/pipedrive-sender.php' );

        return $this;
    }
}