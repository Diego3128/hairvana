<?php

namespace Model;

class Service extends ActiveRecord
{
    //name of the table in db
    protected static $tableName = "services";
    // each column name of a certain table
    protected static $dbColumns = ["id", "name", "price"];
    // Possible erros when trying to create an instance
    protected static $alerts = ['service' => "service"];

    //attributes (columns)
    public $id;
    public $name;
    public $price;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->name = $args["name"] ?? "";
        $this->price = $args["price"] ?? "";
    }
}
