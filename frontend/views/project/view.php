<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => \common\models\Project::STATUS_LABELS[$model->active]
            ],
            [
                'attribute' => 'updater',
                'format' => 'raw',
                'value' => $model->updater->username
            ],
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

    <h3>Пользователи, назначенные на задачу</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            [
                'attribute' => 'Пользователь',
                'format' => 'raw',
                'value' => function(\common\models\ProjectUser $model)
                {

                    return HTML::a($model->user->username, ['user/view', 'id' => $model->user->id]);
                }
            ],
            [
                'attribute' => 'Роль',
                'format' => 'raw',
                'value' => function(\common\models\ProjectUser $model)
                {

                    return $model->role;
                }
            ],
        ],
    ]); ?>

</div>
