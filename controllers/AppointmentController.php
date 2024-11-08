<?php

namespace Controllers;

use MVC\Router;

class AppointmentController
{
    public static function index(Router $router)
    {

        $data = [
            "username" => $_SESSION["name"]
        ];
        $router->render("appointment/index", $data);
    }
}
