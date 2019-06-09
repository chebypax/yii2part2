<?php

/** @var \common\models\User $user*/
/** @var \common\models\Task $task*/
?>
Уважаемый <?=$user->username?>!
В проекте <?=$task->project->title?> пользователь <?=$task->executor->username?>
закончил выполнение задачи <?=$task->title?>.


