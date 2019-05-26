<?php


namespace frontend\modules\api\controllers;


use frontend\modules\api\models\Task;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class TaskController extends Controller
{
        public function actionIndex()
        {
            $dp = new ActiveDataProvider([
                'query' => Task::find()
        ]);
            //$dp->pagination->pageSize = 1;
            return $dp;
        }

        public function actionView($id) {
            return Task::findOne($id);
        }
}