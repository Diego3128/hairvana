<?php

namespace Controllers;

use DateTimeZone;
use Model\ActiveRecord;
use Model\AdminAppointment;
use MVC\Router;

class AdminController extends ActiveRecord
{
    public static function index(Router $router)
    {
        isAdmin();

        //setting the time zone
        date_default_timezone_set("America/Bogota");

        $appointments = [];

        $date = $_GET["date"] ?? date("Y-m-d");

        $splitDate = explode("-", $date);
        //validate date
        if (checkdate($splitDate[1], $splitDate[2], $splitDate[0])) {
            $query = "SELECT appointments.id, appointments.date, appointments.`hour` as 'time',";
            $query .= "CONCAT(users.name, ' ', users.lastname) AS 'customer', users.email AS 'customer_email',";
            $query .= "services.name AS 'service', services.price AS 'price' FROM appointments ";
            $query .= "LEFT OUTER JOIN users ON appointments.userId=users.id ";
            $query .= "LEFT OUTER JOIN appointments_services ON appointments.id=appointments_services.appointmentId ";
            $query .= "LEFT OUTER JOIN services ON appointments_services.serviceId=services.id WHERE appointments.date='{$date}' ";
            $query .= "ORDER BY appointments_services.appointmentId ASC";

            // debugAndFormat($query);
            $appointments = AdminAppointment::SQL($query);
            // debugAndFormat($appointments);    
        } else {
            $date = date("Y-m-d");
        }

        $data = [
            "username" => $_SESSION["name"],
            "appointments" => $appointments,
            "selectedDate" => $date
        ];

        $router->render("admin/index", $data);
    }
}
