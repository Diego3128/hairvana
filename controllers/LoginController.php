<?php

namespace Controllers;

use MVC\Router;

class LoginController
{

    public static function login(Router $router)
    {
        $router->render("auth/login");
    }
    public static function logout(Router $router)
    {
        echo "/logout";
    }
    public static function forgotPass(Router $router)
    {
        $data = [];
        $router->render("auth/password-request", $data);
    }
    public static function resetPass(Router $router)
    {
        echo "/resetPass";
    }
    public static function create(Router $router)
    {
        $router->render("auth/create-account");
    }
}
