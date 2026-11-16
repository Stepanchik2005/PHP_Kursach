<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\EntryForm $model */

$this->title = 'Успішно надіслано';
?>

<style>
    .result-card {
        max-width: 550px;
        margin: 50px auto;
        padding: 35px;
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        text-align: center;
    }
    .success-badge {
        display: inline-block;
        padding: 6px 14px;
        background: #dcfce7;
        color: #166534;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 15px;
    }
    .data-table {
        margin: 25px 0;
        text-align: left;
        width: 100%;
        border-collapse: collapse;
    }
    .data-table td {
        padding: 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 15px;
    }
    .data-label {
        color: #64748b;
        font-weight: 600;
        width: 40%;
    }
    .data-value {
        color: #0f172a;
        font-weight: 500;
    }
</style>

<div class="result-card">
    <div class="success-badge">Дані успішно отримані</div>
    <h2 style="color: #0f172a; margin-top: 0;">Підтвердження реєстрації</h2>
    <p style="color: #64748b;">Нижче наведено інформацію, яку ви щойно надіслали:</p>

    <table class="data-table">
        <tr>
            <td class="data-label">Ім’я користувача:</td>
            <td class="data-value"><?= Html::encode($model->name) ?></td>
        </tr>
        <tr>
            <td class="data-label">Електронна пошта:</td>
            <td class="data-value"><?= Html::encode($model->email) ?></td>
        </tr>
    </table>

    <div style="margin-top: 25px;">
        <?= Html::a('&larr; Заповнити форму ще раз', ['site/entry'], ['class' => 'btn btn-outline-primary']) ?>
    </div>
</div>