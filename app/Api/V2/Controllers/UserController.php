<?php

namespace App\Api\V2\Controllers;

use App\Models\Test;
use App\Api\BaseController;
use App\Api\Transformers\UserTransformer;

class UserController extends BaseController
{

    public function show($id)
    {
        $user = Test::findOrFail($id);
        return $this->response->item($user, new UserTransformer, ['id'=>"ID"]);
    }

}
