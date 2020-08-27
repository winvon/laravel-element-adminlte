<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;

class SysController extends Controller
{

    public function index()
    {
        return view("user.sys.index");
    }
}
