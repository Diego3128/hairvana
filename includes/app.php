<?php
require __DIR__ . '/../vendor/autoload.php';

//Main class active record
use Model\ActiveRecord;
// ent variables
use Dotenv\Dotenv;

require 'functions.php';
//get .env file
$dotenv = Dotenv::createImmutable(__DIR__); //route to where the .env file is located.
$dotenv->safeLoad();

// debugAndFormat($_ENV);

//use environment variables inside this file to set the connection
require 'database.php';

ActiveRecord::setDB($db);
