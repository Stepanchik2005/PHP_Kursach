<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var app\models\ArticleSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Управління статтями';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('+ Створити статтю', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
            [
                'attribute' => 'category_id',
                'label' => 'Категорія',
                'value' => function ($model) {
                    return $model->category ? $model->category->title : '—';
                },
            ],
            [
                'label' => 'Мітки',
                'value' => function ($model) {
                    return implode(', ', ArrayHelper::getColumn($model->tags, 'title')) ?: '—';
                },
            ],
            'date',
            'viewed',
            [
                'format' => 'html',
                'label' => 'Фото',
                'value' => function ($data) {
                    return Html::img($data->getImage(), ['width' => 80, 'class' => 'rounded']);
                },
            ],
            [
                'class' => ActionColumn::class,
            ],
        ],
    ]); ?>

</div>