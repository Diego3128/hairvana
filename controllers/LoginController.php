<?php

namespace Controllers;
//import classes
use MVC\Router;
use Model\User;
use Classes\Email;

class LoginController
{
    // get and post: "/" (login)
    public static function login(Router $router)
    {
        //init alerts
        $alerts = User::getAlerts();
        //check when the form is sent
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            //create a user instance using only the email and password
            $auth = new User($_POST["user"]);
            //validate inputs
            $alerts = $auth->validateLogin();
            //if inputs are correct then check in db
            if (empty($alerts)) {
                //check email and bring an user with that email
                $user = User::where(column: "email", value: $auth->email);

                if ($user) {
                    //check if user is verified
                    if ($user->checkVerifiedAndPassword($auth->password)) {
                        //authenticate user (session is already started for the router)
                        $_SESSION["id"] = $user->id;
                        $_SESSION["name"] = $user->name . " " . $user->lastname;
                        $_SESSION["loggedin"] = true;
                        //check if it's an admin
                        if ($user->admin === "1") {
                            //admin
                            $_SESSION["admin"] = $user->admin ?? null;
                            header("location: /admin");
                        } else {
                            //client
                            header("location: /appointment");
                        }
                    };
                } else {
                    User::setAlert("error", "No existe un usuario con el correo: " . $auth->email);
                }
            }
        }
        $alerts = User::getAlerts();

        $data = [
            "alerts" => $alerts
        ];

        $router->render("auth/login", $data);
    }
    public static function logout(Router $router)
    {
        // $router->get(url: "/logout", fn: [LoginController::class, "logout"]);
        echo "/logout";
    }
    public static function forgotPass(Router $router)
    {
        $data = [];
        $router->render("auth/password-request", $data);
    }
    public static function resetPass(Router $router)
    {
        echo "/resetPass";
    }
    public static function create(Router $router)
    {
        // get and post, url: "/create-account"
        $user = new User;
        $alerts = User::getAlerts();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $user->synchronize($_POST["user"]);
            $user->validateInputs();
            $alerts = User::getAlerts();
            //
            if (empty($alerts)) {
                //check if the email already exists
                $result = $user->userExists();

                if ($result->num_rows > 0) {
                    $alerts = User::getAlerts();
                } else {
                    //create a hashed password
                    $user->hashPassword();
                    //create a token for email validation
                    $user->generateToken();
                    //send email with the token
                    $email = new Email($user->email, $user->name, $user->token);

                    if ($email->sendConfirmationEmail()) {
                        $result = $user->save();
                        if ($result) header("location: /message?email=" . $user->email);
                    }
                }
            }
        }
        $data = [
            "user" => $user,
            "alerts" => $alerts
        ];

        $router->render("auth/create-account", $data);
    }
    //message
    public static function message(Router $router)
    {
        $data = ["email" => $_GET["email"] ?? ''];
        $router->render("auth/message", $data);
    }

    //validate an account
    public static function validate(Router $router)
    {

        $token = stzr($_GET["token"]);

        $user = User::where("token", $token);

        if ($user) {
            User::setAlert("success", "Cuenta confirmada correctamente. Inicia sesión");
            //verify user
            $user->verified = "1";
            //delete token
            $user->token = null;
            $user->save();
        } else {
            User::setAlert("error", "Token invalido o expirado");
        }

        $alerts = User::getAlerts();

        $data = [
            "alerts" => $alerts
        ];

        $router->render("auth/validate-account", $data);
    }
}
