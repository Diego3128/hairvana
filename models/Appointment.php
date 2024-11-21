<?php

namespace Model;

use Model\ActiveRecord;

class Appointment extends ActiveRecord
{
    //name of the table in db
    protected static $tableName = "appointments";
    // each column name of a certain table (same names)
    protected static $dbColumns = ["id", "date", "hour", "userId"];
    // Possible erros when trying to create an instance
    protected static $alerts = [];
    //attributes (columns)
    public $id;
    public $date;
    public $hour;
    public $userId;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? NULL;
        $this->date = $args["date"] ?? "";
        $this->hour = $args["hour"] ?? "";
        $this->userId = $args["userId"] ?? "";
    }
}
