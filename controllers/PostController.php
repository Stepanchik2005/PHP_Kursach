<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\Post;

class PostController extends Controller
{
    public function actionIndex()
    {
        // Формируем запрос к таблице posts
        $query = Post::find();

        // Настройка постраничной разбивки (по 5 записей на страницу)
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        // Получаем посты для текущей страницы, отсортированные по заголовку
        $posts = $query->orderBy('title')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'posts' => $posts,
            'pagination' => $pagination,
        ]);
    }
}