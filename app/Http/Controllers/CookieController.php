<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CookieController extends Controller
{
    public function test(Request $request)
    {
        $request->offsetSet('clear_cache', $request->cookie('clear_cache', 0));
        Input::offsetSet('clear_cache', $request->cookie('clear_cache', 0));
        return [
            'request' => $request->all(),
            'request_cookie' => $request->cookie(),
            'input' => Input::all(),
            'input_cookie' => Input::cookie(),
        ];
    }
}
