<?php
use \yii\helpers\Html;

/** @var \common\models\User $user*/
/** @var \common\models\Task $task*/
?>
<div>
    <h4>Уважаемый <?=Html::encode($user->username)?>!</h4>
    <p>В проекте <?=$task->project->title?> пользователь <?=$task->executor->username?>
        закончил выполнение задачи <?=$task->title?>.</p>
</div>

