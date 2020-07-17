<?php


namespace Euro\Response;


class Redirect
{
    public static function redirect(string $url) {
        echo header("Location: $url");
        exit(); //in case if the above code didn't work
    }
}