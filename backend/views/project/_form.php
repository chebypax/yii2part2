<?php

use unclead\multipleinput\MultipleInputColumn;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = \yii\bootstrap\ActiveForm::begin([
        'layout' => 'horizontal',

        'fieldConfig' => [
            'horizontalCssClasses' => ['label' => 'col-sm-2',]
        ],]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList(\common\models\Project::STATUS_LABELS) ?>

    <?php if (!$model->isNewRecord): ?>

        <?php
        echo $form->field($model, \common\models\Project::RELATION_PROJECT_USERS)
            ->widget(\unclead\multipleinput\MultipleInput::className(), [
                //https://github.com/unclead/yii2-multiple-input
                'id' => 'prodject-user-widget',
                'max' => 10,
                'min' => 0,
                'allowEmptyList' => false,
                'enableGuessTitle' => true,
                'addButtonPosition' => \unclead\multipleinput\MultipleInput::POS_HEADER,

                'columns' => [
                    [
                        'name' => 'project_id',
                        'type' => MultipleInputColumn::TYPE_HIDDEN_INPUT,
                        'enableError' => true,
                        'title' => 'project_id',
                        'defaultValue' => $model->id,

                    ],
                    [
                        'name' => 'user_id',
                        'type' => MultipleInputColumn::TYPE_DROPDOWN,
                        'enableError' => true,
                        'title' => 'Пользователь',
                        'items' => $users
                    ],
                    [
                        'name' => 'role',
                        'type' => MultipleInputColumn::TYPE_DROPDOWN,
                        'enableError' => true,
                        'title' => 'Роль',
                        'items' => [
                            \common\models\ProjectUser::ROLE_LABELS
                        ]
                    ],
                ]
            ])->label(null);
        ?>
    <?php endif; ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\bootstrap\ActiveForm::end(); ?>

</div>
