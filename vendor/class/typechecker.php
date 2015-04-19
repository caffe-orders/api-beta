<?php
class TypeChecker
{
    //
    //return bool
    //
    public static function IsInt($value)
    {
        if(preg_match("/[0-9]$/", $value))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    //
    //return bool
    //
    public static function IsNickname($value)
    {
        if(preg_match("/^[a-z0-9_-]{3,16}$/", $value))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    //
    //return bool
    //
    public static function IsPassword($value)
    {
        if(preg_match("/^[a-z0-9_-]{3,16}$/", $value))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    //
    //return bool
    //
    public function IsEmail($value)
    {
        if(filter_var($value, FILTER_VALIDATE_EMAIL))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    //
    //return bool
    //
    public function IsBool($value)
    {
        if(filter_var($value, FILTER_VALIDATE_BOOLEAN))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    //
    //return bool FIX FIX FIX FIX FIX FIX FIX FIX FIX FIX FIX FIX
    //
    public function IsPlace($value)
    {
        $whiteList = array(
            'Кафе',
            'Ресторан',
            'Бар'
        );
        if(in_array($value, $whiteList))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    //
    //return bool
    //
    public function IsHitCategory($value)
    {
        $whiteList = array(
            'place',
            'order'
        );
        if(in_array($value, $whiteList))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>