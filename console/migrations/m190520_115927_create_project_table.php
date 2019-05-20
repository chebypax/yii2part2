<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project}}`.
 */
class m190520_115927_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('`project`', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(0),
            'project_id' => $this->integer()->null(),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null(),
        ]);
        $this->addForeignKey('fx_project_creator_id_user', 'project', ['creator_id'],
            'user', ['id']);
        $this->addForeignKey('fx_project_updater_id_user', 'project', ['updater_id'],
            'user', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_project_updater_id_user', 'project');
        $this->dropForeignKey('fx_project_creator_id_user', 'project');
        $this->dropTable('`project`');
    }
}
