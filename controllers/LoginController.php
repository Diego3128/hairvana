<?php

namespace Controllers;

use MVC\Router;
use Model\User;

class LoginController
{
    public static function login(Router $router)
    {
        // get and post: "/" (login)
        $router->render("auth/login");
    }
    public static function logout(Router $router)
    {
        // $router->get(url: "/logout", fn: [LoginController::class, "logout"]);
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
        // get and post, url: "/create-account"
        $user = new User;
        $alerts = User::getAlerts();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $user->synchronize($_POST["user"]);
            $user->validateInputs();
            $alerts = User::getAlerts();
            if (empty($alerts)) {
                //check if the email already exists

                //create the user
            }
        }
        $data = [
            "user" => $user,
            "alerts" => $alerts
        ];

        $router->render("auth/create-account", $data);
    }
}
