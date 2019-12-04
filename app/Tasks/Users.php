<?php

namespace App\Tasks;

use Illuminate\Support\Facades\Input;

class Users {
    public function getUserById($id)
    {
        $user = \App\Models\Test::query()->where('id', $id)->first();
        if (!$user) {
            throw new \Exception("用户不存在{$id}");
        }
        return $user->toArray();
    }

    public function ComplexTaskTest($id)
    {
        $user = \App\Models\Test::query()->where('id', $id)->first();
        if (!$user) {
            throw new \Exception("用户不存在{$id}");
        }
        return [
            'input' => Input::get(),
            'data' => $user->toArray()
        ];
    }
}