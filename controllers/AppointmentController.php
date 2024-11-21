<?php

namespace Controllers;

use MVC\Router;

class AppointmentController
{
    public static function index(Router $router)
    {
        isAuth();

        $data = [
            "id" => $_SESSION["id"],
            "username" => $_SESSION["name"]
        ];
        $router->render("appointment/index", $data);
    }
}
