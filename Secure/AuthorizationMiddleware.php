<?php


namespace Icc\Secure;


class AuthorizationMiddleware
{
    public static function userAuthorized() {
        return JWTSecurity::validateToken();
    }
}