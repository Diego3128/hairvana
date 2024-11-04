<?php

namespace Controllers;
//import classes
use MVC\Router;
use Model\User;
use Classes\Email;

class LoginController
{
    public static function login(Router $router)
    {
        // get and post: "/" (login)
        $router->render("auth/login");
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
