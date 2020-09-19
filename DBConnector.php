<?php
namespace Euro;

use Euro\Response\JsonResponseBuilder;
use Euro\Response\Response;
use mysqli;
use mysqli_result;

class DBConnector
{
    public static $mysqli;
    public function __construct($host="localhost", $user="root", $password="", $database="Euro-App")
    {
        if (self::$mysqli == null) {
            self::$mysqli = new mysqli($host, $user, $password, $database);
            if (self::$mysqli->connect_errno) {
                echo "Error during connecting to the database! Error: " . self::$mysqli -> connect_error;
            }
        }
    }


    /**
     * Improved wrapper for the @link mysqli::query() function.
     *
     * @param $query
     * @return bool|mysqli_result
     */
    public function execute_query($query) {
        $queryResult = self::$mysqli -> query($query);
        if (self::isSqlErrorOccurred()) {
            Response::json(JsonResponseBuilder::createResponse()
                -> addNewJsonItem("error_message", "Sql error occurred: " . self::$mysqli -> error)
                -> build());
            return false;
        }

        return $queryResult;
    }

    public function close() {
        self::$mysqli -> close();
    }

    public function getLastInsertedId() {
        return self::$mysqli -> insert_id;
    }

    public static function getStatus() {
        return self::isSqlErrorOccurred() ? "Success" : self::$mysqli -> error;
    }

    private static function isSqlErrorOccurred() {
        return !empty(self::$mysqli -> error);
    }
}

