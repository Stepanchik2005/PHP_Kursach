<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Article;
use app\models\Category;
use app\models\Tag;
use app\models\CommentForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'comment'],
                'rules' => [
                    [
                        'actions' => ['logout', 'comment'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'comment' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Главная страница блога (лента всех статей с пагинацией)
     */
    public function actionIndex()
    {
        $query = Article::find()->orderBy(['date' => SORT_DESC, 'id' => SORT_DESC]);
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', array_merge([
            'articles' => $articles,
            'pagination' => $pagination,
            'pageTitle' => 'Усі подорожі та маршрути',
            'pageSubtitle' => 'Авторські нотатки, лайфхаки та гіди для самостійних мандрівників',
        ], $this->getSidebarData()));
    }

    /**
     * Просмотр статей конкретной категории
     */
    public function actionCategory($id)
    {
        $category = Category::findOne($id);
        if (!$category) {
            throw new NotFoundHttpException('Категорію не знайдено.');
        }

        $query = Article::find()->where(['category_id' => $id])->orderBy(['date' => SORT_DESC, 'id' => SORT_DESC]);
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', array_merge([
            'articles' => $articles,
            'pagination' => $pagination,
            'pageTitle' => 'Категорія: ' . $category->title,
            'pageSubtitle' => $category->description ?: 'Статті за обраною категорією подорожей',
        ], $this->getSidebarData()));
    }

    /**
     * Поиск статей по метке (тегу)
     */
    public function actionTag($id)
    {
        $tag = Tag::findOne($id);
        if (!$tag) {
            throw new NotFoundHttpException('Мітку не знайдено.');
        }

        $query = $tag->getArticles()->orderBy(['date' => SORT_DESC, 'id' => SORT_DESC]);
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', array_merge([
            'articles' => $articles,
            'pagination' => $pagination,
            'pageTitle' => 'Пошук за міткою: #' . $tag->title,
            'pageSubtitle' => 'Усі публікації з тегом #' . $tag->title,
        ], $this->getSidebarData()));
    }

    /**
     * Детальная страница одной статьи + комментарии
     */
    public function actionView($id)
    {
        $article = Article::findOne($id);
        if (!$article) {
            throw new NotFoundHttpException('Статтю не знайдено.');
        }

        $article->viewedCounter();
        $commentForm = new CommentForm();

        return $this->render('single', array_merge([
            'article' => $article,
            'comments' => $article->comments,
            'commentForm' => $commentForm,
        ], $this->getSidebarData()));
    }

    /**
     * Добавление комментария или ответа на комментарий
     */
    public function actionComment($id)
    {
        $model = new CommentForm();

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->saveComment($id)) {
                Yii::$app->session->setFlash('success', 'Ваш коментар успішно додано!');
            } else {
                Yii::$app->session->setFlash('error', 'Не вдалося зберегти коментар. Перевірте текст.');
            }
        }

        return $this->redirect(['site/view', 'id' => $id, '#' => 'comments-section']);
    }

    /**
     * Общие данные для боковой панели (категории, теги, популярные статьи)
     */
    private function getSidebarData()
    {
        return [
            'categories' => Category::find()->all(),
            'tags' => Tag::find()->all(),
            'popularArticles' => Article::find()->orderBy(['viewed' => SORT_DESC])->limit(3)->all(),
        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        $adminEmail = Yii::$app->params['adminEmail'] ?? 'admin@example.com';

        if ($model->load(Yii::$app->request->post()) && $model->contact($adminEmail)) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
