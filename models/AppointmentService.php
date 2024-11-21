<?php

namespace Model;

class AppointmentService extends ActiveRecord
{
    //name of the table in db
    protected static $tableName = "appointments_services";
    // each column name of a certain table
    protected static $dbColumns = ["id", "appointmentId", "serviceId"];
    // Possible erros when trying to create an instance
    protected static $alerts = ['AppoinmentService' => "AppoinmentService"];

    //attributes (table columns)
    public $id;
    public $appointmentId;
    public $serviceId;
    //
    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->appointmentId = $args["appointmentId"] ?? '';
        $this->serviceId = $args["serviceId"] ?? '';
    }
}
