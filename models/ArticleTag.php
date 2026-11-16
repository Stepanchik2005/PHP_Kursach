<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $article_id
 * @property int $tag_id
 */
class ArticleTag extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%article_tag}}';
    }

    public function rules()
    {
        return [
            [['article_id', 'tag_id'], 'required'],
            [['article_id', 'tag_id'], 'integer'],
        ];
    }
}
