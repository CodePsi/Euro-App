<?php

/**
 * Create the Application
 * -------------------------
 * Initialization and binding.
 *
 */

use Euro\Response\ResponseDataReceiver;
use Euro\Route\Router;

require __DIR__ . "/../vendor/autoload.php";

require "route.php";


ResponseDataReceiver::initializeJson();
session_start();
$router = Router::createRouter();
//include "Json/JSON.php";

if ($_SERVER['REDIRECT_STATUS'] != 200) {
    $router -> runPath('errorPage' . $_SERVER['REDIRECT_STATUS']);
}
$router -> runPath($_SERVER['REQUEST_URI']);
