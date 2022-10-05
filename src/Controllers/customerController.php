<?php

namespace Inc\Controllers;

use Inc\Base\Controller;
use Inc\Base\Message;
use Inc\Base\Validation;
use mysql_xdevapi\Exception;

class customerController extends Controller
{
    public static function get_form_customer()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => parent::$base_url . 'getHesabProperties',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
    "connectionString" :  ""
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $items = json_decode($response)->data;
        $final_data = array();
        foreach ($items as $item) {
            $object = array();
            $object['id'] = $item->id;
            $object['name'] = $item->name;
            switch ($item->valueType) {
                case 4:
                case 3:
                    $object['type'] = "dropdown";
                    $object['item'] = $item->items;
                    break;
                case 2:
                    if ($item->extraString == "#")
                        $object['type'] = "datepicker";
                    else
                        $object['type'] = "text";
                    $object['item'] = array();

            }
            $final_data[] = (object)$object;
        }

        return self::return_200($final_data);


    }

    public static function add_customer($request)
    {

        $fields = array(
            "sahm" => 0,
            "codeEghtesadi" => "",
            "poorsantAfzayeshi" => 0,
            "address" => "",
            "mob" => 9140013886,
            "tel" => 3155000000,
            "saghfeEtebar" => 0,
            "codeParent" => "120001",
            "bedehi" => 0,
            "bestani" => 0,
            "tozihat" => "",
            "idUser" => 1,
        );

        try {

            $curl = curl_init();
            $field_prop = array();
            $item_arr = array();
            $name = "";
            $family = "";
            foreach ($request->get_params() as $item) {
                /**
                 * check name or family
                 */
                if ($item['id'] == "63be9c5a-700d-4aa0-8f9a-67d82a897b56") {
                    $name = $item['value'];
                }
                if ($item['id'] == "e7a8fc68-fc08-44bf-ae5f-838178e57ebc") {
                    $family = $item['value'];
                }
                $item_arr['PID'] = $item['id'];
                if ($item['value_id'])
                    $item_arr['VID'] = $item['value_id'];
                else
                    $item_arr['VID'] = "00000000-0000-0000-0000-000000000000";
                $item_arr['V'] = $item['value'];
                $field_prop[] = (object)$item_arr;
            }

            $fields['name'] = $name . " " . $family;

            $fields['properties'] = $field_prop;
            $final_field = utilityController::convert_request_to_string($fields);
            curl_setopt_array($curl, array(
                CURLOPT_URL => parent::$base_url . 'addHesab',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $final_field,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response);
            if ($response->r) {
                $final_data = (object)array(
                    "customer_id" => $response->id
                );
                return rest_ensure_response(parent::return_200($final_data));
            } else {
                return rest_ensure_response(parent::return_500());
            }

        } catch (Exception) {
            return rest_ensure_response(parent::return_500());
        }
    }

    public static function search_customer($request)
    {

        $arr_error = Validation::validation_fields($request,
            array(
                "name" => "string|required"
            ));
        if ($arr_error)
            return rest_ensure_response(parent::return_406(Message::msg_406(implode(",", $arr_error))));

        $arr_field = array(
            "name" => $request->get_param("name"),
            "mob" => 9140013886,
            "tel" => 3155000000
        );
        $fields = utilityController::convert_request_to_string($arr_field);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => parent::$base_url . 'getHesabs',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $data = json_decode($response)->data;
        $arr_ids = array();

        foreach ($data as $obj) {
            if (!in_array($obj->hesabID, $arr_ids)) {
                $arr_ids[] = $obj->hesabID;
            }
        }
        $arr_final = array();
        foreach ($arr_ids as $id) {
            foreach ($data as $obj) {
                if ($obj->hesabID == $id) {
                    $arr_final[$id][] = $obj;
                }
            }
        }
       

        curl_close($curl);
        return rest_ensure_response(parent::return_200($arr_final));


    }

    public static function get_customer($request)
    {
        $arr_error = Validation::validation_fields($request,
            array(
                "id" => "string|required"
            ));
        if ($arr_error)
            return rest_ensure_response(parent::return_406(Message::msg_406(implode(",", $arr_error))));
        $fields = array(
            "id" => $request->get_param("id"),
            "idUser" => 1
        );
        $fields = utilityController::convert_request_to_string($fields);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => parent::$base_url . 'getHesabInfos',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        if ($response->error)
            return rest_ensure_response(self::return_500($response->error));
        return rest_ensure_response(parent::return_200($response));
    }

    public static function delete_customer($request)
    {
        $arr_error = Validation::validation_fields($request,
            array(
                "id" => "string|required"
            ));
        if ($arr_error)
            return rest_ensure_response(parent::return_406(Message::msg_406(implode(",", $arr_error))));
        $fields = array(
            "id" => $request->get_param("id"),
            "idUser" => 1
        );
        $fields = utilityController::convert_request_to_string($fields);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => parent::$base_url . 'deleteHesab',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        if ($response->error)
            return rest_ensure_response(self::return_500($response->error));
        return rest_ensure_response(parent::return_200($response));


    }


}