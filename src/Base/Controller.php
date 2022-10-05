<?php

namespace Inc\Base;

use WP_REST_Response;

class Controller extends menu
{
    protected static $base_url = "https://atrisa-co.com/api/PublicAPI/";

    public static function return_404($message = "")
    {

        $result = (object)[];
        $result->success = false;
        $result->message = $message;
        $result->result = "not found";
        $result->status = 404;
        $response = new WP_REST_Response();
        $response->set_status(404);
        $response->set_data($result);
        return $response;
    }

    public static function return_200($data, $message = "")
    {
        $result = (object)[];
        $result->success = true;
        $result->message = $message;
        $result->result = $data;
        $result->status = 200;
        return $result;
    }

    public static function return_400($message = "")
    {
        $result = (object)[];
        $result->success = false;
        $result->message = $message;
        $result->result = "Fields not submitted correctly";
        $result->status = 400;
        $response = new WP_REST_Response();
        $response->set_status(400);
        $response->set_data($result);
        return $response;
    }

    public static function return_401($message = "")
    {
        $result = (object)[];
        $result->success = false;
        $result->message = $message;
        $result->result = "Fields not submitted correctly";
        $result->status = 401;
        $response = new WP_REST_Response();
        $response->set_status(401);
        $response->set_data($result);
        return $response;
    }


    public static function return_429($message = "")
    {
        $result = (object)[];
        $result->success = false;
        $result->message = $message;
        $result->result = "Fields not submitted correctly";
        $result->status = 429;
        $response = new WP_REST_Response();
        $response->set_status(429);
        $response->set_data($result);
        return $response;
    }

    public static function return_500($message = "مشکلی به وجود آمده است")
    {
        $result = (object)[];
        $result->success = false;
        $result->message = $message;
        $result->result = "Fields not submitted correctly";
        $result->status = 500;
        $response = new WP_REST_Response();
        $response->set_status(500);
        $response->set_data($result);
        return $response;
    }

    public static function return_409($message = "")
    {

        $result = (object)[];
        $result->success = false;
        $result->message = $message;
        $result->result = "The item is not valid";
        $result->status = 409;
        $response = new WP_REST_Response();
        $response->set_status(409);
        $response->set_data($result);
        return $response;
    }

    public static function return_406(string $message = "")
    {
        $result = (object)[];
        $result->success = false;
        $result->message = $message;
        $result->result = "The fields are wrong";
        $result->status = 406;
        $response = new WP_REST_Response();
        $response->set_status(406);
        $response->set_data($result);
        return $response;
    }

    public static function return_403(string $message = "")
    {
        $result = (object)[];
        $result->success = false;
        $result->message = $message;
        $result->result = "forbidden";
        $result->status = 403;
        $response = new WP_REST_Response();
        $response->set_status(403);
        $response->set_data($result);
        return $response;
    }

    public static function return_422(string $message = "")
    {
        $result = (object)[];
        $result->success = false;
        $result->message = $message;
        $result->result = "forbidden";
        $result->status = 422;
        $response = new WP_REST_Response();
        $response->set_status(422);
        $response->set_data($result);
        return $response;
    }


}