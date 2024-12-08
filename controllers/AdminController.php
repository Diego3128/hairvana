<?php

namespace Controllers;

use Model\ActiveRecord;
use Model\AdminAppointment;
use MVC\Router;

class AdminController extends ActiveRecord
{
    public static function index(Router $router)
    {
        isAuth();

        $query = "SELECT appointments.id, appointments.date, appointments.`hour` as 'time',";
        $query .= "CONCAT(users.name, ' ', users.lastname) AS 'customer', users.email AS 'customer_email',";
        $query .= "services.name AS 'service', services.price AS 'price' FROM appointments ";
        $query .= "LEFT OUTER JOIN users ON appointments.userId=users.id ";
        $query .= "LEFT OUTER JOIN appointments_services ON appointments.id=appointments_services.appointmentId ";
        $query .= "LEFT OUTER JOIN services ON appointments_services.serviceId=services.id ";
        $query .= "ORDER BY appointments_services.appointmentId ASC";
        // $query .= "WHERE date={$date}";
        $appointments = AdminAppointment::SQL($query);

        // debugAndFormat($appointments);

        $data = [
            "username" => $_SESSION["name"],
            "appointments" => $appointments
        ];

        $router->render("admin/index", $data);
    }
}
