<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Article $article */
/** @var app\models\Comment[] $comments */
/** @var app\models\CommentForm $commentForm */
/** @var app\models\Category[] $categories */
/** @var app\models\Tag[] $tags */
/** @var app\models\Article[] $popularArticles */

$this->title = $article->title . ' | MandryBlog';
$this->params['breadcrumbs'][] = ['label' => 'Блог', 'url' => ['/site/index']];
if ($article->category) {
    $this->params['breadcrumbs'][] = [
        'label' => $article->category->title,
        'url' => ['/site/category', 'id' => $article->category->id]
    ];
}
$this->params['breadcrumbs'][] = $article->title;

$shareUrl = urlencode(Url::to(['/site/view', 'id' => $article->id], true));
$shareTitle = urlencode($article->title);
?>

<div class="site-single">
    <div class="row g-4">
        <!-- Левая колонка: Статья + Соцсети + Комментарии -->
        <div class="col-lg-8">
            <article class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <img src="<?= Html::encode($article->getImage()) ?>"
                    alt="<?= Html::encode($article->title) ?>"
                    class="w-100" style="max-height: 430px; object-fit: cover;">

                <div class="card-body p-4 p-md-5">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                        <?php if ($article->category): ?>
                            <a href="<?= Url::to(['/site/category', 'id' => $article->category->id]) ?>"
                                class="badge bg-teal-soft text-teal text-decoration-none px-3 py-2 rounded-pill">
                                🧭 <?= Html::encode($article->category->title) ?>
                            </a>
                        <?php endif; ?>
                        <span class="text-muted small">📅 <?= Html::encode($article->date) ?></span>
                        <span class="text-muted small">• ✍️ <?= $article->author ? Html::encode($article->author->username) : 'Автор блогу' ?></span>
                        <span class="text-muted small">• 👁️ <?= (int)$article->viewed ?> переглядів</span>
                    </div>

                    <h1 class="fw-bold mb-3"><?= Html::encode($article->title) ?></h1>

                    <?php if ($article->description): ?>
                        <p class="lead text-muted border-start border-4 border-success ps-3 mb-4">
                            <?= Html::encode($article->description) ?>
                        </p>
                    <?php endif; ?>

                    <div class="article-content fs-6 lh-lg mb-4">
                        <?= nl2br(Html::encode($article->content)) ?>
                    </div>

                    <!-- Теги статьи -->
                    <?php if (!empty($article->tags)): ?>
                        <div class="mb-4 pt-3 border-top">
                            <span class="fw-semibold me-2 text-muted">Мітки:</span>
                            <?php foreach ($article->tags as $tag): ?>
                                <a href="<?= Url::to(['/site/tag', 'id' => $tag->id]) ?>"
                                    class="btn btn-sm btn-outline-teal rounded-pill me-1 mb-1">
                                    #<?= Html::encode($tag->title) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Кнопки шеринга в социальные сети (требование п. 3.2.1) -->
                    <div class="p-3 bg-light rounded-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <span class="fw-semibold text-dark">🔗 Поділитися статтею в соцмережах:</span>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="https://t.me/share/url?url=<?= $shareUrl ?>&text=<?= $shareTitle ?>"
                                target="_blank" rel="noopener" class="btn btn-sm btn-primary">
                                Telegram
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>"
                                target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                                Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?= $shareUrl ?>&text=<?= $shareTitle ?>"
                                target="_blank" rel="noopener" class="btn btn-sm btn-dark">
                                X (Twitter)
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                onclick="navigator.clipboard.writeText(window.location.href); this.innerText='Скопійовано!';">
                                Копіювати лінк
                            </button>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Блок комментариев и ответов на комментарии -->
            <section id="comments-section" class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <h3 class="h4 fw-bold mb-4">💬 Коментарі (<?= $article->getAllCommentsCount() ?>)</h3>

                <?php if (!Yii::$app->user->isGuest): ?>
                    <div class="mb-4 p-3 bg-light rounded-3" id="comment-form-box">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold" id="reply-indicator">Залишити коментар як <strong><?= Html::encode(Yii::$app->user->identity->username) ?></strong></span>
                            <button type="button" id="cancel-reply-btn" class="btn btn-sm btn-link text-danger d-none" onclick="cancelReply()">
                                Скасувати відповідь ✕
                            </button>
                        </div>

                        <?php $form = ActiveForm::begin([
                            'action' => ['/site/comment', 'id' => $article->id],
                            'method' => 'post',
                        ]); ?>

                        <?= $form->field($commentForm, 'parent_id')->hiddenInput(['id' => 'comment-parent-id'])->label(false) ?>

                        <?= $form->field($commentForm, 'comment')->textarea([
                            'rows' => 3,
                            'placeholder' => 'Поділіться враженнями про маршрут або задайте питання автору...',
                            'id' => 'comment-textarea'
                        ])->label(false) ?>

                        <?= Html::submitButton('Надіслати коментар', ['class' => 'btn btn-teal rounded-pill px-4']) ?>

                        <?php ActiveForm::end(); ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info rounded-3 mb-4">
                        Щоб залишати коментарі та відповідати іншим читачам, будь ласка,
                        <a href="<?= Url::to(['/site/login']) ?>" class="alert-link">увійдіть в акаунт</a>.
                    </div>
                <?php endif; ?>

                <!-- Список корневых комментариев и вложенных ответов -->
                <?php if (empty($comments)): ?>
                    <p class="text-muted text-center py-3 mb-0">Коментарів поки немає. Будьте першим!</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="border rounded-3 p-3 mb-3 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong class="text-teal"><?= $comment->user ? Html::encode($comment->user->username) : 'Користувач' ?></strong>
                                    <small class="text-muted ms-2"><?= Html::encode($comment->created_at) ?></small>
                                </div>
                                <?php if (!Yii::$app->user->isGuest): ?>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-teal rounded-pill py-0 px-3"
                                        onclick="setReply(<?= $comment->id ?>, '<?= Html::encode($comment->user ? $comment->user->username : 'Користувач') ?>')">
                                        ↩️ Відповісти
                                    </button>
                                <?php endif; ?>
                            </div>
                            <p class="mb-0"><?= nl2br(Html::encode($comment->text)) ?></p>

                            <!-- Вложенные ответы на комментарий -->
                            <?php if (!empty($comment->replies)): ?>
                                <div class="mt-3 ps-3 ps-md-4 border-start border-3 border-teal">
                                    <?php foreach ($comment->replies as $reply): ?>
                                        <div class="bg-light rounded-3 p-3 mb-2">
                                            <div class="mb-1">
                                                <strong class="text-dark">↳ <?= $reply->user ? Html::encode($reply->user->username) : 'Користувач' ?></strong>
                                                <small class="text-muted ms-2"><?= Html::encode($reply->created_at) ?></small>
                                            </div>
                                            <p class="mb-0 small"><?= nl2br(Html::encode($reply->text)) ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
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

<script>
    function setReply(commentId, username) {
        document.getElementById('comment-parent-id').value = commentId;
        document.getElementById('reply-indicator').innerHTML = 'Відповідь користувачу <strong>' + username + '</strong>:';
        document.getElementById('cancel-reply-btn').classList.remove('d-none');
        const textarea = document.getElementById('comment-textarea');
        textarea.focus();
        textarea.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }

    function cancelReply() {
        document.getElementById('comment-parent-id').value = '';
        document.getElementById('reply-indicator').innerHTML = 'Залишити коментар:';
        document.getElementById('cancel-reply-btn').classList.add('d-none');
    }
</script>