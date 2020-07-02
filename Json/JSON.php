<?php


namespace Euro\Json;


class JSON
{
    public static $_JSON = array();
    public static $_QUERY_PARAMETERS = array();

    public static function initializeJson()
    {
        JSON::$_JSON = json_decode(file_get_contents('php://input'), true);
    }

    public static function initializeQueryParams($params)
    {
        $fullParams = explode('&', $params);
        foreach ($fullParams as $param) {
            $param = explode('=', $param);
            self::$_QUERY_PARAMETERS[$param[0]] = $param[1];
        }
    }


}

function json(string $var) {
    return JSON::$_JSON[$var];
}

function queryParameter(string $var) {
    return JSON::$_QUERY_PARAMETERS[$var];
}
