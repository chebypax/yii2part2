<?php


use common\services\NotificationService;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'projectService' => [
            'class' => common\services\ProjectService::class,
            'on '.\common\services\ProjectService::EVENT_ASSIGN_ROLE =>
            function (\common\services\AssignRoleEvent $event)
            {
                Yii::$app->notificationService->sendAssignRoleEmail($event->user, $event->project, $event->role);
            },
        ],
        'emailService' => [
            'class' => common\services\EmailService::class,
        ],
        'notificationService' => [
            'class' => common\services\NotificationService::class,
        ],
        'authManager' => [
            'class' => yii\rbac\DbManager::class,
        ],
        'taskService' => [
            'class' => common\services\TaskService::class,
            'on '.\common\services\TaskService::EVENT_TAKE_TASK =>
                function (\common\services\TakeTaskEvent $event)
                {
                    Yii::$app->notificationService->sendTakeTaskEmail($event->user, $event->task);
                },
            'on '.\common\services\TaskService::EVENT_COMPLETE_TASK =>
                function (\common\services\CompleteTaskEvent $event)
                {
                    Yii::$app->notificationService->sendCompleteTaskEmail($event->user, $event->task);
                }
        ],
    ],
    'modules' => [
        'chat' => [
            'class' => 'common\Modules\chat\Module',
        ],
    ],

];
