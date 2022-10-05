<?php

use Inc\Controllers\customerController;

add_action('rest_api_init', function () {
    remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );

    register_rest_route("style-studio/v1", "get_form_customer", array(
        'methods' => "GET",
        'callback' =>  array(customerController::class,"get_form_customer"),
        'permission_callback' => 'is_user_logged_in'
    ));



});

add_action('rest_api_init', function () {
    register_rest_route("style-studio/v1", "add_customer", array(
        'methods' => "POST",
        'callback' =>  array(customerController::class,"add_customer"),
        'permission_callback' => 'is_user_logged_in'
    ));
});


add_action('rest_api_init', function () {
    register_rest_route("style-studio/v1", "search_customer", array(
        'methods' => "GET",
        'callback' =>  array(customerController::class,"search_customer"),
        'permission_callback' => 'is_user_logged_in'
    ));
});


add_action('rest_api_init', function () {
    register_rest_route("style-studio/v1", "get_customer", array(
        'methods' => "GET",
        'callback' =>  array(customerController::class,"get_customer"),
        'permission_callback' => 'is_user_logged_in'
    ));
});


add_action('rest_api_init', function () {
    register_rest_route("style-studio/v1", "delete_customer", array(
        'methods' => "DELETE",
        'callback' =>  array(customerController::class,"delete_customer"),
        'permission_callback' => 'is_user_logged_in'
    ));
});