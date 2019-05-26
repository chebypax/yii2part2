<?php

use yii\db\Migration;

/**
 * Class m190526_131621_add_description_to_project
 */
class m190526_131621_add_description_to_project extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('project', 'description', 'text NOT NULL after title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('project', 'description');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190526_131621_add_description_to_project cannot be reverted.\n";

        return false;
    }
    */
}
