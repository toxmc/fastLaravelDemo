<?php

namespace App\Http\Controllers;

use App\Tasks\Users;
use FastLaravel\Http\Facade\Swoole\Server;
use FastLaravel\Http\Facade\Swoole\Table;
use FastLaravel\Http\Task\Task;
use FastLaravel\Http\Task\ComplexTask;
use Illuminate\Http\Request;

class HelloController extends Controller
{

    public function hello()
    {
        return [
            "hello world",
            str_repeat('A', 102400 * 2)
        ];
    }

    public function after()
    {
        $start = time();
        $id = Server::after(2000, function () use ($start) {
            $end = time();
            echo "start at:{$start}, after call at:{$end}\n";
        });

        Server::defer(function(){
           echo "defer\n";
        });
        return $id;
    }

    public function tick()
    {
        $start = time();
        $id = Server::tick(2000, function () use ($start) {
            $end = time();
            echo "start at:{$start}, after call at:{$end}\n";
        });
        return [
            'id' => $id
        ];
    }

    public function clearTimer(Request $request)
    {
        $id = (int)$request->get('id');
        $ret = Server::clearTimer($id);
        return [$ret];
    }

    public function reload(Request $request)
    {
        $onlyReloadTask = (int)$request->get('only_reload_task', 0);
        $ret = Server::reload($onlyReloadTask);
        return [$ret, $onlyReloadTask];
    }

    public function info()
    {
        $info = [
            'master_pid' => app('swoole.server')->master_pid,
            'manage_pid' => app('swoole.server')->manage_pid,
        ];
        return $info;
    }

    public function table()
    {
        $i = 2;
        while ($i--) {
            $tableKey = 'test_'.$i;
            $table = Table::get($tableKey);
            if (!$table) {
                $table = new \Swoole\Table(64);
                $table->column('key', \Swoole\Table::TYPE_INT, 4);
                $table->column('name', \Swoole\Table::TYPE_STRING, 23);
                $table->create();
                Table::add($tableKey, $table);
            }
        }

        $result = [];
        $result['count'] = Table::count();
        Table::del($tableKey);
        $result['after_delete_count'] = Table::count();

        $table = Table::get('test_1');
        $table->set('0001', [
            'key' => '0001',
            'name' => 'hello world'
        ]);

        $result['get'] = $table->get('0001');
        return $result;
    }

    public function task()
    {
        $result = [];
        // 投递任务并获取结果
        $result['deliver_co'] = Task::deliver(Users::class, 'getUserById', ['1319']);
        $result['deliver_async'] = Task::deliver(Users::class, 'getUserById', ['1319'], Task::TYPE_ASYNC);

        $tasks = [
            [
                'name'   => Users::class,
                'method' => 'getUserById',
                'params' => ['1319'],
            ],
            [
                'name'   => Users::class,
                'method' => 'getUserById',
                'params' => ['1319'],
            ],
        ];
        $result['co'] = Task::co($tasks, 3);

        $tasks = [
            [
                'name'   => Users::class,
                'method' => 'getUserById',
                'params' => ['1319'],
            ],
            [
                'name'   => Users::class,
                'method' => 'getUserById',
                'params' => ['1319'], // 注意必须数组
            ],
        ];
        $result['async'] = Task::async($tasks);

        // 请勿通过Task调用复杂的Task功能，否则将无法保存获取的结果正确
        $result['task_call_complex'] = Task::deliver(Users::class, 'ComplexTaskTest', ['1319']);
        return $result;
    }

    /**
     * 复杂的task
     * @return array|bool|int
     * @throws \FastLaravel\Http\Exceptions\TaskException
     */
    public function complexTask()
    {
        return ComplexTask::deliver(Users::class, 'ComplexTaskTest', ['1319']);
    }

}
