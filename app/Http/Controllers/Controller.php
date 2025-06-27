<?php

namespace App\Http\Controllers;

abstract class Controller
{
     protected $errorStatus       = 500;
    protected $successStatus     = 200;
    protected $validationStatus  = 400;
    protected $unauthStatus      = 401;
    protected $notFoundStatus    = 404;
    protected $invalidPermission = 403;
}
