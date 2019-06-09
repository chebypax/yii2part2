<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity)) :?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',

            ]
        ]) ?>
    </p>
    <?php endif;?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'project',
                'format' => 'raw',
                'value' => $model->project->title
            ],
            [
                'attribute' => 'executor',
                'format' => 'raw',
                'value' => function (\common\models\Task $model) {
                    if ($model->executor === null) {
                        return;
                    }
                    return $model->executor->username;
                }
            ],
            'started_at:datetime',
            'completed_at:datetime',
            [
                'attribute' => 'creator',
                'format' => 'raw',
                'value' => $model->creator->username
            ],
            [
                'attribute' => 'updater',
                'format' => 'raw',
                'value' => $model->updater->username
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
