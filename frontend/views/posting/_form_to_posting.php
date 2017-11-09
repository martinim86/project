<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\widgets\ListView;


/* @var $this yii\web\View */
/* @var $model app\models\Comments */
/* @var $form yii\widgets\ActiveForm */
?>


    <h1>Комментарии</h1>
<?php Pjax::begin(['id' => 'notes']) ?>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_list',
]);
?>
<?php Pjax::end() ?>
<?php if(!Yii::$app->user->isGuest):?>
    <div class="leave-comment"><!--leave comment-->
        <h4>Leave a reply</h4>
        <?php if(Yii::$app->session->getFlash('comment')):?>
            <div class="alert alert-success" role="alert">
                <?= Yii::$app->session->getFlash('comment'); ?>
            </div>
        <?php endif;?>
        <div class="comments-form">
            <?php yii\widgets\Pjax::begin(['id' => 'new_note']) ?>
            <?php $form = \yii\widgets\ActiveForm::begin([
                'action'=>["posting/in?id=$model->id"],
                'options'=>['class'=>'form-horizontal contact-form', 'role'=>'form','data-pjax' => true]])?>
            <div class="form-group">
                <div class="col-md-12">
                    <?= $form->field($commentsForm, 'comment')->textarea(['class'=>'form-control','placeholder'=>'Write Message'])->label(false)?>
                </div>
            </div>
            <button type="submit" class="btn btn-success send-btn">Post Comment</button>
            <?php \yii\widgets\ActiveForm::end();?>
            <?php Pjax::end(); ?>
        </div>
    </div><!--end leave comment-->
<?php endif;?>
</div>
<?php
//$this->registerJs(
//    '$("document").ready(function(){
//            $("#new_note").on("pjax:end", function() {
//            $.pjax.reload({container:"#notes"});  //Reload GridView
//        });
//    });'
//);
//?>