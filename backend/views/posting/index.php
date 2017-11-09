<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Postings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posting-index">
    <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('CreatePost', ['create'], ['class' => 'btn btn-success']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'title',
            'subtitle',
            'content:ntext',
            [
                'format' => 'html',
                'label' => 'img',
                'value' => function($data){
                    return Html::img($data->getImage(), ['width'=>200]);
                }
            ],
            ['class' => 'yii\grid\ActionColumn',

            ],
        ],
    ]); ?>
</div>

