<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Модерація коментарів';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'article_id',
                'label' => 'Стаття',
                'value' => function ($model) {
                    return $model->article ? $model->article->title : 'Видалена стаття';
                }
            ],
            [
                'attribute' => 'user_id',
                'label' => 'Користувач',
                'value' => function ($model) {
                    return $model->user ? $model->user->username : 'Гість';
                }
            ],
            'text:ntext',
            'created_at',
            [
                'label' => 'Статус',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->isAllowed()
                        ? '<span class="badge bg-success">Опубліковано</span>'
                        : '<span class="badge bg-secondary">Приховано</span>';
                }
            ],
            [
                'label' => 'Дії',
                'format' => 'raw',
                'value' => function ($model) {
                    $toggleBtn = $model->isAllowed()
                        ? Html::a('Приховати', ['disallow', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm me-1'])
                        : Html::a('Опублікувати', ['allow', 'id' => $model->id], ['class' => 'btn btn-success btn-sm me-1']);

                    $deleteBtn = Html::a('Видалити', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Видалити цей коментар?',
                            'method' => 'post',
                        ],
                    ]);

                    return $toggleBtn . $deleteBtn;
                }
            ],
        ],
    ]); ?>

</div>