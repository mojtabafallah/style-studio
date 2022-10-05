<div class="wrap">
    <h1>تنظیمات پلاگین</h1>
    <form action="" method="post">
        <table class="form-table">
            <tbody>
            <?php

            wp_nonce_field("save_setting","field_nonce_save_setting")?>
            <tr valign="top">
                <th scope="row">پیام صفحه ورود</th>
                <td>
                    <textarea name="message_login" id="" cols="30" rows="10"><?php echo get_option("message_login_style_studio")?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"></th>
                <td>
                    <input  class="button button-primary" name="save_setting_style_studio" type="submit" value="ذخیره تنظیمات">

                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
