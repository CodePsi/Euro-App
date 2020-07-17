<?php

namespace Euro\Controller;

use Euro\Dao\UserDao;

class LoginController
{
    public static function login($login, $password) {
        $userDao = new UserDao();
        $user = $userDao -> where(array("Name", "pass"), array("'$login'", "'$password'"), array("="));
        if (count($user) >= 1) {
            http_response_code(200);

            $_SESSION['user_id'] = $user[0][0];
            $_SESSION['name'] = $user[0][1];
            $_SESSION['is_admin'] = $user[0][5];
//            $_SESSION['password'] = $user[0][2];
            echo json_encode(array("response" => "Success"));
        } else {
            http_response_code(403);
            echo json_encode(array("response" => "Wrong data"));
        }
    }
}