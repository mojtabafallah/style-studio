<?php

namespace Inc\Controllers;

class utilityController
{
    /**
     * create object for send to server
     * @param $request
     * @return string
     */
    public static function convert_request_to_string($request)
    {

        $request['connectionString'] = "";
//        wp_send_json(json_encode($request));
//
//        $str_final = '{
//         "connectionString" :  "",';
//        foreach ($request as $key => $item) {
//            if (!is_array($item))
//                $str_final .= '"' . $key . '" : "' . $item . '",';
//            else {
//                /**
//                 * if item is arrayed
//                 */
//                $str_final .= '"' . $key . '" : ["';
//
//                foreach ($item as $i) {
//                    $str_final .= json_encode($i);
//                }
//                $str_final .= "]";
//
//            }
//        }
//        $str_final = rtrim($str_final, ",");
//        $str_final .= "}";


        return json_encode($request);
    }

}