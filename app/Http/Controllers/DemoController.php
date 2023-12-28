<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DemoController extends Controller
{
    public function index()
    {
        // $BASE_URL =  'http://127.0.01/api/';
        $res =Http::get("http://127.0.0.1:8000/api/users_list",[]);
        return $res;
    }
}
