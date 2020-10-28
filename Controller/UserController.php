<?php


namespace Euro\Controller;


use Euro\Response\Response;

class UserController
{
    public static function getUserByToken(string $token) {
        Response::json(json_encode($_SESSION));
    }
}