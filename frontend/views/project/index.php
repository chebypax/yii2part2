<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function(\common\models\Project $model)
                {
                    return HTML::a($model->title, ['project/view', 'id' => $model->id]);
                }
            ],
            'description:ntext',

            [
                'attribute' => 'active',
                'format' => 'raw',
                'filter' => \common\models\Project::STATUS_LABELS,
                'value' => function(\common\models\Project $model)
                {
                    return \common\models\Project::STATUS_LABELS[$model->active];
                }
            ],
            [
                'attribute' => 'role',
                'format' => 'raw',
                'filter' => \common\models\ProjectUser::ROLE_LABELS,
                'value' => function(\common\models\Project $model)
                {
                    $result = '';
                    foreach (\Yii::$app->projectService->getRoles($model, \Yii::$app->user->identity) as $role)
                    {
                        $result .= $result . $role . ", ";
                    }
                    $result = substr($result, 0, strlen($result) - 2);
                    return $result;
                }
            ],
            [
                'attribute' => 'creator_id',
                'format' => 'raw',
                //'filter' => \common\models\Project::STATUS_LABELS,
                'value' => function(\common\models\Project $model)
                {
                    return HTML::a($model->creator->username, ['user/view', 'id' => $model->creator->id]);
                }
            ],
            [
                'attribute' => 'updater_id',
                'format' => 'raw',
                //filter' => \common\models\Project::STATUS_LABELS,
                'value' => function(\common\models\Project $model)
                {
                    return HTML::a($model->updater->username, ['user/view', 'id' => $model->updater->id]);
                }
            ],
            //'updater_id',
            'created_at:datetime',
            'updated_at:datetime',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
