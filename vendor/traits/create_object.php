<?php
namespace vendor\traits;

trait create_object
{
    protected static function get_objects()
    {
        if(!self::$object){
            $new_class = get_called_class();
            self::$object = new $new_class();
        }
        return self::$object;
    }
    public static function object()
    {
        return self::get_objects();
    }

    private static function check_object()
    {
        if(self::$object){
            return true;
        }
        return false;
    }
    protected static $object;
}