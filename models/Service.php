<?php

namespace Model;

class Service extends ActiveRecord
{
    //name of the table in db
    protected static $tableName = "services";
    // each column name of a certain table
    protected static $dbColumns = ["id", "name", "price"];
    // Possible erros when trying to create an instance
    protected static $alerts = [];

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

    //validation alerts
    public function validateInputs(): array
    {
        static::$alerts = [];

        if (!$this->name) self::$alerts["error"][] = "El nombre es obligatorio";

        if (!$this->price) self::$alerts["error"][] = "El precio es obligatorio";

        if (!is_numeric($this->price) || strlen($this->price) > 3) self::$alerts["error"][] = "Precio invalido";

        return self::$alerts;
    }
}
