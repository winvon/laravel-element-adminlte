<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $needles = $request->get('needles', 'user');
        return get_route_information_list()->filter(function ($route) use ($needles) {
            return Str::startsWith($route['uri'], $needles);
        });
    }
}
