<?php


namespace Euro\Response;


class ResponseDataReceiver
{
    public static $_JSON = array();
    public static $_QUERY_PARAMETERS = array();

    public static function initializeJson()
    {
        self::$_JSON = json_decode(file_get_contents('php://input'), true);
    }

    public static function initializeQueryParams($params)
    {
        $fullParams = explode('&', $params);
        foreach ($fullParams as $param) {
            $param = explode('=', $param);
            self::$_QUERY_PARAMETERS[$param[0]] = $param[1];
        }
    }

    public static function isStrRepresentJson(string $strJson) {
        $json = json_decode($strJson);
        return $json && $strJson != $json;
    }

    public static function isJson($json) {
        return !empty($json) && is_string($json) && is_array(json_decode($json, true)) && json_last_error() == 0;
    }
}

function json(string $var) {
    return isset(ResponseDataReceiver::$_JSON[$var]) ? ResponseDataReceiver::$_JSON[$var] : null;
}

function queryParameter(string $var) {
    if (isset(ResponseDataReceiver::$_QUERY_PARAMETERS[$var]))
        return ResponseDataReceiver::$_QUERY_PARAMETERS[$var];
    return null;
}
