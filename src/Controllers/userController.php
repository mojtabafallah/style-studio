<?php

namespace Inc\Controllers;

use Inc\Base\Controller;
use Inc\Base\Message;
use Inc\Base\Validation;

use WP_User;

class userController  extends Controller
{

    public static function login($request)
    {
        $arr_error = Validation::validation_fields($request,
            array(
                "username" => "string|required",
                "password" => "string|required"
            ));
        if ($arr_error)
            return rest_ensure_response(parent::return_406(Message::msg_406(implode(",", $arr_error))));

        $response = wp_remote_post(get_site_url() . "/wp-json/jwt-auth/v1/token", array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array(),
                'body' => array(
                    'username' => $request->get_param("username"),
                    'password' => $request->get_param("password")
                ),
                'cookies' => array()
            )
        );


        $status_code = wp_remote_retrieve_response_code($response);
        switch ($status_code) {
            case 403:
                return rest_ensure_response(self::return_422("نام کاربری یا کلمه عبور نادرست است."));
            case 200:
                $body = json_decode(wp_remote_retrieve_body($response));

                $user_item = get_user_by("login", $request->get_param("username"));
                $final_data = (object)array();
                /**
                 * get role
                 */
                $roles = $user_item->roles;
                global $wp_roles;
                $arr_roles = array();
                $arr_cap = array();
                foreach ($roles as $role) {
                    $role_item = (object)array();
                    $role_item->key = $role;
                    $role_ = get_role($role);
                    array_push($arr_cap, $role_->capabilities);
                    $role_item->title = $wp_roles->roles[$role]['name'];
                    array_push($arr_roles, $role_item);
                }
                $final_data->roles = $arr_roles;
                /**
                 * get cap
                 */
                $final_cap = array();
                foreach ($arr_cap as $item) {
                    foreach ($item as $key => $i) {
                        array_push($final_cap, strtoupper($key));
                    }
                }
                $final_data->permissions = $final_cap;
                $final_data->token = $body->token;

                /**
                 * get first name
                 */
                $final_data->displayname =  $user_item->display_name;


                return rest_ensure_response(self::return_200($final_data, "ورود با موفقیت انجام شد."));
        }


    }

    public static function get_user()
    {
        $user_id = get_current_user_id();
        $user_item = get_user_by("id", $user_id);
        $final_data = (object)array();
        $final_data->id = $user_id;
        $final_data->name = $user_item->first_name ?: $user_item->user_login;
        $final_data->avatar = get_avatar_url($user_id);
        $final_data->email = $user_item->user_email;


        /**
         * get role
         */
        $roles = $user_item->roles;

        $arr_roles = array();
        $arr_cap = array();
        foreach ($roles as $role) {
            $role_item = (object)array();
            $role_item->key = $role;
            $role_ = get_role($role);
            array_push($arr_cap, $role_->capabilities);
            $role_item->title = $role_->name;
            array_push($arr_roles, $role_item);
        }
        $final_data->roles = $arr_roles;
        /**
         * get cap
         */
        $final_cap = array();
        foreach ($arr_cap as $item) {
            foreach ($item as $key => $i) {
                array_push($final_cap, strtoupper($key));
            }
        }
        $final_data->permissions = $final_cap;
        return self::return_200($final_data);
    }


}