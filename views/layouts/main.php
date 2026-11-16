<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title ?: 'MandryBlog — Блог про подорожі та пригоди') ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100 bg-sand">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => '✈️ MandryBlog',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-teal-dark shadow-sm fixed-top']
        ]);

        $menuItems = [
            ['label' => 'Головна', 'url' => ['/site/index']],
            ['label' => 'Про блог', 'url' => ['/site/about']],
            ['label' => 'Контакти', 'url' => ['/site/contact']],
        ];

        if (Yii::$app->user->isGuest) {
            if (file_exists(Yii::getAlias('@app/controllers/AuthController.php'))) {
                $menuItems[] = ['label' => 'Реєстрація', 'url' => ['/auth/signup']];
            }
            $menuItems[] = ['label' => 'Вхід', 'url' => ['/site/login']];
        } else {
            $menuItems[] = ['label' => '⚙️ Адмін-панель', 'url' => ['/admin/article/index']];
            $menuItems[] = '<li class="nav-item">'
                . Html::beginForm(['/site/logout'])
                . Html::submitButton(
                    'Вийти (' . Html::encode(Yii::$app->user->identity->username) . ')',
                    ['class' => 'nav-link btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ms-auto'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main" style="padding-top: 76px;">
        <div class="container py-3">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-4 bg-teal-dark text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <span class="fw-bold">✈️ MandryBlog</span> — Авторський веб-блог про подорожі світом та Україною
                </div>
                <div class="col-md-6 text-center text-md-end text-white-50 small">
                    СумДУ • Спеціальність 122 «Комп'ютерні науки» • <?= date('Y') ?>
                </div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>