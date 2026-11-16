<?php

namespace app\models;

use yii\base\Model;

class EntryForm extends Model
{
    public $name;
    public $email;

    public function rules()
    {
        return [
           
            [['name', 'email'], 'required', 'message' => 'Поле не може бути порожнім.'],
           
            ['name', 'string', 'min' => 2, 'tooShort' => 'Ім’я має містити щонайменше 2 символи.'],
        
            ['email', 'email', 'message' => 'Введіть коректну адресу електронної пошти.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => "Ваше ім'я",
            'email' => 'Електронна пошта',
        ];
    }
}