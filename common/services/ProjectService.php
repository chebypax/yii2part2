<?php
namespace common\services;

use common\models\Project;
use common\models\ProjectUser;
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


    public function getRoles(Project $project, User $user)
    {
        return $project->getProjectUsers()->byUser($user->id)->select('role')->column();
    }

    public function hasRole(Project $project, User $user, $role)
    {
        return in_array($role, $this->getRoles($project, $user));
    }

    public function getManagers()
    {
        $projects = ProjectUser::find()->byUser(\Yii::$app->user->id)
            ->where(['role' => ProjectUser::ROLE_MANAGER])->all();
        $users = [];
        foreach ($projects as $project)
        {
            $users[$project->user->id] = $project->user->username;
        }
        return $users;
    }
    public function getDevelopers()
    {
        $projects = ProjectUser::find()->byUser(\Yii::$app->user->id)
            ->where(['role' => ProjectUser::ROLE_DEVELOPER])->all();
        $users = [];
        foreach ($projects as $project)
        {
            $users[$project->user->id] = $project->user->username;
        }
        return $users;
    }
    public function getManagedProjects()
    {
        $projects = ProjectUser::find()->byUser(\Yii::$app->user->id, ProjectUser::ROLE_MANAGER)->all();
        $result = [];
        foreach ($projects as $project)
        {
            if ($project->project->active === Project::STATUS_ACTIVE) {
                $result[$project->project->id] = $project->project->title;
            }
        }
        return $result;
    }

}