<?php
namespace backend\controllers;


use common\models\User;
use yii\web\Controller;


/**
 * Test controller
 */
class TestController extends Controller
{


    public function actionIndex()
    {
        $users = User::find()->select('id')->column();
        array_splice($users,0,1);
        var_dump($users);
    }


}
