<?php

namespace Controllers;

use Model\Service;

class APIController
{

    public static function index()
    {
        $services = Service::all();

        echo json_encode($services, JSON_UNESCAPED_UNICODE);
    }
}
