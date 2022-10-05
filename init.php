<?php

/**
 * define roles
 */

add_role(
    "atelier",
    "آتلیه",
    "manage_options"
);

add_role(
    "hospital",
    "بیمارستان",
    "manage_options"
);


/**
 * menu setting
 */
add_action("admin_menu", function () {
    add_menu_page("تنظیمات پلاگین",
        "تنظیمات پلاگین",
        "manage_options",
        "mjt-style-studio",
        function () {
            if (isset($_POST['save_setting_style_studio'])) {
                if (isset($_POST['field_nonce_save_setting']) && wp_verify_nonce($_POST['field_nonce_save_setting'], "save_setting")) {
                    update_option("message_login_style_studio", $_POST['message_login']);
                    echo '<div class="notice notice-success ">
             <p>تنظیمات با موفقیت ذخیره شد.</p>
         </div>';


                }
            }
            require_once MJT_PLUGIN_DIR . "/src/views/setting.php";
        });
});


/**
 * sub menu fields factor
 */

add_action("admin_menu", function () {
    add_submenu_page(
        "mjt-style-studio",
        "فیلدهای فاکتور",
        "فیلدهای فاکتور",
        "manage_options",
        "mjt-fields-factor",

        function () {
            if (isset($_POST['save_setting_style_studio'])) {
                if (isset($_POST['field_nonce_save_setting']) && wp_verify_nonce($_POST['field_nonce_save_setting'], "save_setting")) {
                    update_option("message_login_style_studio", $_POST['message_login']);
                    echo '<div class="notice notice-success ">
             <p>تنظیمات با موفقیت ذخیره شد.</p>
         </div>';


                }
            }
            require_once MJT_PLUGIN_DIR . "/src/views/fields.php";
        }
    );
});

