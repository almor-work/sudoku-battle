<?php

namespace app\daemons;

use app\models\Player;
use app\models\Sudoku;
use consik\yii2websocket\events\WSClientEvent;
use consik\yii2websocket\WebSocketServer;
use Ratchet\ConnectionInterface;

class SudokuServer extends WebSocketServer
{
    public function init()
    {
        parent::init();

        $this->on(self::EVENT_CLIENT_CONNECTED, function (WSClientEvent $e) {
            $e->client->name = null;
        });
    }

    protected function getCommand(ConnectionInterface $from, $msg)
    {
        $request = json_decode($msg, true);

        return !empty($request['action']) ? $request['action'] : parent::getCommand($from, $msg);
    }

    private function isUniqueName(string $name): bool
    {
        foreach ($this->clients as $client) {
            if (strtolower($client->name) == strtolower($name)) {
                return false;
            }
        }

        return true;
    }

    private function isValidName(string $name): bool
    {
        $preparedName = preg_replace('/[^A-Za-z0-9]/', '', $name);

        if ($preparedName != $name || strlen($name) > 20 || $name == '') {
            return false;
        }

        return $name;
    }

    private function checkSudoku(string $clientName)
    {
        $sudoku = Sudoku::getCurrent();

        if (Sudoku::isFilled($sudoku)) {
            if (Sudoku::isSolved($sudoku)) {
                $result = [
                    'action' => 'successGame',
                    'winner' => $clientName
                ];

                Player::addWin($clientName);
            } else {
                $result = [
                    'action' => 'failedGame'
                ];
            }

            Sudoku::clear();

            foreach ($this->clients as $clientsItem) {
                $clientsItem->send(json_encode($result));
            }
        }
    }

    public function commandSetName(ConnectionInterface $client, $msg)
    {
        $request = json_decode($msg, true);
        $result = [];

        if (!empty($request['name']) && $name = trim($request['name'])) {
            if ($this->isUniqueName($name)) {
                if ($this->isValidName($name)) {
                    $client->name = $name;
                    $result = $request;
                } else {
                    $result = [
                        'action' => 'error',
                        'message' => 'The name can contain no more than 20 characters and consist only of latin letters and numbers'
                    ];
                }
            } else {
                $result = [
                    'action' => 'error',
                    'message' => 'This name is already used'
                ];
            }
        }

        $client->send(json_encode($result));
    }

    public function commandChange(ConnectionInterface $client, $msg)
    {
        $request = json_decode($msg, true);
        $result = [];

        if (!$client->name) {
            $result = [
                'action' => 'error',
                'message' => 'Set your name'
            ];

            $client->send(json_encode($result));
        } else {
            if (Sudoku::update($request['row'], $request['col'], $request['value'])) {
                $result = $request;

                foreach ($this->clients as $clientsItem) {
                    if ($clientsItem->name != $client->name) {
                        $clientsItem->send(json_encode($result));
                    }
                }

                $this->checkSudoku($client->name);
            } else {
                $result = [
                    'action' => 'error',
                    'message' => 'Cell value is incorrect (only digit 1 to 9)'
                ];

                $client->send(json_encode($result));
            }
        }
    }

    public function commandTopPlayers(ConnectionInterface $client, $msg)
    {
        $result = [
            'action' => 'topPlayers',
            'players' => Player::getTop()
        ];

        $client->send(json_encode($result));
    }
}
