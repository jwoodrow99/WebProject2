<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Role;


class test extends Controller
{

    public function __construct()
    {
        // This line allows for the use of the auth middlewear,
        // middlewear is implemented in route file.
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('test');
    }
}
