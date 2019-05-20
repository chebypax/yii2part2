<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project_user}}`.
 */
class m190520_120948_create_project_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('`project_user`', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'role' => "enum ('manager', 'developer', 'tester')",
        ]);

        $this->addForeignKey('fx_project_user_user_id_user', 'project_user', ['user_id'],
        'user', ['id']);
        $this->addForeignKey('fx_project_user_project_id_project', 'project_user', ['project_id'],
            'project', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_project_user_project_id_project', 'project_user');
        $this->dropForeignKey('fx_project_user_user_id_user', 'project_user');
        $this->dropTable('`project_user`');
    }
}

//id - integer, primaryKey
//project_id - integer, not null
//user_id - integer, not null
//role - enum ('manager', 'developer', 'tester'), спец. метода в миграциях для типа enum нет, описывается просто SQL кодом
//поля user_id связано с полем id таблицы user, project_id с полем id таблицы project
