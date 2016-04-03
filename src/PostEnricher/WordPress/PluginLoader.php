<?php

namespace PostEnricher\WordPress;

use PostEnricher\Helper\PluginPathsHelper;

class PluginLoader
{

    const VERSION = '1.0';

    /**
     * Bind to hooks and filters
     *
     * @return void
     */
    public static function init()
    {

        if (!is_admin()) {
            return;
        }

        $classname = get_called_class();

        add_action(
            'admin_footer',
            array($classname, 'registerScripts')
        );

        add_action(
            'admin_footer',
            array($classname, 'registerStyles')
        );

        add_action(
            'admin_init',
            array(
                '\PostEnricher\WordPress\Admin\Post\MetaBox',
                'init'
            )
        );
    }

    /**
     * Register JavaScript during the enqueue scripts action
     *
     * @return void
     */
    public static function registerScripts()
    {
        wp_register_script(
            'post_enricher_script_admin_post',
            plugins_url('static/js/admin/post/edit.js', PluginPathsHelper::getPluginMainFile())
        );
        wp_enqueue_script('post_enricher_script_admin_post');
    }

    /**
     * Register styles during the enqueue scripts action. Using the Pure CSS styling.
     *
     * @return void
     * @link http://purecss.io/
     */
    public static function registerStyles()
    {
        wp_register_style(
            'post_enricher_style_admin_post_purecss',
            'http://yui.yahooapis.com/pure/0.6.0/pure-min.css'
        );
        wp_register_style(
            'post_enricher_style_admin_post',
            plugins_url('static/css/admin/post/edit.css', PluginPathsHelper::getPluginMainFile()),
            array('post_enricher_style_admin_post_purecss')
        );
        wp_enqueue_style('post_enricher_style_admin_post_purecss');
        wp_enqueue_style('post_enricher_style_admin_post');
    }
}
