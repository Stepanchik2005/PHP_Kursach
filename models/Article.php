<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $content
 * @property string|null $date
 * @property string|null $image
 * @property int|null $viewed
 * @property int|null $user_id
 * @property int|null $category_id
 *
 * @property Category $category
 * @property User $author
 * @property Tag[] $tags
 * @property Comment[] $comments
 */
class Article extends ActiveRecord
{
    /**
     * Виртуальное свойство для мультиселекта тегов в форме создания/редактирования
     * @var array
     */
    public $selectedTags = [];

    public static function tableName()
    {
        return '{{%article}}';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'description', 'content'], 'string'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['viewed', 'user_id', 'category_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['selectedTags'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Короткий опис',
            'content' => 'Текст статті',
            'date' => 'Дата публікації',
            'image' => 'Зображення',
            'viewed' => 'Перегляди',
            'user_id' => 'Автор',
            'category_id' => 'Категорія',
            'selectedTags' => 'Мітки (теги)',
        ];
    }

    // --- Работа с изображениями ---

    public function saveImage($filename)
    {
        $this->image = $filename;
        return $this->save(false);
    }

    public function getImage()
    {
        return ($this->image) ? '/uploads/' . $this->image : 'https://placehold.co/800x450/e2e8f0/475569?text=Travel+Blog';
    }

    public function deleteImage()
    {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        ArticleTag::deleteAll(['article_id' => $this->id]);
        Comment::deleteAll(['article_id' => $this->id]);
        return parent::beforeDelete();
    }

    // --- Связи ActiveRecord ---

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('{{%article_tag}}', ['article_id' => 'id']);
    }


    public function getComments()
    {
        return $this->hasMany(Comment::class, ['article_id' => 'id'])
            ->andWhere(['parent_id' => null, 'status' => Comment::STATUS_ALLOW])
            ->orderBy(['created_at' => SORT_DESC]);
    }

    public function getAllCommentsCount()
    {
        return $this->hasMany(Comment::class, ['article_id' => 'id'])
            ->andWhere(['status' => Comment::STATUS_ALLOW])
            ->count();
    }



    public function loadSelectedTags()
    {
        $this->selectedTags = ArrayHelper::getColumn($this->tags, 'id');
    }

    public function saveTags()
    {
        ArticleTag::deleteAll(['article_id' => $this->id]);
        if (is_array($this->selectedTags)) {
            foreach ($this->selectedTags as $tagId) {
                $articleTag = new ArticleTag();
                $articleTag->article_id = $this->id;
                $articleTag->tag_id = (int) $tagId;
                $articleTag->save();
            }
        }
    }

    public function viewedCounter()
    {
        $this->viewed = (int) $this->viewed + 1;
        return $this->save(false);
    }
}
