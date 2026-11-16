<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\EntryForm $model */

$this->title = 'Реєстраційна форма користувача';
?>

<style>
    .form-container {
        max-width: 550px;
        margin: 40px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid #e2e8f0;
    }
    .form-title {
        text-align: center;
        color: #1e293b;
        margin-bottom: 25px;
        font-weight: 700;
    }
    .form-container .form-group {
        margin-bottom: 20px;
    }
    .btn-submit {
        width: 100%;
        padding: 12px;
        background: #2563eb;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 16px;
        color: #ffffff;
        transition: background 0.2s ease;
    }
    .btn-submit:hover {
        background: #1d4ed8;
        color: #ffffff;
    }
</style>

<div class="form-container">
    <h2 class="form-title"><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin([
        'id' => 'entry-form',
        'enableClientValidation' => true,
    ]); ?>

        <?= $form->field($model, 'name')->textInput([
            'placeholder' => 'Введіть ваше повне ім’я',
            'class' => 'form-control',
            'autofocus' => true
        ]) ?>

        <?= $form->field($model, 'email')->input('email', [
            'placeholder' => 'example@domain.com',
            'class' => 'form-control'
        ]) ?>

        <div class="form-group" style="margin-top: 30px;">
            <?= Html::submitButton('Надіслати дані', ['class' => 'btn btn-submit']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>