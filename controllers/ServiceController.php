<?php

namespace Controllers;

use MVC\Router;

class ServiceController
{
    //show all services in "/services"
    public static function index(Router $router)
    {
        $router->render("services/index");
        echo "here all services";
    }
    //create a new service in "/services/create"
    public static function create()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            echo " post create a service";
        }
        echo "get create a service";
    }

    public static function update()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            echo "post update  a service";
        }

        echo "get update a service";
    }

    public static function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            echo "post delete  a service";
        }
    }
}
