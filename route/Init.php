<?php

use Inc\Controllers\initController;

add_action('rest_api_init', function () {
    remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );

    register_rest_route("style-studio/v1", "init", array(
        'methods' => "GET",
        'callback' =>  array(initController::class,"init")
    ));
});