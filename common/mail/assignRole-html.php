<?php
use \yii\helpers\Html;
?>
<div>
    <h4>Уважаемый <?=Html::encode($data['user']->username)?>!</h4>
    <p>В проекте <?=$data['project']->title?> Вам назначена роль <?=$data['role']?>.</p>
</div>

