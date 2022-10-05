<?php

namespace Inc\Base;

class Message
{
    public static function msg_404($name = "آیتم")
    {
        return $name . " مورد نظر پیدا نشد.";
    }

    public static function msg_400($name = "آیتم")
    {
        return "فیلد های " . $name . " ناقص میباشد.";
    }

    public static function msg_200($name = "آیتم", $type = "",$message="")
    {
        switch ($type) {
            case "custom":
                return $message;
            case "create":
                return $name . " با موفقیت ایجاد گردید.";
            case "delete":
                return $name . " با موفقیت حذف گردید.";
            case "edit":
                return $name . " با موفقیت ویرایش گردید.";
            default :
                return "عملیات با موفقیت انجام شد.";

        }

    }

    public static function msg_500()
    {
        return " عملیات با شکست مواجه شد.";
    }

    public static function msg_406(string $fields)
    {
        return "فیلد های " . $fields . " اشتباه میباشد.";
    }

    public static function msg_409(string $string)
    {
        return $string . " از قبل وجود دارد.";
    }
}