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

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'active',
            'creator_id',
            'updater_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <h3>Пользователи, назначенные на задачу</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            //'role',
            //'username',
            [
                'attribute' => 'users',
                'format' => 'raw',
                'value' => function(\common\models\User $user)
                {
                    var_dump($user); exit;
                    return HTML::a($user->username, ['user/view', 'id' => $user->id]);
                }
            ],


        ],
    ]); ?>

</div>
