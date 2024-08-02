<?php
/*
Plugin Name: Wordpress Alias URL Stream
Plugin URI: https://github.com/nuobit/wp-alias-url-stream
Description: Enables server-side mapping of a single file to multiple virtual names without duplicating or renaming the file on the server. Using a virtual path '/alias/' to differentiate between the real and virtual parts of a URL, this plugin enhances the flexibility of file URL naming, allowing users to access and download files with any custom name while serving from the original source.
Version: 1.0.1
Author: NuoBiT Solutions, S.L.
Author URI: https://www.nuobit.com/
License: AGPLv3 or later
Text Domain: wp-alias-url-stream
License URI: https://www.gnu.org/licenses/agpl-3.0.html
*/

define('VIRTUAL_EXPR', '(.+?)/alias/([^/]+)/?$');

// Add custom non-WordPress rewrite rules only on Apache
function add_custom_non_wp_rewrite_rules($wp_rewrite) {
    $new_rules = array(
        VIRTUAL_EXPR => 'index.php'
    );
    $wp_rewrite->non_wp_rules = array_merge($new_rules, $wp_rewrite->non_wp_rules);
}
if (function_exists('apache_get_version')) {
    add_action('generate_rewrite_rules', 'add_custom_non_wp_rewrite_rules');
}

// Add custom Wordpress route
function wp_alias_url_stream_add_custom_route() {
    add_rewrite_rule('^' . VIRTUAL_EXPR, 'index.php?actual_file_path=$matches[1]&virtual_filename=$matches[2]', 'top');
}
add_action('init', 'wp_alias_url_stream_add_custom_route');

// Add custom query vars
function wp_alias_url_stream_add_custom_query_vars($vars) {
    $vars[] = 'actual_file_path';
    $vars[] = 'virtual_filename';
    return $vars;
}
add_filter('query_vars', 'wp_alias_url_stream_add_custom_query_vars');

// Disable canonical redirects for our custom path
function wp_alias_url_stream_disable_redirect_canonical($redirect_url, $requested_url) {
    // Check if the URL matches alias format
    if (preg_match('#^' . VIRTUAL_EXPR . '#', $requested_url)) {
        return false;
    }
    return $redirect_url;
}
add_filter('redirect_canonical', 'wp_alias_url_stream_disable_redirect_canonical', 10, 2);

// Handle the request and serve the file
function wp_alias_url_stream_serve_file() {
    $actual_file = get_query_var('actual_file_path', false);
    $virtual_filename = get_query_var('virtual_filename', false);
    if ($actual_file && $virtual_filename) {
        $file_path = ABSPATH . $actual_file;
        if (file_exists($file_path)) {
            $file_info = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $file_info->file($file_path);
            header("Content-Type: $mime_type");
            header("Content-Disposition: inline; filename=\"$virtual_filename\"");
            readfile($file_path);
            exit;
        }
    }
}
add_action('template_redirect', 'wp_alias_url_stream_serve_file');

// Activation hook
function wp_alias_url_stream_activate() {
    wp_alias_url_stream_add_custom_route();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'wp_alias_url_stream_activate');

// Deactivation hook
function wp_alias_url_stream_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'wp_alias_url_stream_deactivate');
?>
