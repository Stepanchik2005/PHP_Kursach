<?php

use yii\helpers\Html;
use yii\bootstrap5\LinkPager; // или yii\widgets\LinkPager в зависимости от версии Bootstrap

/** @var yii\web\View $this */
/** @var app\models\Post[] $posts */
/** @var yii\data\Pagination $pagination */

$this->title = 'Публікації блогу';
$this->registerCssFile('@web/css/post.css');
?>

<div class="site-posts">
    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <?php if (empty($posts)): ?>
        <p class="text-muted">Постів поки що немає.</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <div class="post-card">
                <h2 class="post-title"><?= Html::encode($post->title) ?></h2>
                <p class="post-text"><?= Html::encode($post->content) ?></p>

                <?php if ($post->published): ?>
                    <p class="post-date">
                        <strong>Дата публікації:</strong> <?= Html::encode($post->published_at) ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="d-flex justify-content-center mt-4">
            <?= LinkPager::widget([
                'pagination' => $pagination,
            ]) ?>
        </div>
    <?php endif; ?>
</div>