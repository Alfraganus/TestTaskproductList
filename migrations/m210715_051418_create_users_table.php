<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m210715_051418_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->null(),
            'password' => $this->string(255)->null(),
            'fullname' => $this->string(255)->null(),
            'auth_key' => $this->string(255)->null(),
            'status' => $this->smallInteger(1)->defaultValue(10),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
