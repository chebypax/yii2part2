<?php
namespace common\services;

use common\models\Project;
use common\models\Task;
use common\models\User;
use yii\base\Component;

class NotificationService extends Component
{
    private $emailService;

    public function __construct(EmailServiceInterface $emailService, array $config =[])
    {
        parent::__construct($config);
        $this->emailService = $emailService;
    }


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
        $this->emailService->send($to, $subject, $viewHTML, $viewText, $data);
    }

    public function sendTakeTaskEmail(User $user, Task $task)
    {
        $to = $task->creator->email;
        $data = [
            'user' => $user,
            'task' => $task,
            ];
        $subject = 'Задача принята в работу';
        $viewHTML = 'takeTask-html';
        $viewText = 'takeTask-text';
        $this->emailService->send($to, $subject, $viewHTML, $viewText, $data);
    }
    public function sendCompleteTaskEmail(User $user, Task $task)
    {
        $to = $user->email;
        $data = [
            'user' => $user,
            'task' => $task,
        ];
        $subject = 'Задача выполнена';
        $viewHTML = 'completeTask-html';
        $viewText = 'completeTask-text';
        $this->emailService->send($to, $subject, $viewHTML, $viewText, $data);
    }
}