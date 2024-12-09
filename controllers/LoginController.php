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
                            $_SESSION["admin"] = true;
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

        $_SESSION = [];
        header("location: /");
    }
    public static function forgotPass(Router $router)
    {
        $alerts = User::getAlerts();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $auth = new User($_POST);
            $alerts = $auth->validateEmail();

            if (empty($alerts)) {
                //check if the user exists and verified
                $user = User::where("email", $auth->email);

                if ($user && $user->verified === "1") {
                    //Create and save a new token
                    $user->generateToken();
                    $user->save();
                    //send email
                    $email = new Email($user->email, $user->name, $user->token);
                    if ($email->sendInstructions()) {
                        User::setAlert("success", "Revisa tu correo: " . $user->email . " para más información.");
                    } else {
                        User::setAlert("error", "No se pudo enviar un email de recuperación. Intenta más tarde.");
                    }
                } else {
                    User::setAlert("error", "La cuenta no existe o no está verificada");
                }
            }
        }

        $alerts = User::getAlerts();

        $data = [
            "alerts" => $alerts
        ];

        $router->render("auth/password-request", $data);
    }
    public static function resetPass(Router $router)
    {
        $alerts = User::getAlerts();
        //get token from the URL
        $token = stzr($_GET["token"]) ?? null;
        if (!$token) header("location: /");
        //find an user with that token
        $user = User::where("token", $token);
        //if true the form to update it will not be shown
        $accessError = false;
        //check if the token belongs to a user
        if (!$user) {
            $accessError = true;
            User::setAlert("error", "Token invalido o expirado");
        }
        //read the new password
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $newPassword = $_POST["password"] ?? '';
            //assign and validate the new password
            $user->password = $newPassword;
            $alerts = $user->validatePassword();

            if (empty($alerts)) {
                //create a hashed password and delete token
                $user->hashPassword();
                $user->token = null;
                //update the user
                if ($user->save()) {
                    header("location: /");
                } else {
                    User::setAlert("error", "No se pudo actualizar la contraseña. Intenta mas tarde..");
                }
            }
        }
        $alerts = User::getAlerts();

        $data = [
            "alerts" => $alerts,
            "accessError" => $accessError
        ];

        $router->render("auth/password-recover", $data);
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
                        if ($result["result"]) header("location: /message?email=" . $user->email);
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
