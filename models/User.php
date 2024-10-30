<?php

namespace Model;

class User extends ActiveRecord
{
    //name of the table in db
    protected static $tableName = 'users';
    // each column name of a certain table (same names)
    protected static $dbColumns = ['id', 'name', 'lastname', 'email', 'password', 'phone', 'admin', 'verified', 'token', 'created'];
    // Possible erros when trying to create an instance
    protected static $alerts = ['user' => "user"];

    //attributes (columns)
    public $id;
    public $name;
    public $lastname;
    public $email;
    public $password;
    public $phone;
    public $admin;
    public $verified;
    public $token;

    public function __construct(array $args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->lastname = $args['lastname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->phone = $args['phone'] ?? '';
        $this->admin = $args['admin'] ?? null;
        $this->verified = $args['verified'] ?? null;
        $this->token = $args['token'] ?? '';
        // debugAndFormat("working");
    }
    //validation alerts
    public function validateInputs(): array
    {
        static::$alerts = [];

        if (!$this->name) self::$alerts["error"][] = "El nombre es obligatorio";

        if (!$this->lastname) self::$alerts["error"][] = "El apellido es obligatorio";

        if (strlen($this->phone) > 10 || !preg_match('/^[0-9]{10}$/', $this->phone)) self::$alerts["error"][] = "El telefono es invalido";

        if (!preg_match("/^[\w\.\-]+@[a-zA-Z\d\-]+\.[a-zA-Z]{2,}$/", $this->email)) self::$alerts["error"][] = "El correo es invalido";

        if (!$this->password) {
            self::$alerts["error"][] = "La contraseña es necesaria";
        } elseif (strlen($this->password) < 6) {
            self::$alerts["error"][] = "La contraseña es muy corta. Al menos 6 caracteres.";
        }

        return self::$alerts;
    }
}
