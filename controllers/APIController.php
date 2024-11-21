<?php

namespace Controllers;

use Model\Appointment;
use Model\AppointmentService;
use Model\Service;

class APIController
{

    public static function index()
    {
        $services = Service::all();

        echo json_encode($services, JSON_UNESCAPED_UNICODE);
    }
    //receive a new appointment
    public static function save()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            //save an appointment and return the id
            $appointment = new Appointment($_POST);
            //services id
            $serviceId = explode(",", $_POST["services"]);
            //result containing info about the query
            $result = $appointment->save();

            if ($result["result"]) {
                $appointmentId = $result["information"]["insert_id"];
                //create and appointment-service record for each id (service) realted with the appointment id
                foreach ($serviceId as $servId) {
                    $args = [
                        "serviceId" => $servId,
                        "appointmentId" => $appointmentId
                    ];
                    $appointmentService = new AppointmentService($args);
                    $appointmentService->save();
                }
                echo json_encode($result);
            } else {
                echo json_encode(["result" => false]);
            }
        }
    }
}
