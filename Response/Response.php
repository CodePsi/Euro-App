<?php


namespace Euro\Response;


use Icc\Json\JSON;

class Response
{
    public static function text(string $responseMessage): void {
        print $responseMessage;
    }

    public static function json(string $json): void {
        if (ResponseDataReceiver::isJson($json)) {
            print $json;
        } else {
            self::json(json_encode(array("error_message" => "Passed json is invalid")));
        }
    }


}