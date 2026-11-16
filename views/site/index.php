<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\LinkPager;

/** @var yii\web\View $this */
/** @var app\models\Article[] $articles */
/** @var yii\data\Pagination $pagination */
/** @var string $pageTitle */
/** @var string $pageSubtitle */
/** @var app\models\Category[] $categories */
/** @var app\models\Tag[] $tags */
/** @var app\models\Article[] $popularArticles */

$this->title = $pageTitle . ' | MandryBlog';
?>

<div class="site-index">
    <!-- Hero-блок в тематике путешествий -->
    <div class="hero-travel p-4 p-md-5 mb-4 shadow-sm">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-warning text-dark mb-2 px-3 py-2 rounded-pill fw-semibold">🌍 Блог про подорожі</span>
                <h1 class="display-6 fw-bold mb-2"><?= Html::encode($pageTitle) ?></h1>
                <p class="lead mb-0 text-white-50"><?= Html::encode($pageSubtitle) ?></p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Основная колонка со статьями -->
        <div class="col-lg-8">
            <?php if (empty($articles)): ?>
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                    <h4 class="text-muted mb-3">У цьому розділі поки що немає публікацій</h4>
                    <p class="text-muted mb-4">Додайте першу статтю про подорожі через адмін-панель!</p>
                    <div>
                        <a href="<?= Url::to(['/site/index']) ?>" class="btn btn-teal rounded-pill px-4">Повернутися до всіх статей</a>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($articles as $article): ?>
                    <article class="card article-card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <a href="<?= Url::to(['/site/view', 'id' => $article->id]) ?>">
                            <img src="<?= Html::encode($article->getImage()) ?>"
                                alt="<?= Html::encode($article->title) ?>"
                                class="article-card-img">
                        </a>
                        <div class="card-body p-4">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <?php if ($article->category): ?>
                                    <a href="<?= Url::to(['/site/category', 'id' => $article->category->id]) ?>"
                                        class="badge bg-teal-soft text-teal text-decoration-none px-3 py-2 rounded-pill">
                                        🧭 <?= Html::encode($article->category->title) ?>
                                    </a>
                                <?php endif; ?>
                                <small class="text-muted">📅 <?= Html::encode($article->date) ?></small>
                                <small class="text-muted">• 👁️ <?= (int)$article->viewed ?></small>
                                <small class="text-muted">• 💬 <?= $article->getAllCommentsCount() ?></small>
                            </div>

                            <h2 class="h4 fw-bold mb-2">
                                <a href="<?= Url::to(['/site/view', 'id' => $article->id]) ?>" class="text-decoration-none text-dark">
                                    <?= Html::encode($article->title) ?>
                                </a>
                            </h2>

                            <p class="text-muted mb-3">
                                <?= Html::encode($article->description) ?>
                            </p>

                            <?php if (!empty($article->tags)): ?>
                                <div class="d-flex flex-wrap gap-1 mb-3">
                                    <?php foreach ($article->tags as $tag): ?>
                                        <a href="<?= Url::to(['/site/tag', 'id' => $tag->id]) ?>"
                                            class="badge bg-light text-secondary border text-decoration-none">
                                            #<?= Html::encode($tag->title) ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <small class="text-muted">
                                    Автор: <strong><?= $article->author ? Html::encode($article->author->username) : 'Мандрівник' ?></strong>
                                </small>
                                <a href="<?= Url::to(['/site/view', 'id' => $article->id]) ?>" class="btn btn-teal btn-sm rounded-pill px-4">
                                    Читати далі →
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>

                <!-- Пагинация -->
                <div class="d-flex justify-content-center mt-4">
                    <?= LinkPager::widget([
                        'pagination' => $pagination,
                    ]) ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Правый сайдбар -->
        <div class="col-lg-4">
            <?= $this->render('_sidebar', [
                'categories' => $categories,
                'tags' => $tags,
                'popularArticles' => $popularArticles,
            ]) ?>
        </div>
    </div>
</div>