<?php
/**
 * Plugin Name: WP Post Enricher
 * Plugin URI: http://wordpress.org/plugins/wp-post-enricher/
 * Description: Official WP Post Enricher plugin for WordPress. Improve your post creation. Requires PHP 5.4 or greater.
 * Version: 1.0
 * Author: Luís Nóbrega
 *
 * @TODO - Add composer custom command for tests.
 * @TODO - Minify styles and scripts with grunt/gulp pipeline.
 */

/**
 * Make sure the plugin does not expose any info if called directly
 *
 * @TODO - Move the definition of HTTP response code to a specific class.
 */
if (!function_exists('add_action')) {
    if (!headers_sent()) {
        if (function_exists('http_response_code')) {
            http_response_code(403);
        } else {
            header('HTTP/1.1 403 Forbidden', true, 403);
        }
        exit('Hi! I am a WordPress plugin. I can\'t be executed directly');
    }
}

// Requires PHP 5.4 or greater and curl
if (version_compare(PHP_VERSION, '5.4.0', '<') || !function_exists('curl_version')) {
    if (!class_exists('PostEnricher_CompatibilityNotice')) {
        require_once(dirname(__FILE__).'/compatibility-notice.php');
    }

    // possibly display a notice, trigger error
    add_action('admin_init', array('PostEnricher_CompatibilityNotice', 'adminInit'));

    // stop execution of this file
    return;
}

require_once (dirname(__FILE__) . '/autoload.php');

/**
 * Catches ajax calls early
 *
 * @TODO - Improve to Controller Resolver.
 */
$handleAjax = function () {
    $parts = explode('/', filter_var(ltrim($_REQUEST['url'], '/'), FILTER_SANITIZE_STRING));
    if (empty($parts[0]) || empty($parts[1])) {
        exit('Hi! Malformed URL.');
    }
    $controller = $parts[0];
    $action = $parts[1];
    $response = null;
    $controllerClassName = '\\PostEnricher\\Controller\\'.ucfirst($controller).'Controller';
    if (class_exists($controllerClassName)) {
        $controllerObj = new $controllerClassName;
        $actionMethodName = strtolower($action).'Action';
        if (method_exists($controllerObj, $actionMethodName)) {
            $response = $controllerObj->$actionMethodName();
        }
    }
    if (is_null($response)) {
        if (function_exists('http_response_code')) {
            http_response_code(404);
        } else {
            header('HTTP/1.1 404 Not Found', true, 404);
        }
        exit('Hi! Not found!');
    } else {
        echo $response;
    }
    wp_die();
};
add_action('wp_ajax_post_enricher_callback', $handleAjax);

// initialize on plugins loaded
add_action(
    'plugins_loaded',
    array('\PostEnricher\WordPress\PluginLoader', 'init'),
    0, // priority
    0 // expected arguments
);
