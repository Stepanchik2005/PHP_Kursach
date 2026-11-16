<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property int $article_id
 * @property int|null $parent_id
 * @property int $status
 * @property string|null $created_at
 *
 * @property User $user
 * @property Article $article
 * @property Comment[] $replies
 */
class Comment extends ActiveRecord
{
    const STATUS_DISALLOW = 0;
    const STATUS_ALLOW = 1;

    public static function tableName()
    {
        return '{{%comment}}';
    }

    public function rules()
    {
        return [
            [['text', 'user_id', 'article_id'], 'required'],
            [['text'], 'string', 'min' => 2, 'max' => 1000],
            [['user_id', 'article_id', 'parent_id', 'status'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Коментар',
            'user_id' => 'Автор',
            'article_id' => 'Стаття',
            'parent_id' => 'Відповідь на коментар',
            'status' => 'Статус',
            'created_at' => 'Дата створення',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getArticle()
    {
        return $this->hasOne(Article::class, ['id' => 'article_id']);
    }

    /**
     * Дочерние ответы на этот комментарий
     */
    public function getReplies()
    {
        return $this->hasMany(Comment::class, ['parent_id' => 'id'])
            ->andWhere(['status' => self::STATUS_ALLOW])
            ->orderBy(['created_at' => SORT_ASC]);
    }

    public function isAllowed()
    {
        return $this->status == self::STATUS_ALLOW;
    }

    public function allow()
    {
        $this->status = self::STATUS_ALLOW;
        return $this->save(false);
    }

    public function disallow()
    {
        $this->status = self::STATUS_DISALLOW;
        return $this->save(false);
    }
}
