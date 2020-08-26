<?php

namespace app\models;

use Yii;

class Player extends \yii\base\BaseObject
{
    private const CACHE_KEY = 'players_list';

    public static function getAll(): array
    {
        $players = [];

        if (Yii::$app->cache->exists(self::CACHE_KEY)) {
            $players = Yii::$app->cache->get(self::CACHE_KEY);
        }

        return $players;
    }

    public static function saveAll(array $players): bool
    {
        return Yii::$app->cache->set(self::CACHE_KEY, $players);
    }

    public static function getTop(int $count = 5): array
    {
        $players = self::getAll();
        $topPlayers = [];
        $i = 0;

        foreach ($players as $name => $player) {
            $topPlayers[] = [
                'name' => $name,
                'wins' => $player['wins']
            ];

            $i++;

            if ($i >= $count) {
                return $topPlayers;
            }
        }

        return $topPlayers;
    }

    public static function addWin(string $name)
    {
        $players = self::getAll();

        if (!empty($players[$name])) {
            $players[$name]['wins'] += 1;
        } else {
            $players[$name] = [
                'wins' => 1
            ];
        }

        uasort($players, function ($a, $b) {
            if ($a['wins'] == $b['wins']) {
                return 0;
            }

            return ($a['wins'] > $b['wins']) ? -1 : 1;
        });

        return self::saveAll($players);
    }
}
