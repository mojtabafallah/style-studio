<?php

namespace Inc\Base;

if (!defined('ABSPATH')) {
    die;
}

class menu
{
    /**
     * add menu to admin handled by controller the extends menu class
     */
    public static function add_menu()
    {
        add_action("admin_menu", function () {
            add_menu_page(
                static::$data_menu['page_title'],
                static::$data_menu['title'],
                static::$data_menu['capability'],
                static::$data_menu['slug'],
                array(static::class, "add_views")
            );
        });
    }


    /**
     * add menu without controller
     */
    public static function add_menu_single($data_menu_single)
    {
        add_action("admin_menu", function () use ($data_menu_single) {
            add_menu_page(
                __($data_menu_single['page_title'], "kias_zephyr"),
                __($data_menu_single['title'], "kias_zephyr"),
                $data_menu_single['capability'],
                $data_menu_single['slug'],
                function () use ($data_menu_single) {
                    require_once $data_menu_single['path_view'];
                }
            );
        });
    }

    /**
     * add sub menu to admin handled by controller the extends menu class
     */
    public static function add_submenu()
    {
        add_action("admin_menu", function () {
            add_submenu_page(
                static::$data_menu['slug_parent'],
                __(static::$data_menu['page_title'], "kias_zephyr"),
                __(static::$data_menu['title'], "kias_zephyr"),
                static::$data_menu['capability'],
                static::$data_menu['slug'],
                array(static::class, "add_views")
            );
        });
    }

    /**
     * add views and handle add update delete
     */
    public static function add_views()
    {
        $model = static::$model;
        if (isset($_GET['item']) && $_GET['item'] == $model::$item) {
            switch ($_GET['action']) {
                case "add":
                    $button_name = "add_" . $model::$table_name;
                    if (isset($_POST[$button_name])) {
                        if (isset($_POST["field_" . $model::$item . "_add"]) && wp_verify_nonce($_POST["field_" . $model::$item . "_add"], "add_" . $model::$item)) {
                            $columns = $model::$columns;
                            $data = array();
                            foreach ($columns as $column => $type) {
                                $data[$column] = $_POST[$column];
                            }
                            /**
                             * save data
                             */
                            $model::create($data);
                            Notif::show("Success Created");
                        } else {
                            wp_die("No access");
                        }
                    }
                    require_once $model::get_form_action();
                    break;
                case "edit":
                    $button_name = "edit_" . $model::$table_name;
                    if (isset($_POST[$button_name])) {
                        if (isset($_POST["field_" . $model::$item . "_edit"]) && wp_verify_nonce($_POST["field_" . $model::$item . "_edit"], "edit_" . $model::$item)) {
                            $columns = $model::$columns;
                            $data = array();
                            foreach ($columns as $column => $type) {
                                $data[$column] = $_POST[$column];
                            }
                            if (isset($_GET['id_row']) && intval($_GET['id_row']) > 0)
                                $model::edit($data, $_GET['id_row']);
                            Notif::show("Success Updated");
                        } else {
                            wp_die("No access");
                        }
                    }
                    require_once $model::get_form_action();

                    break;
                case "delete":
                    if (isset($_GET['id_row']) && intval($_GET['id_row']) > 0)
                        $model::delete($_GET['id_row']);

                    $all_data_model = $model::all();
                    require_once $model::get_view();
                    Notif::show("Success Deleted");
                    break;
            }

        } else {

            $all_data_model = $model::all();
            require_once $model::get_view();

        }
    }

}