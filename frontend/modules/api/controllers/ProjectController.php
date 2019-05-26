<?php


namespace frontend\modules\api\controllers;


use frontend\modules\api\models\Project;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

class ProjectController extends ActiveController
{
    public $modelClass = Project::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class
        ];
        return $behaviors;
    }
}