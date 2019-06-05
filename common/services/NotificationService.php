<?php
namespace common\services;

use common\models\Project;
use common\models\User;

class NotificationService
{
    public function sendAssignRoleEmail(User $user, Project $project, $role)
    {
        $to = $user->email;
        $data = [
            'user' => $user,
            'project' => $project,
            'role' => $role];
        $subject = 'Вам назначена новая роль!';
        $viewHTML = 'assignRole-html';
        $viewText = 'assignRole-text';
        \Yii::$app->emailService->send($to, $subject, $viewHTML, $viewText, $data);
    }
}