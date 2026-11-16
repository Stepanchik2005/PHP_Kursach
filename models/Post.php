<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $published
 * @property string $published_at
 */
class Post extends ActiveRecord
{
    public static function tableName()
    {
        return 'posts';
    }
}