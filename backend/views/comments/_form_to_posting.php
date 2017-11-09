<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model app\models\Comments */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
//$this->registerJs(
//    '$("document").ready(function(){
//            $("#new_note").on("pjax:end", function() {
//            $.pjax.reload({container:"#notes"});  //Reload GridView
//        });
//    });'
//);
//?>

<div class="comments-form">
    <?php yii\widgets\Pjax::begin(['id' => 'new_note']) ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true], 'action' => ['posting/comcreate','id'=>$model->id]]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_post')->textInput() ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
