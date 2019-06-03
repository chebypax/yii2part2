<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = \yii\bootstrap\ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['label' => 'col-sm-2',]
        ],]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(\common\models\User::STATUS_LABELS) ?>


    <?php if(!$model->isNewRecord) : ?>
        <?= $form->field($model, 'avatar')
            ->fileInput()
            ->label(Html::img($model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_PREVIEW)))?>
    <?php endif;?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\bootstrap\ActiveForm::end(); ?>

</div>
