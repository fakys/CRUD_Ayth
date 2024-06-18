<?php
namespace vendor\auth;

class Auth
{
    public static function auth($user)
    {
        $_SESSION['user'] = $user->toArray();
    }
    public static function logout()
    {
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
        }
    }
    public static function auth_user()
    {
        return isset($_SESSION['user']);
    }
    public static function user()
    {
        if(isset($_SESSION['user'])){
            return $_SESSION['user'];
        }
    }
}