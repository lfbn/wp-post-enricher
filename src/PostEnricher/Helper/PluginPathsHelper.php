<?php

namespace PostEnricher\Helper;

class PluginPathsHelper
{

    /**
     * Returns the full path to the directory containing the plugin files
     *
     * @return string
     */
    public static function getPluginDirectory()
    {
        return ABSPATH . 'wp-content/plugins/wp-post-enricher/';
    }

    /**
     * Returns the full path to the directory containing the views of the plugin
     *
     * @return string
     */
    public static function getPluginViewsDirectory()
    {
        return static::getPluginDirectory() . 'views/';
    }

    /**
     * Returns the full path to the main file of the plugin
     *
     * @return string
     */
    public static function getPluginMainFile()
    {
        return static::getPluginDirectory() . 'wp-post-enricher.php';
    }
}
