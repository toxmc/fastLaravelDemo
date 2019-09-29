<?php

namespace App\Http\Controllers;

use FastLaravel\Http\Facade\Swoole\Server;
use FastLaravel\Http\Facade\Swoole\Table;
use Illuminate\Http\Request;

class HelloController extends Controller
{

    public function hello()
    {
        return "hello world";
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
}
