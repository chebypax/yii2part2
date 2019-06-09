<?php


namespace common\services;


use common\models\Project;
use common\models\ProjectUser;
use common\models\Task;
use common\models\User;
use yii\base\Component;
use yii\base\Event;

class TakeTaskEvent extends Event
{
    /**@var Task*/
    public $task;
    /**@var User*/

    public $user;
}

class CompleteTaskEvent extends Event
{
    /**@var Task*/
    public $task;
    /**@var User*/

    public $user;
}

class TaskService extends Component
{
    const EVENT_TAKE_TASK = 'event_take_task';
    const EVENT_COMPLETE_TASK = 'event_complete_task';

    public function canManage(Project $project, User $user)
    {
        return \Yii::$app->projectService->hasRole($project, $user, ProjectUser::ROLE_MANAGER);
    }
    public function canTake(Task $task, User $user)
    {
        $project = $task->project;
        return (!$task->executor_id
            && \Yii::$app->projectService->hasRole($project, $user, ProjectUser::ROLE_DEVELOPER));
    }
    public function canComplete(Task $task, User $user)
    {
        return (!$task->completed_at && $task->executor_id == $user->id);
    }
    public function takeTask(Task $task, User $user)
    {
        if (!$this->canTake($task, $user))
        {
            return false;
        }
        $task->executor_id = $user->id;
        $task->started_at = time();
        return $task->save();
    }
    public function completeTask(Task $task)
    {

        if (!$this->canComplete($task, \Yii::$app->user->identity))
        {
            return false;
        }
        $task->completed_at = time();
        return $task->save();
    }

    public function informTakeTask(Task $task, User $user)
    {
        $event = new TakeTaskEvent();
        $event->task = $task;
        $event->user = $user;

        $this->trigger(self::EVENT_TAKE_TASK, $event);
    }

    public function informCompleteTask(Task $task, User $user)
    {
        $event = new CompleteTaskEvent();
        $event->task = $task;
        $event->user = $user;

        $this->trigger(self::EVENT_COMPLETE_TASK, $event);
    }
}