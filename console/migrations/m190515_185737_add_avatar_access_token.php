<?php

use yii\db\Migration;

/**
 * Class m190515_185737_add_avatar_access_token
 */
class m190515_185737_add_avatar_access_token extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'access_token', $this->string(255)->defaultValue(null));
        $this->addColumn('{{%user}}', '`avatar`', $this->string(255)->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'access_token');
        $this->dropColumn('{{%user}}', '`avatar`');
    }
}
