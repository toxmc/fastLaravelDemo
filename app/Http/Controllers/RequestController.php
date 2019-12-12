<?php

namespace App\Http\Controllers;

use App\Tasks\Users;
use Illuminate\Support\Facades\Request;

class RequestController extends Controller
{

    public function info()
    {
        return [
            'header' => Request::header(),
            'header' => Request::server(),
        ];
    }

}