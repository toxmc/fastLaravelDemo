<?php

namespace App\Api\Controllers;

use App\Models\Test;
use App\Api\BaseController;

class UserController extends BaseController
{

    public function show($id)
    {
        $user = Test::findOrFail($id);
        return $this->response->array($user->toArray());
    }

}
