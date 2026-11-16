<?php

use yii\db\Migration;

/**
 * Инициализация и обновление схемы БД для блога о путешествиях (Вариант 2).
 */
class m261116_123521_init_travel_blog_schema extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        // 1. Таблица пользователей (если еще не создана в БД)
        if ($this->db->getTableSchema('{{%user}}', true) === null) {
            $this->createTable('{{%user}}', [
                'id' => $this->primaryKey(),
                'username' => $this->string()->notNull()->unique(),
                'email' => $this->string()->notNull()->unique(),
                'password_hash' => $this->string()->notNull(),
                'auth_key' => $this->string(32),
                'is_admin' => $this->boolean()->defaultValue(0),
            ], $tableOptions);
        } else {
            $userSchema = $this->db->getTableSchema('{{%user}}', true);
            if (!isset($userSchema->columns['is_admin'])) {
                $this->addColumn('{{%user}}', 'is_admin', $this->boolean()->defaultValue(0));
            }
            if (!isset($userSchema->columns['email'])) {
                $this->addColumn('{{%user}}', 'email', $this->string());
            }
        }

        // 2. Таблица категорий
        if ($this->db->getTableSchema('{{%category}}', true) === null) {
            $this->createTable('{{%category}}', [
                'id' => $this->primaryKey(),
                'title' => $this->string()->notNull(),
                'description' => $this->text(),
            ], $tableOptions);
        }

        // 3. Таблица статей (создаем или дополняем недостающими колонками)
        if ($this->db->getTableSchema('{{%article}}', true) === null) {
            $this->createTable('{{%article}}', [
                'id' => $this->primaryKey(),
                'title' => $this->string()->notNull(),
                'description' => $this->text(),
                'content' => $this->text(),
                'date' => $this->date(),
                'image' => $this->string(),
                'viewed' => $this->integer()->defaultValue(0),
                'user_id' => $this->integer(),
                'category_id' => $this->integer(),
            ], $tableOptions);
        } else {
            $articleSchema = $this->db->getTableSchema('{{%article}}', true);
            if (!isset($articleSchema->columns['viewed'])) {
                $this->addColumn('{{%article}}', 'viewed', $this->integer()->defaultValue(0));
            }
            if (!isset($articleSchema->columns['user_id'])) {
                $this->addColumn('{{%article}}', 'user_id', $this->integer());
            }
            if (!isset($articleSchema->columns['category_id'])) {
                $this->addColumn('{{%article}}', 'category_id', $this->integer());
            }
        }

        // 4. Таблица тегов (меток)
        if ($this->db->getTableSchema('{{%tag}}', true) === null) {
            $this->createTable('{{%tag}}', [
                'id' => $this->primaryKey(),
                'title' => $this->string()->notNull(),
            ], $tableOptions);
        }

        // 5. Связующая таблица статей и тегов (Many-to-Many)
        if ($this->db->getTableSchema('{{%article_tag}}', true) === null) {
            $this->createTable('{{%article_tag}}', [
                'id' => $this->primaryKey(),
                'article_id' => $this->integer()->notNull(),
                'tag_id' => $this->integer()->notNull(),
            ], $tableOptions);

            $this->createIndex('idx-article_tag-article_id', '{{%article_tag}}', 'article_id');
            $this->createIndex('idx-article_tag-tag_id', '{{%article_tag}}', 'tag_id');
        }

        // 6. Таблица комментариев (с поддержкой вложенных ответов через parent_id)
        if ($this->db->getTableSchema('{{%comment}}', true) === null) {
            $this->createTable('{{%comment}}', [
                'id' => $this->primaryKey(),
                'text' => $this->text()->notNull(),
                'user_id' => $this->integer()->notNull(),
                'article_id' => $this->integer()->notNull(),
                'parent_id' => $this->integer()->defaultValue(null),
                'status' => $this->integer()->defaultValue(1), // 1 - опубликован, 0 - скрыт
                'created_at' => $this->dateTime(),
            ], $tableOptions);

            $this->createIndex('idx-comment-article_id', '{{%comment}}', 'article_id');
            $this->createIndex('idx-comment-parent_id', '{{%comment}}', 'parent_id');
        }
    }

    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
        $this->dropTable('{{%article_tag}}');
        $this->dropTable('{{%tag}}');
        $this->dropTable('{{%category}}');
    }
}
