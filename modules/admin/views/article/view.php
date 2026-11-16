<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Article $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Статті', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Завантажити фото', ['set-image', 'id' => $model->id], ['class' => 'btn btn-info text-white']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ви впевнені, що хочете видалити цю статтю?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'category_id',
                'value' => $model->category ? $model->category->title : 'Без категорії',
            ],
            [
                'label' => 'Мітки (теги)',
                'value' => implode(', ', ArrayHelper::getColumn($model->tags, 'title')) ?: 'Немає міток',
            ],
            'description:ntext',
            'content:ntext',
            'date',
            'viewed',
            [
                'format' => 'html',
                'attribute' => 'image',
                'value' => function ($data) {
                    return Html::img($data->getImage(), ['width' => 150, 'class' => 'img-thumbnail']);
                }
            ],
        ],
    ]) ?>

</div>