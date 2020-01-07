<?php

namespace App\Tasks;

use FastLaravel\Http\Facade\Show;

class Crontab {

    public function execute()
    {
        try {
            $id = rand(1, 1000);
            $user = \App\Models\Test::query()->where('id', $id)->first();
            if (!$user) {
                throw new \Exception("用户不存在{$id}");
            }
            Show::danger(json_encode($user->toArray()));
        } catch (\Exception $e) {
            Show::error($e->getMessage());
        }
    }
}