<?php


namespace frontend\modules\api\models;


use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\StringHelper;

class Project extends \common\models\Project
{
    public function fields()
    {
        return ['id', 'title',
            'description_short' => function (){
                return StringHelper::truncate($this->description, 50);
            },
            'active'
        ];
    }

    public function extraFields()
    {
        return ['tasks'];
    }

    public function getTasks()
    {
        return $this->hasMany(Task::class, ['project_id' => 'id']);
    }


}