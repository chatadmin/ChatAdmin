<?php

use App\Common\DbSelector;
use App\Process\MonitorProcess;
use Swoft\Db\Pool;
use Swoft\Http\Server\HttpServer;
use Swoft\Task\Swoole\SyncTaskListener;
use Swoft\Task\Swoole\TaskListener;
use Swoft\Task\Swoole\FinishListener;
use Swoft\Rpc\Client\Client as ServiceClient;
use Swoft\Rpc\Client\Pool as ServicePool;
use Swoft\Rpc\Server\ServiceServer;
use Swoft\Http\Server\Swoole\RequestListener;
use Swoft\WebSocket\Server\WebSocketServer;
use Swoft\Server\SwooleEvent;
use Swoft\Db\Database;
use Swoft\Redis\RedisDb;

return [
    'logger'           => [
        'flushRequest' => false,
        'enable'       => false,
        'json'         => false,
    ],
    'httpServer'       => [
        'class'    => HttpServer::class,
        'port'     => 18306,
        'listener' => [
            'rpc' => bean('rpcServer')
        ],
        'process' => [
//            'monitor' => bean(MonitorProcess::class)
        ],
        'on'       => [
//            SwooleEvent::TASK   => bean(SyncTaskListener::class),  // Enable sync task
            SwooleEvent::TASK   => bean(TaskListener::class),  // Enable task must task and finish event
            SwooleEvent::FINISH => bean(FinishListener::class)
        ],
        /* @see HttpServer::$setting */
        'setting'  => [
            'task_worker_num'       => 12,
            'task_enable_coroutine' => true
        ]
    ],
    'httpDispatcher'   => [
        // Add global http middleware
        'middlewares' => [
            // Allow use @View tag
            \Swoft\View\Middleware\ViewMiddleware::class,
        ],
    ],
    'db'               => [
        'class'    => Database::class,
        'dsn'      => 'mysql:dbname=dggWeChat;host=10.50.215.197',
        'username' => 'root',
        'password' => 'admin777',
        'prefix' => 'dgg_',
        'charset' => 'utf8mb4',
        'config' => [
            'collation' => 'utf8mb4_general_ci',#排序集合
            'strict' => false,
            'timezone' => '+8:00',#东8区
            'modes' => 'NO_ENGINE_SUBSTITUTION,STRICT_TRANS_TABLES',
            'fetchMode' => PDO::FETCH_ASSOC,
        ],
        'options'  => [
            \PDO::ATTR_CASE => \PDO::CASE_NATURAL,
        ],
    ],
    'db.pool'         => [
        'class'    => Pool::class,
        'database' => bean('db')
    ],
    'migrationManager' => [
        'migrationPath' => '@app/Migration',
    ],
    'redisOne'            => [
        'class'    => RedisDb::class,
        'host'     => '10.50.215.197',
        'port'     => 6379,
        'database' => 1,
        'password' => '123456',
        'readTimeout'   => 0,
        'timeout'       => 2,
        'option'        => [
            'prefix'      => 'admin:',
            'serializer' => Redis::SERIALIZER_PHP
        ],
    ],
    'redis.pool.one'     => [
        'class'   => \Swoft\Redis\Pool::class,
        'redisDb' => \bean('redisOne'),
        'minActive'   => 10,
        'maxActive'   => 20,
        'maxWait'     => 0,
        'maxWaitTime' => 0,
        'maxIdleTime' => 60,
    ],

    'redisTwo'      => [
        'class'         => RedisDb::class,
        'host'          => '10.50.215.197',
        'port'          => 6379,
        'database'      => 2,
        'password' => '123456',
        'retryInterval' => 10,
        'readTimeout'   => 0,
        'timeout'       => 2,
        'option'        => [
            'prefix'      => '',
            'serializer' => Redis::SERIALIZER_PHP
        ],
    ],
    'redis.pool.two'     => [
        'class'   => \Swoft\Redis\Pool::class,
        'redisDb' => \bean('redisTwo'),
        'minActive'   => 10,
        'maxActive'   => 20,
        'maxWait'     => 0,
        'maxWaitTime' => 0,
        'maxIdleTime' => 60,
    ],
    'user'             => [
        'class'   => ServiceClient::class,
        'host'    => '127.0.0.1',
        'port'    => 18307,
        'setting' => [
            'timeout'         => 0.5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 0.5,
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'user.pool'        => [
        'class'  => ServicePool::class,
        'client' => bean('user')
    ],
    'rpcServer'        => [
        'class' => ServiceServer::class,
    ],
    'wsServer'         => [
        'class'   => WebSocketServer::class,
        'port'    => 18308,
        'on'      => [
            // Enable http handle
            SwooleEvent::REQUEST => bean(RequestListener::class),
        ],
        'debug'   => env('SWOFT_DEBUG', 0),
        /* @see WebSocketServer::$setting */
        'setting' => [
            'log_file' => alias('@runtime/swoole.log'),
        ],
    ],
    'tcpServer'         => [
        'port'  => 18309,
        'debug' => 1,
    ],
    /** @see \Swoft\Tcp\Protocol */
    'tcpServerProtocol' => [
        'type'            => \Swoft\Tcp\Packer\SimpleTokenPacker::TYPE,
        // 'openLengthCheck' => true,
    ],
    'cliRouter'         => [
        // 'disabledGroups' => ['demo', 'test'],
    ]
];
