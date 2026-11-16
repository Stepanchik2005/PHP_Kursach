<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m261007_121730_create_user_table extends Migration
{
   
   public function safeUp()
{
    $this->createTable('{{%user}}', [
        'id' => $this->primaryKey(),
        'name' => $this->string()->notNull(),
        'email' => $this->string()->notNull()->unique(),
        'password' => $this->string()->notNull(),
        'auth_key' => $this->string(32)->null(),
        'access_token' => $this->string(64)->null(),
    ]);
}

public function safeDown()
{
    $this->dropTable('{{%user}}');
}
}
