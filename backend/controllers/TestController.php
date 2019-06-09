<?php
namespace backend\controllers;


use common\models\Project;
use common\models\ProjectUser;
use common\models\Task;
use common\models\User;
use Yii;
use yii\web\Controller;


/**
 * Test controller
 */
class TestController extends Controller
{


    public function actionIndex()
    {
//        $project = Project::find()->indexBy('title')->column();
//        $user = User::findOne(2);
//        $task = Task::findOne(1);
//        var_dump($task->executor->username);
//
////        var_dump(\Yii::$app->taskService->canManage($project, $user));
////        var_dump(\Yii::$app->taskService->canTake($task, $user));
////        var_dump(\Yii::$app->taskService->takeTask($task, $user));
////        var_dump(\Yii::$app->taskService->completeTask($task));
//        var_dump($project);
//        var_dump(Yii::$app->user);
        $task = Task::findOne(1);
        $project = $task->project;
       // var_dump($project->getProjectUsers()); exit;
        $userId = $project->getProjectUsers()->where(['role' => ProjectUser::ROLE_TESTER])->one();
        $user = User::findOne($userId->user_id);
        var_dump($new);

//        $projects = Project::find()->byUser(1, ProjectUser::ROLE_MANAGER)->all();
//        var_dump($projects);
    }


}
