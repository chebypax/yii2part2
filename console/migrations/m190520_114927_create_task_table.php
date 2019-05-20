<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m190520_114927_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'project_id' => $this->integer()->null(),
            'executor_id' => $this->integer()->null(),
            'started_at' => $this->integer()->null(),
            'completed_at' => $this->integer()->null(),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null(),
        ]);
        $this->addForeignKey('fx_task_executor_id_user', 'task', ['executor_id'], 'user', ['id']);
        $this->addForeignKey('fx_task_creator_id_user', 'task', ['creator_id'], 'user', ['id']);
        $this->addForeignKey('fx_task_updater_id_user', 'task', ['updater_id'], 'user', ['id']);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_task_updater_id_user', 'task');
        $this->dropForeignKey('fx_task_creator_id_user', 'task');
        $this->dropForeignKey('fx_task_executor_id_user', 'task');
        $this->dropTable('task');
        return;
    }
}
