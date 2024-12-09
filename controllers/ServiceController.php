<?php

namespace Controllers;

use Model\Service;
use MVC\Router;

class ServiceController
{
    //show all services in "/services"
    public static function index(Router $router)
    {
        isAdmin();

        $services = Service::all();
        // debugAndFormat($services);

        $data = [
            "username" => $_SESSION["name"],
            "services" => $services
        ];

        $router->render("services/index", $data);
    }
    //create a new service in "/services/create"
    public static function create(Router $router)
    {
        isAdmin();

        $service = new Service;
        $alerts = $service->getAlerts();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $service->synchronize($_POST["service"]);

            $alerts = $service->validateInputs();

            if (empty($alerts)) {
                //save the new service and redirect
                $service->save();
                header("location: /services");
            }
        }
        $data = [
            "username" => $_SESSION["name"],
            "service" => $service,
            "alerts" => $alerts
        ];

        $router->render("services/create", $data);
    }
    //update a service, receiving its id "/services/update?id=1"
    public static function update(Router $router)
    {
        isAdmin();

        $serviceId = $_GET["id"];
        //validate valid number
        if (!is_numeric($serviceId)) header("location: /services");

        $service = Service::findById($serviceId);
        //validate existing service
        if (!$service) header("location: /services");
        //errors
        $alerts = $service->getAlerts();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // synchronize object in memory with changes made by the user
            $service->synchronize($_POST["service"]);
            //validate changes
            $alerts = $service->validateInputs();
            // if everything is correct then update the service
            if (empty($alerts)) {
                //update the service and redirect
                $service->save();
                header("location: /services");
            }
        }

        $data = [
            "username" => $_SESSION["name"],
            "service" => $service,
            "alerts" => $alerts
        ];

        $router->render("services/update", $data);
    }

    public static function delete()
    {
        isAdmin();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $serviceId = $_POST["id"];
            //validate valid number
            if (!is_numeric($serviceId)) header("location: /services");

            $service = Service::findById($serviceId);
            //validate existing service
            if (!$service) header("location: /services");

            //delete service and redirect

            $service->delete();
            header("location: /services");
        }
    }
}
