<?php

namespace app\commands;

use app\daemons\SudokuServer;
use consik\yii2websocket\WebSocketServer;
use yii\console\Controller;

class ServerController extends Controller
{
    public function actionStart($port = null)
    {
        $server = new SudokuServer();

        if ($port) {
            $server->port = $port;
        }

        $server->on(WebSocketServer::EVENT_WEBSOCKET_OPEN, function ($e) use ($server) {
            echo "Server started at port " . $server->port;
        });

        $server->start();
    }
}
