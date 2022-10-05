<?php

namespace Inc\Base;

use DateTime;

class Validation
{
    public static function validation_fields($data, $arr_roles, $type = "request", $have_file = false)
    {
        $array_fields_errors = array();
        foreach ($arr_roles as $key => $roles) {
            $arr_role = explode("|", $roles);
            /**
             * detect type
             */
            switch ($type) {
                case "request":
                    /**
                     * get param from request
                     */
                    $param_file = $data->get_file_params($key);
                    $param = $data->get_param($key);
                    break;
                case "object":

                    /**
                     * get item from object
                     */
                    $param = $data[$key];
                    break;
                case "array":
                    /**
                     * get value from array
                     */
                    $param = $data[$key];
                    break;
            }
            $is_required = in_array("required", $arr_role);
            if ($is_required) {
                if ((isset($param)) || (isset($param_file) && $param_file)) {
                    foreach ($arr_role as $role) {
                        switch ($role) {
                            case "not_empty":
                                if (empty($param)) array_push($array_fields_errors, $key);
                                break;
                            case "int":
                                if (!is_int($param)) {
                                    array_push($array_fields_errors, $key);
                                }
                                break;
                            case "string":
                                if (!is_string($param)) array_push($array_fields_errors, $key);
                                break;
                            case "date":
                                if (!self::is_date($param)) {
                                    array_push($array_fields_errors, $key);
                                }
                                break;
                            case "phone_iran":
                                if (!preg_match("/^(0|\+98)?9\d{9}$/", $param)) array_push($array_fields_errors, $key);
                                break;
                            case "array":
                                if (!is_array($param)) array_push($array_fields_errors, $key);
                                break;
                            case "file":
                                if (!is_file($param_file[$key]['tmp_name'])) array_push($array_fields_errors, $key);
                                break;
                            case "bool":
                                if (!is_bool($param)) array_push($array_fields_errors, $key);
                                break;

                        }
                    }
                } else {
                    array_push($array_fields_errors, $key);
                }
            } else {

                if ((isset($param) && $param) || (isset($param_file) && $param_file)) {
                    foreach ($arr_role as $role) {
                        switch ($role) {
                            case "not_empty":
                                if (empty($param)) array_push($array_fields_errors, $key);
                                break;
                            case "int":

                                if (!is_int($param)) {
                                    array_push($array_fields_errors, $key);
                                }
                                break;
                            case "string":
                                if (isset($param))
                                    if (!is_string($param)) array_push($array_fields_errors, $key);
                                break;
                            case "date":
                                if (!self::is_date($param)) {
                                    array_push($array_fields_errors, $key);
                                }
                                break;
                            case "phone_iran":
                                if (!preg_match("/^(0|\+98)?9\d{9}$/", $param)) array_push($array_fields_errors, $key);
                                break;
                            case "array":
                                if (!is_array($param)) array_push($array_fields_errors, $key);
                                break;
                            case "file":
                                if (!is_file($param_file[$key]['tmp_name'])) array_push($array_fields_errors, $key);
                                break;
                            case "bool":
                                if (!is_bool($param)) array_push($array_fields_errors, $key);
                                break;
                        }
                    }
                }
            }

        }

        return array_unique($array_fields_errors);


    }

    private static function is_date($date, $format = 'Y/m/d')
    {
        if (strpos($date, "/")) {
            $format = 'Y/m/d';
        } elseif (strpos($date, "-")) {
            $format = 'Y-m-d';
        }
        $dt = DateTime::createFromFormat($format, $date);
        return $dt && $dt->format($format) === $date;
    }

}