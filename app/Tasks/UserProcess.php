<?php

namespace App\Tasks;

use FastLaravel\Http\Process\BaseProcess;
use FastLaravel\Http\Server\Application;
use FastLaravel\Http\Facade\Show;
use Swoole\Process;

class UserProcess extends BaseProcess{

    public function run(Process $process)
    {
        Application::make('laravel', base_path());

        while(true) {
            try {
                $id = rand(1, 100);
                $user = \App\Models\Test::query()->where('id', $id)->first();
                if (!$user) {
                    throw new \Exception("用户不存在");
                }
                var_dump($user->toArray());
                sleep(2);
                Show::info('sleep 2s');
            } catch (\Exception $e) {
                Show::error($e->getMessage());
            }
        }
    }
}