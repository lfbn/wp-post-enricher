<?php

/**
 * Comunicate a lack of compatibility between WP Post Enricher plugin for Wordpress and current site server environment.
 */
class PostEnricher_CompatibilityNotice
{

    /**
     * Minimum version of PHP required to run the plugin
     *
     * @type string
     */
    const MIN_PHP_VERSION = '5.4.0';

    /**
     * Admin init handler
     *
     * @return void
     */
    public static function adminInit()
    {
        // no action taken for ajax request
        // extra non-formatted output could break a response format such as XML or JSON
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        // only show notice to a user of proper capability
        if (!PostEnricher_CompatibilityNotice::currentUserCanManagePlugins()) {
            return;
        }

        // trigger an E_USER_NOTICE for the built-in error handler
        trigger_error(
            sprintf(
                'The WP Post Enricher plugin for WordPress requires PHP version %s or greater and CURL.',
                PostEnricher_CompatibilityNotice::MIN_PHP_VERSION
            )
        );

        // deactivate the plugin
        PostEnricher_CompatibilityNotice::deactivatePlugin();

        // display an admin notice
        add_action('admin_notices', array( 'PostEnricher_CompatibilityNotice', 'adminNotice' ));
    }

    /**
     * Get the plugin path relative to the plugins directory. Used to identify
     * the plugin in a list of installed and activated plugins.
     *
     * @return string
     */
    public static function getPluginPath()
    {
        return dirname(plugin_basename(__FILE__)).'/wp-post-enricher.php';
    }

    /**
     * Does the curent user have the capability to possibly fix the problem?
     *
     * @return bool
     */
    public static function currentUserCanManagePlugins()
    {
        return current_user_can(
            is_plugin_active_for_network(
                PostEnricher_CompatibilityNotice::getPluginPath()
            ) ? 'manage_network_plugins' : 'activate_plugins'
        );
    }

    /**
     * Deactivate the plugin due to incompatibility
     *
     * @return void
     */
    public static function deactivatePlugin()
    {
        // test for plugin management capability
        if (!PostEnricher_CompatibilityNotice::currentUserCanManagePlugins()) {
            return;
        }

        // deactivate with deactivation actions (non-silent)
        deactivate_plugins(array(PostEnricher_CompatibilityNotice::getPluginPath()));

        // remove activate state to prevent a "Plugin activated" notice
        // notice located in wp-admin/plugins.php
        unset( $_GET['activate'] );
    }

    /**
     * Display an admin notice communicating an incompatibility
     *
     * @return void
     */
    public static function adminNotice()
    {

        echo '<div class="notice error is-dismissible">';
        echo '<p>' . esc_html(
            sprintf(
                'The WP Post Enricher plugin for WordPress requires PHP version %s or greater and CURL.',
                PostEnricher_CompatibilityNotice::MIN_PHP_VERSION
            )
        ) . '</p>';

        if (is_plugin_inactive(PostEnricher_CompatibilityNotice::getPluginPath())) {
            echo '<p>' . 'Plugin <strong>deactivated</strong>.' . '</p>';
        }

        echo '</div>';
    }
}
