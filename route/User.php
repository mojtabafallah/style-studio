<?php


use Inc\Controllers\userController;


add_action('rest_api_init', function () {
//    remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );

    register_rest_route("style-studio/v1", "login", array(
        'methods' => "POST",
        'callback' => array(userController::class, "login")
    ));


});
add_action('rest_api_init', function () {
    register_rest_route("style-studio/v1", "get_user", array(
        'methods' => "GET",
        'callback' => array(userController::class, "get_user")
    ));
});