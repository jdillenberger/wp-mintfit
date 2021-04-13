<?php

defined('ABSPATH') or die();

$permission_callback_nonce = function ($request) {
    $headers = getallheaders();
    return isset($headers['X-WP-Nonce']) && !empty($headers['X-WP-Nonce']);
};

add_action('rest_api_init', function () use ($permission_callback_nonce) {

    register_rest_route('mintfit/v1', '/options', array(
        'methods' => 'GET',
        'permission_callback' => $permission_callback_nonce,
        'callback' => function ($atts) {
            return \apply_filters('mintfit-rest-get-options', $atts);
        },
    ));

    register_rest_route('mintfit/v1', '/options', array(
        'methods' => 'POST',
        'permission_callback' => $permission_callback_nonce,
        'callback' => function ($atts) {
            return \apply_filters('mintfit-rest-post-options', $atts);
        },
    ));

    register_rest_route('mintfit/v1', '/test/(?P<test>\w+)', array(
        'methods' => 'GET',
        'permission_callback' => $permission_callback_nonce,
        'callback' => function ($atts) {
            return \apply_filters('mintfit-rest-get-test', $atts);
        },
    ));

    register_rest_route('mintfit/v1', '/entry/(?P<id>\d+)', array(
        'methods' => 'DELETE',
        'permission_callback' => $permission_callback_nonce,
        'callback' => function ($atts) {
            return \apply_filters('mintfit-rest-delete-entry', $atts);
        },
    ));

    register_rest_route('mintfit/v1', '/update', array(
        'methods' => 'GET',
        'permission_callback' => $permission_callback_nonce,
        'callback' => function ($atts) {
            return \apply_filters('mintfit-rest-put-api-update', $atts);
        },
    ));

});
