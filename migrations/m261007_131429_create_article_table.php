<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 */
class m261007_131429_create_article_table extends Migration
{
   public function safeUp()
{
    $this->createTable('{{%article}}', [
        'id' => $this->primaryKey(),
        'title' => $this->string()->notNull(),
        'description' => $this->text(),
        'content' => $this->text(),
        'date' => $this->date(),
        'image' => $this->string(),
    ]);
}

public function safeDown()
{
    $this->dropTable('{{%article}}');
}
}
