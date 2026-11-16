<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Контакти';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <div class="hero-travel p-4 p-md-5 mb-4">
        <span class="badge bg-warning text-dark mb-2 px-3 py-2 rounded-pill fw-semibold">✉️ Зворотній зв'язок</span>
        <h1 class="display-6 fw-bold mb-2">Контакти редакції MandryBlog</h1>
        <p class="lead mb-0">Маєте ідею для нового маршруту або пропозицію співпраці? Напишіть нам!</p>
    </div>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <div class="alert alert-success rounded-4 p-4">
            Дякуємо за звернення! Ваше повідомлення успішно надіслано авторам блогу.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label("Ваше ім'я") ?>

                    <?= $form->field($model, 'email')->label('Електронна пошта') ?>

                    <?= $form->field($model, 'subject')->label('Тема повідомлення') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 5])->label('Текст повідомлення') ?>

                    <div class="form-group mt-3">
                        <?= Html::submitButton('Надіслати повідомлення', ['class' => 'btn btn-teal rounded-pill px-4']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h4 class="fw-bold text-teal mb-3">📍 Наші координати</h4>
                    <p class="text-muted">Ми завжди раді новим історіям мандрівників та фотозвітам з подорожей.</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0"><strong>Email:</strong> info@mandryblog.ua</li>
                        <li class="list-group-item px-0"><strong>Місто:</strong> м. Суми, Україна</li>
                        <li class="list-group-item px-0"><strong>Кафедра:</strong> Інформаційних технологій (СумДУ)</li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>