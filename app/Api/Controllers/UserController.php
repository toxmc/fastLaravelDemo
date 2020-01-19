<?php

namespace App\Api\Controllers;

use App\Models\Test;
use App\Api\BaseController;
use Dingo\Api\Http\Request;

class UserController extends BaseController
{

    public function show($id)
    {
        $user = Test::findOrFail($id);
        return $this->response->array($user->toArray());
    }

    public function post($id, Request $request)
    {
        
        return $this->response->array($request->all());
    }

    public function put($id, Request $request)
    {
        return $this->response->array($request->all());
    }

    public function delete($id)
    {
        return $this->response->array(['id'=>$id]);
    }

}
