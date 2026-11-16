<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use app\models\ImageUpload;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class ArticleController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Article();
        $model->user_id = Yii::$app->user->id;
        $model->date = date('Y-m-d');

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $model->saveTags();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->loadSelectedTags();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $model->saveTags();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionSetImage($id)
    {
        $model = new ImageUpload();

        if ($this->request->isPost) {
            $article = $this->findModel($id);
            $file = UploadedFile::getInstance($model, 'image');

            if ($article->saveImage($model->uploadFile($file, $article->image))) {
                return $this->redirect(['view', 'id' => $article->id]);
            }
        }

        return $this->render('image', ['model' => $model]);
    }

    protected function findModel($id)
    {
        if (($model = Article::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувану статтю не знайдено.');
    }
}
