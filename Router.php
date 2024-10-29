<?php

namespace MVC;

class Router
{
    public $getRoutes = [];
    public $postRoutes = [];
    //get routes
    public function get(string $url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }
    //post routes
    public function post(string $url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }
    //
    public function verifyRoutes()
    {
        //start session
        session_start();
        $auth = $_SESSION["loggedin"] ?? null;
        //protected routes
        $protectedRoutes = ["/no-protected-routes-yet"];
        //info about current request
        $currentUrl = $_SERVER["PATH_INFO"] ?? "/";
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        //identify request method
        if ($requestMethod === "GET") {
            //read function
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } elseif ($requestMethod === "POST") {
            //read function
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }
        //check protected routes
        if (in_array($currentUrl, $protectedRoutes) && !$auth) {
            header("location: /");
        }
        //check if the controller exists
        if ($fn) {
            call_user_func($fn, $this);
        } else {
            echo ("<h1>404</h1>");
        }
    }
    //show a view
    public function render(String $view, array $data = [])
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        ob_start(); //store output ad save it in memory

        include __DIR__ . "/views/$view.php"; //output being saved

        $content = ob_get_clean(); //clean buffer

        include __DIR__ . "/views/layout.php"; //include master layout
    }
}
