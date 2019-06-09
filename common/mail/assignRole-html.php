<?php
use \yii\helpers\Html;

/** @var \common\models\User $user*/
/** @var \common\models\Project $project*/
/** @var string $role*/
?>
<div>
    <h4>Уважаемый <?=Html::encode($user->username)?>!</h4>
    <p>В проекте <?=$project->title?> Вам назначена роль <?=$role?>.</p>
</div>

