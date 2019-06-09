<?php
use \yii\helpers\Html;

/** @var \common\models\User $user*/
/** @var \common\models\Task $task*/
?>
<div>
    <h4>Уважаемый <?=Html::encode($task->creator->username)?>!</h4>
    <p>В проекте <?=$task->project->title?> пользователь <?=$user->username?>
        приступил к выполнению задачи <?=$task->title?>.</p>
</div>

