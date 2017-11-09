<?php

use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Posting */
/* @var $comments common\models\Comments */


//$this->title = $model->title;
//$this->params['breadcrumbs'][] = $this->title;
//?>
<!--<div class="posting-view">-->
<!--    <h1>--><?//= Html::encode($model->subtitle) ?><!--</h1>-->
<!--    <div class="content">-->
<!--        <p>Миниатюра</p>-->
<!--       <img src="--><?//= Html::encode($model->tmb) ?><!--"<br>-->
<!--        <p>Картинка</p>-->
<!--        <img src="--><?//= Html::encode($model->img) ?><!--" width="600" >-->
<!--        <hr>-->
<!--        <br>-->
<!--       <p> --><?php
//           $text = Html::encode($model->content);
//           ?><!--</p>-->
<!--    </div>-->
<!--    <hr>-->
<!--<hr>-->
<!--</div>-->
<!--<h2>Тэги:</h2>-->
<?php
//
//foreach($tags as $tag):?>
<!--    <p class="comment-date">-->
<!--        --><?//= $tag->title;?>
<!--    </p>-->
<?php //endforeach;?>



<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <header class="entry-header text-center text-uppercase">
                        <h1 class="entry-title">Заголовок:<a href="<?= Url::toRoute(['posting/view','id'=>$model->id])?>"><?= $model->title?></a></h1>
                        <h2>Категория:</h2><h6><a href="<?= Url::toRoute(['site/category','id'=>$model->category->id])?>"> <?= $model->categories->category_name?></a></h6>
                    </header>
                    <div class="post-thumb">
                        <a href="blog.html"><img src="<?= $model->getImage();?>" alt="" width="500px"></a>
                    </div>
                    <div class="post-content">

                        <div class="entry-content">
                            <h2>Содержание статьи</h2>
                            <?= $model->content?>
                        </div>
                        <div class="social-share">
							<span class="social-share-title pull-left text-capitalize">Author: <?= $model->author->username?></span>
                        </div>
                    </div>
                </article>



                <?= $this->render('/posting/_form_to_posting', [
                    'commentsForm'=>$commentsForm,
                    'model'=>$model,
                    'dataProvider'=>$dataProvider
                ])?>
                <?php
                $this->registerJs(
                    '$("document").ready(function(){
            $("#new_note").on("pjax:end", function() {
            $.pjax.reload({container:"#notes"});  //Reload GridView
        });
    });'
                );
                ?>
        </div>
    </div>
</div>
<!-- end main content-->
