<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PixelController extends Controller
{
    public function index($token)
    {
        die(json_encode(["response"=>"test", "token" => $token]));
    }
}
