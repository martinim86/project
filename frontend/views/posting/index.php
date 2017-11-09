<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Postings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posting-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php if(\Yii::$app->user->can('admin') || \Yii::$app->user->can('redactor')){?>
        <?= Html::a('CreatePost', ['create'], ['class' => 'btn btn-success']) ?>
<?php } ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'title',
            'subtitle',
            'content:ntext',
            //'category',
            // 'status',
            // 'important',
            // 'tag',
            [
                'format' => 'html',
                'label' => 'Миниатюра',
                'value' => function($data){
                    return Html::img($data->getImage(), ['width'=>200]);
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
                'buttons'=>[
                    'view' => function ($url, $model, $key) {
                        if($model->status){
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',$url);
                        }
                    },
                    'update' => function ($url, $model, $key) {
                            if(\Yii::$app->user->can('admin') || \Yii::$app->user->can('redactor')){
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>',$url);
                            }
                        },
                    'delete'=> function ($url, $model, $key) {
                        if(\Yii::$app->user->can('admin') || \Yii::$app->user->can('redactor')){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',$url);
                        }
                    },
                ],
            ],
        ],
    ]); ?>
</div>
<!--<div class="category">-->
<!--    <h2>Категории: </h2>-->
<!--    --><?php //foreach ($getcategory as $m): ?>
<!--        --><?//= Html::a($m[category_name], ['category', 'category' => $m[category_id]]) ?><!--<br>-->
<!--    --><?php //endforeach; ?>
<!--</div>-->
