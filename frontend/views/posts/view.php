<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Posts */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="posting-view">
        <h1><?= Html::encode($model->subtitle) ?></h1>
        <div class="content">
            <p>Миниатюра</p>
            <img src="<?= Html::encode($model->tmb) ?>"<br>
            <p>Картинка</p>
            <img src="<?= Html::encode($model->img) ?>" width="600" >
            <hr>
            <br>
            <p> <?php
                $text = Html::encode($model->content);
                $newtext = wordwrap($text, 70, "<br />\n");
                echo $newtext;
                ?></p>
        </div>
        <hr>
        <hr>
        <div class="tag">
            <b>Теги: <?= Html::encode($model->tag) ?></b>
        </div>
    </div>
    <h1>Комментарии</h1>
    <?php Pjax::begin(['id' => 'notes']) ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
    ]);
    ?>
    <?php Pjax::end() ?>
    <?php
    $this->registerJs(
        '$("document").ready(function(){
            $("#new_note").on("pjax:end", function() {
            $.pjax.reload({container:"#notes"});  //Reload GridView
        });
    });'
    );
    ?>
    <div class="comments-form">
        <?php yii\widgets\Pjax::begin(['id' => 'new_note']) ?>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true], 'action' => ['comments/create'], 'id'=>$id]); ?>

        <?= $form->field($comments, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($comments, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($comments, 'id_post')->hiddenInput(['value' => Html::encode($model->id)])->label(false) ?>

        <?= $form->field($comments, 'content')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton('Add comment', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
    </div>

