<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Comment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class CommentController extends Controller
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
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()->orderBy(['id' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAllow($id)
    {
        $comment = $this->findModel($id);
        if ($comment->allow()) {
            Yii::$app->session->setFlash('success', 'Коментар опубліковано.');
        }
        return $this->redirect(['index']);
    }

    public function actionDisallow($id)
    {
        $comment = $this->findModel($id);
        if ($comment->disallow()) {
            Yii::$app->session->setFlash('warning', 'Коментар приховано.');
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('danger', 'Коментар видалено.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Коментар не знайдено.');
    }
}
