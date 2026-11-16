<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CommentForm extends Model
{
    public $comment;
    public $parent_id;

    public function rules()
    {
        return [
            [['comment'], 'required', 'message' => 'Введіть текст коментаря'],
            [['comment'], 'string', 'length' => [2, 1000]],
            [['parent_id'], 'integer'],
        ];
    }

    public function saveComment($article_id)
    {
        $comment = new Comment();
        $comment->text = $this->comment;
        $comment->user_id = Yii::$app->user->id;
        $comment->article_id = $article_id;
        $comment->parent_id = $this->parent_id ?: null;
        $comment->status = Comment::STATUS_ALLOW; // сразу публикуем (в админке можно скрыть/удалить)
        $comment->created_at = date('Y-m-d H:i:s');

        return $comment->save();
    }
}
