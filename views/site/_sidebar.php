<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Category[] $categories */
/** @var app\models\Tag[] $tags */
/** @var app\models\Article[] $popularArticles */
?>

<aside class="travel-sidebar">
    <!-- Блок Категории -->
    <div class="card border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3 text-teal">🧭 Категорії подорожей</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                    <a href="<?= Url::to(['/site/index']) ?>" class="text-decoration-none text-dark fw-medium">Усі статті</a>
                </li>
                <?php foreach ($categories as $category): ?>
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <a href="<?= Url::to(['/site/category', 'id' => $category->id]) ?>" class="text-decoration-none text-dark category-link">
                            <?= Html::encode($category->title) ?>
                        </a>
                        <span class="badge rounded-pill bg-teal-soft text-teal">
                            <?= $category->getArticlesCount() ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Блок Облако тегов (поиск по меткам) -->
    <div class="card border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3 text-teal">🏷️ Пошук за мітками</h5>
            <div class="d-flex flex-wrap gap-2">
                <?php foreach ($tags as $tag): ?>
                    <a href="<?= Url::to(['/site/tag', 'id' => $tag->id]) ?>" class="btn btn-sm btn-outline-teal rounded-pill">
                        #<?= Html::encode($tag->title) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Блок Популярные статьи -->
    <?php if (!empty($popularArticles)): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3 text-teal">🔥 Популярні маршрути</h5>
                <?php foreach ($popularArticles as $pop): ?>
                    <div class="d-flex align-items-center mb-3 pb-2 border-bottom last-no-border">
                        <img src="<?= Html::encode($pop->getImage()) ?>" alt="<?= Html::encode($pop->title) ?>"
                            class="rounded-3 me-3" style="width: 64px; height: 64px; object-fit: cover;">
                        <div>
                            <a href="<?= Url::to(['/site/view', 'id' => $pop->id]) ?>" class="text-decoration-none text-dark fw-semibold d-block lh-sm mb-1">
                                <?= Html::encode($pop->title) ?>
                            </a>
                            <small class="text-muted">👁️ <?= (int)$pop->viewed ?> переглядів</small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</aside>