<?php

namespace app\models;

use Yii;

class Sudoku extends \yii\base\BaseObject
{
    private const CACHE_KEY = 'sudoku';

    public static function getCurrent(): array
    {
        $sudoku = [];

        if (Yii::$app->cache->exists(self::CACHE_KEY)) {
            $sudoku = Yii::$app->cache->get(self::CACHE_KEY);
        } else {
            $sudoku = self::create();
            self::save($sudoku);
        }

        return $sudoku;
    }

    public static function save(array $sudoku): bool
    {
        return Yii::$app->cache->set(self::CACHE_KEY, $sudoku);
    }

    public static function update($row, $col, $value): bool
    {
        if (!self::isCorrectCell($row, $col, $value)) {
            return false;
        }

        $sudoku = self::getCurrent();
        $sudoku[$row][$col] = $value;

        return self::save($sudoku);
    }

    public static function clear(): bool
    {
        return Yii::$app->cache->delete(self::CACHE_KEY);
    }

    private static function isCorrectCell($row, $col, $value): bool
    {
        if ($row < 0 || $row > 8 || $col < 0 || $col > 8) {
            return false;
        }

        $numValue = intval($value);

        if ($value != '' && ($numValue < 1 || $numValue > 9)) {
            return false;
        }

        return true;
    }

    public static function isFilled(array $sudoku): bool
    {
        for ($row = 0; $row < 9; $row++) {
            for ($col = 0; $col < 9; $col++) {
                if (empty($sudoku[$row][$col])) {
                    return false;
                }
            }
        }

        return true;
    }

    public static function isSolved(array $sudoku): bool
    {
        $sudoku = array_merge($sudoku[0], $sudoku[1], $sudoku[2], $sudoku[3], $sudoku[4], $sudoku[5], $sudoku[6], $sudoku[7], $sudoku[8]);

        for ($c = 0; $c < 9; $c++) {
            for ($i = 0; $i < 9; $i++) {
                $rowTemp[$i] = $sudoku[$c * 9 + $i];
            }

            $isCorrectRow = count(array_diff(array(1, 2, 3, 4, 5, 6, 7, 8, 9), $rowTemp)) == 0;

            for ($i = 0; $i < 9; $i++) {
                $colTemp[$i] = $sudoku[$c + $i * 9];
            }

            $isCorrectCol = count(array_diff(array(1, 2, 3, 4, 5, 6, 7, 8, 9), $colTemp)) == 0;

            for ($i = 0; $i < 9; $i++) {
                $blockTemp[$i] = $sudoku[floor($c / 3) * 27 + $i % 3 + 9 * floor($i / 3) + 3 * ($c % 3)];
            }

            $isCorrectBlock = count(array_diff(array(1, 2, 3, 4, 5, 6, 7, 8, 9), $blockTemp)) == 0;

            if (!$isCorrectRow || !$isCorrectCol || !$isCorrectBlock) {
                return false;
            }
        }

        return true;
    }

    public static function create(): array
    {
        $presets = [
            [
                [9, 0, 0, 3, 0, 0, 0, 7, 1],
                [4, 3, 7, 8, 0, 0, 2, 5, 0],
                [0, 0, 5, 0, 2, 0, 0, 4, 9],
                [0, 5, 8, 4, 0, 9, 0, 3, 0],
                [7, 0, 0, 1, 0, 0, 0, 9, 8],
                [2, 9, 0, 0, 3, 0, 0, 0, 4],
                [0, 8, 0, 0, 1, 3, 0, 0, 0],
                [3, 0, 4, 6, 8, 7, 0, 0, 0],
                [1, 0, 0, 2, 5, 0, 0, 0, 0],
            ],
            [
                [0, 0, 0, 1, 0, 5, 7, 0, 0],
                [0, 0, 3, 0, 6, 0, 4, 0, 5],
                [1, 6, 5, 0, 0, 4, 9, 0, 0],
                [0, 0, 0, 0, 9, 6, 0, 0, 7],
                [0, 0, 7, 2, 0, 8, 3, 9, 6],
                [0, 0, 1, 7, 5, 3, 0, 8, 0],
                [0, 1, 0, 0, 2, 0, 5, 0, 0],
                [4, 8, 0, 0, 3, 0, 0, 7, 2],
                [7, 0, 0, 0, 0, 9, 0, 3, 1],
            ],
            [
                [0, 0, 2, 0, 0, 0, 0, 1, 0],
                [0, 8, 5, 4, 0, 0, 0, 6, 0],
                [0, 0, 4, 0, 6, 1, 0, 0, 8],
                [5, 3, 1, 9, 8, 0, 0, 0, 0],
                [0, 4, 9, 2, 0, 0, 8, 3, 0],
                [0, 2, 7, 6, 0, 0, 0, 0, 9],
                [4, 0, 0, 0, 3, 2, 1, 5, 7],
                [0, 0, 8, 7, 0, 5, 0, 0, 0],
                [0, 5, 0, 0, 9, 6, 2, 8, 0],
            ],
        ];

        return $presets[random_int(0, count($presets) - 1)];
    }
}
