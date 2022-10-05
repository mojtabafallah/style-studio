<?php

namespace Inc\Controllers;

use Inc\Base\Controller;
use Inc\Base\Message;

class initController extends Controller
{
    public static function init()
    {
        $message_login = get_option("message_login_style_studio");
        $final_data = array(
            "message_login" => $message_login
        );
        return self::return_200($final_data);
    }

}