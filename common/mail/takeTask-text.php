<?php

/** @var \common\models\User $user*/
/** @var \common\models\Task $task*/
?>
Уважаемый <?=$task->creator->username?>!
В проекте <?=$task->project->title?> пользователь <?=$user->username?> приступил к выполнению задачи <?=$task->title?>.


