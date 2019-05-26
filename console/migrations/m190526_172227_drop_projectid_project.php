<?php

use yii\db\Migration;

/**
 * Class m190526_172227_drop_projectid_project
 */
class m190526_172227_drop_projectid_project extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('project', 'project_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('project', 'project_id', 'int');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190526_172227_drop_projectid_project cannot be reverted.\n";

        return false;
    }
    */
}
