<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

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
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => \common\models\User::STATUS_LABELS[$model->status]
            ],
            'created_at:datetime',
            'updated_at:datetime',
            //'verification_token',
            'access_token',
            [
                'attribute' => 'avatar',
                'format' => 'raw',
                'value' => Html::img($model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_PREVIEW))
            ],
        ],
    ]) ?>

    <h3>Проекты, в которых задействован пользователь</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            [
                'attribute' => 'Проект',
                'format' => 'raw',
                'value' => function(\common\models\ProjectUser $model)
                {

                    return HTML::a($model->project->title, ['project/view', 'id' => $model->project->id]);
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
