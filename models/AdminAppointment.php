<?php

namespace Model;

class AdminAppointment extends ActiveRecord
{
    // each column name of a certain table (same names)
    protected static $dbColumns = ["id", "date", "time", "customer", "customer_email", "service", "price"];
    // Possible erros when trying to create an instance
    protected static $alerts = [];

    public $id;
    public $date;
    public $time;
    public $customer;
    public $customer_email;
    public $service;
    public $price;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->date = $args["date"] ?? "";
        $this->time = $args["time"] ?? "";
        $this->customer = $args["customer"] ?? "";
        $this->customer_email = $args["customer_email"] ?? "";
        $this->service = $args["service"] ?? "";
        $this->price = $args["price"] ?? "";
    }
}
