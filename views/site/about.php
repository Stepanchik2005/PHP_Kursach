<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Про блог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <div class="hero-travel p-4 p-md-5 mb-4">
        <span class="badge bg-warning text-dark mb-2 px-3 py-2 rounded-pill fw-semibold">✈️ Про проєкт</span>
        <h1 class="display-6 fw-bold mb-2">MandryBlog — твій путівник світом</h1>
        <p class="lead mb-0">Авторська веб-орієнтована інформаційна система для мандрівників, дослідників та любителів активного відпочинку.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                <h4 class="fw-bold text-teal mb-3">🌍 Мета та ідея блогу</h4>
                <p class="text-muted">
                    <strong>MandryBlog</strong> створений для обміну перевіреними маршрутами, порадами щодо бюджетних мандрівок,
                    оглядами гірських треків України та Європи, а також гастрономічними відкриттями.
                </p>
                <p class="text-muted mb-0">
                    Кожен читач може зручно фільтрувати статті за категоріями, шукати матеріали за тематичними мітками (тегами),
                    ділитися публікаціями у соціальних мережах та брати участь в обговореннях у коментарях.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                <h4 class="fw-bold text-teal mb-3">⚙️ Технічна реалізація</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0"><strong>Архітектура:</strong> Модель – Вид – Контролер (MVC)</li>
                    <li class="list-group-item px-0"><strong>Фреймворк:</strong> PHP / Yii2 Basic + Bootstrap 5</li>
                    <li class="list-group-item px-0"><strong>Робота з БД:</strong> шаблон проектування Active Record</li>
                    <li class="list-group-item px-0"><strong>Функціонал:</strong> CRUD статей, категорії, теги, деревоподібні коментарі, модерація</li>
                </ul>
                <div class="mt-3">
                    <a href="<?= Url::to(['/site/index']) ?>" class="btn btn-teal rounded-pill px-4">Перейти до статей →</a>
                </div>
            </div>
        </div>
    </div>
</div>