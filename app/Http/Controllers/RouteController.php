<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;

class RouteController extends Controller
{
    public function returnData(Request $request)
    {
        return response()->json([
            'method' => $request->method(),
            'all'    => $request->all(),
            'query'  => $request->query(),
            'header' => $request->header(),
            'server' => $request->server(),
        ]);
    }

    public function get(Request $request)
    {
        return $this->returnData($request);
    }

    public function post(Request $request)
    {
        return $this->returnData($request);
    }

    public function put(Request $request)
    {
        return $this->returnData($request);
    }

    public function delete(Request $request)
    {
        return $this->returnData($request);
    }

    public function options(Request $request)
    {
        return $this->returnData($request);
    }

    public function match(Request $request)
    {
        return $this->returnData($request);
    }

    public function any(Request $request)
    {
        return $this->returnData($request);
    }

    public function routeWhere(Request $request, $id)
    {
        return [
            'id' => $id,
            $request->route()->parameters(),
            'name' => $request->route()->getName(),
            'name_1' => \Illuminate\Support\Facades\Request::route()->getName(),
            'name_2' => app('request')->route()->getName(),
            'name_3' => app()->make('request')->route()->getName(),
        ];
    }
}
