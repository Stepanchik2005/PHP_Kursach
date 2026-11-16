<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Вхід у систему';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mt-3">
                <div class="text-center mb-4">
                    <span class="badge bg-teal-soft px-3 py-2 rounded-pill mb-2">🔐 Авторизація</span>
                    <h2 class="fw-bold mb-1"><?= Html::encode($this->title) ?></h2>
                    <p class="text-muted small mb-0">Введіть ваші облікові дані для входу в блог</p>
                </div>

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'email')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'example@mail.com',
                ])->label('Електронна пошта (Email)') ?>

                <?= $form->field($model, 'password')->passwordInput([
                    'placeholder' => '••••••••',
                ])->label('Пароль') ?>

                <?= $form->field($model, 'rememberMe')->checkbox([
                    'label' => "Запам'ятати мене",
                ]) ?>

                <div class="d-grid mt-4">
                    <?= Html::submitButton('Увійти', [
                        'class' => 'btn btn-teal btn-lg rounded-pill',
                        'name' => 'login-button',
                    ]) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>