<?php

namespace app\controllers;

use app\models\Sudoku;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actionIndex(): string
    {
        $this->view->title = Yii::$app->name;

        $sudoku = Sudoku::getCurrent();

        return $this->render('index', [
            'sudoku' => $sudoku
        ]);
    }
}
