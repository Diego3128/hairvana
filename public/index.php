<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/app.php';

//import classes
use MVC\Router;
use Controllers\LoginController;
use Controllers\AppointmentController;

$router = new Router();

//ROUTES
//login
$router->get(url: "/", fn: [LoginController::class, "login"]);
$router->post(url: "/", fn: [LoginController::class, "login"]);
$router->get(url: "/logout", fn: [LoginController::class, "logout"]);
//create new account
$router->get(url: "/create-account", fn: [LoginController::class, "create"]);
$router->post(url: "/create-account", fn: [LoginController::class, "create"]);
//generate new password
$router->get(url: "/password-request", fn: [LoginController::class, "forgotPass"]);
$router->post(url: "/password-request", fn: [LoginController::class, "forgotPass"]);
$router->get(url: "/password-reset", fn: [LoginController::class, "resetPass"]);
$router->post(url: "/password-reset", fn: [LoginController::class, "resetPass"]);
//confirm account
$router->get(url: "/message", fn: [LoginController::class, "message"]);
$router->get(url: "/validate-account", fn: [LoginController::class, "validate"]);
//private area
$router->get(url: "/appointment", fn: [AppointmentController::class, "index"]);

//check routes
$router->verifyRoutes();
