<?php
namespace common\services;

use common\models\Project;
use common\models\User;
use yii\base\Component;
use yii\base\Event;

class AssignRoleEvent extends Event
{
    /**@var Project*/
    public $project;
    /**@var User*/

    public $user;
    /**@var string*/

    public $role;
}


class ProjectService extends Component
{
    const EVENT_ASSIGN_ROLE = 'event_assign_role';

    public function assignRole(Project $project, User $user, $role)
    {
        $event = new AssignRoleEvent();
        $event->project = $project;
        $event->user = $user;
        $event->role = $role;

        $this->trigger(self::EVENT_ASSIGN_ROLE, $event);
    }
}