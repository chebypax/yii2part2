<?php
namespace frontend\modules\api\models;

use yii\helpers\StringHelper;

class Task extends \common\models\Task
{
    public function fields()
    {
        return ['id', 'title',
            'description_short' => function (){
            return StringHelper::truncate($this->description, 50);
            }
        ];
    }

    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    public function extraFields()
    {
        return ['project'];
    }
}