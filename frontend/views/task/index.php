<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            'description:ntext',

            [
                'attribute' => 'project_id',
                'label' => 'Project',
                'filter' => \common\models\Project::find()->select('title')
                    ->indexBy('id')->where(['active' => \common\models\Task::ACTIVE_ACTIVE])->column(),
                'format' => 'raw',
                'value' => function (\common\models\Task $task) {
                    return HTML::a($task->project->title, ['project/view', 'id' => $task->project->id]);
                },


            ],
            [
                'attribute' => 'creator_id',
                'label' => 'Creator',
                'filter' => \Yii::$app->projectService->getManagers(),
                'format' => 'raw',
                'value' => function (\common\models\Task $model) {
                    return HTML::a($model->creator->username, ['user/view', 'id' => $model->creator->id]);
                }
            ],
            [
                'attribute' => 'updater_id',
                'label' => 'Updater',
                'filter' => \Yii::$app->projectService->getManagersAndDevelopers(),
                'format' => 'raw',
                'value' => function (\common\models\Task $model) {
                    return HTML::a($model->updater->username, ['user/view', 'id' => $model->updater->id]);
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'executor_id',
                'label' => 'Executor',
                'filter' => \Yii::$app->projectService->getDevelopers(),
                'format' => 'raw',
                'value' => function (\common\models\Task $model) {
                    if ($model->executor === null) {
                        return;
                    }
                    return HTML::a($model->executor->username, ['user/view', 'id' => $model->executor->id]);

                }
            ],
            'started_at:datetime',
            'completed_at:datetime',


            //['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {take} {complete}',
                'buttons' => [
                    'take' => function ($url, \common\models\Task $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('thumbs-up');
                        return Html::a($icon, ['task/take-task', 'id' => $model->id], [
                            'data' => [
                                'confirm' => 'Уверены, что хотите взять задачу?',
                                'method' => 'post',
                            ]]);
                    },
                    'complete' => function ($url, \common\models\Task $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('ok');
                        return Html::a($icon, ['task/complete-task', 'id' => $model->id], [
                            'data' => [
                                'confirm' => 'Уверены, что хотите закончить задачу?',
                                'method' => 'post',
                            ]]);
                    },

                ],
                'visibleButtons' => [
                    'update' => function (\common\models\Task $model,  $key, $index) {
                        return \Yii::$app->taskService->canManage($model->project, \Yii::$app->user->identity);
                    },
                    'delete' => function (\common\models\Task $model,  $key, $index) {
                        return \Yii::$app->taskService->canManage($model->project, \Yii::$app->user->identity);
                    },
                    'take' => function (\common\models\Task $model,  $key, $index) {
                        return \Yii::$app->taskService->canTake($model, \Yii::$app->user->identity);
                    },
                    'complete' => function (\common\models\Task $model,  $key, $index) {
                        return \Yii::$app->taskService->canComplete($model, \Yii::$app->user->identity);
                    }

                ],

            ],
        ]]); ?>

    <?php Pjax::end(); ?>

</div>
