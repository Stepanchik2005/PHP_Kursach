<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
    public $image;

    public function rules()
    {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg,png,jpeg,webp'],
        ];
    }

    public function uploadFile(UploadedFile $file, $currentImage = null)
    {
        $this->image = $file;

        if ($this->validate()) {
            $folder = Yii::getAlias('@webroot') . '/uploads/';
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            // Удаляем старый файл, если он есть
            if ($currentImage && file_exists($folder . $currentImage)) {
                unlink($folder . $currentImage);
            }

            $filename = strtolower(md5(uniqid($file->baseName)) . '.' . $file->extension);
            $file->saveAs($folder . $filename);
            return $filename;
        }

        return false;
    }
    public function deleteCurrentImage($currentImage)
    {
        if (!empty($currentImage) && $this->fileExists($currentImage)) {
            unlink($this->getFolder() . $currentImage);
        }
    }

    public function fileExists($currentImage)
    {
        if (!empty($currentImage) && $currentImage != null) {
            return file_exists($this->getFolder() . $currentImage);
        }
        return false;
    }

    public function getFolder()
    {
        return \Yii::getAlias('@webroot') . '/uploads/';
    }
}
