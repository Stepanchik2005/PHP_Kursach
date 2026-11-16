<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Category;
use app\models\Tag;

/** @var yii\web\View $this */
/** @var app\models\Article $model */
/** @var yii\widgets\ActiveForm $form */

$categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');
$tags = ArrayHelper::map(Tag::find()->all(), 'id', 'title');
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList($categories, [
        'prompt' => '-- Оберіть категорію подорожі --',
    ]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 7]) ?>

    <?= $form->field($model, 'date')->textInput(['type' => 'date']) ?>

    <div class="mb-3">
        <?= $form->field($model, 'selectedTags')->checkboxList($tags, [
            'itemOptions' => ['class' => 'form-check-input me-1'],
            'item' => function ($index, $label, $name, $checked, $value) {
                $checkbox = Html::checkbox($name, $checked, [
                    'value' => $value,
                    'class' => 'form-check-input',
                    'id' => 'tag-' . $value,
                ]);
                return "<div class='form-check form-check-inline'>{$checkbox}<label class='form-check-label' for='tag-{$value}'>{$label}</label></div>";
            }
        ]) ?>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Зберегти статтю', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>