<?php


namespace Euro\Secure;


class AuthorizationMiddleware
{
    public static function userAuthorized() {
        return isset($_COOKIE["PHPSESSID"]) && isset($_SESSION["user_id"]);
    }
}