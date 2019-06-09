<?php


namespace common\models\query;


use common\models\User;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\User]].
 *
 * @see \common\models\User
 */

class UserQuery extends ActiveQuery
{
    public function onlyActive()
    {
        return  User::find()->where(['status' => User::STATUS_ACTIVE]);
    }
}