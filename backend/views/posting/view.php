<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;



/* @var $this yii\web\View */
/* @var $model common\models\Posting */
/* @var $comments common\models\Comments */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posting', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Set Image', ['set-image', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Set Category', ['set-category', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Set Tags', ['set-tags', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'subtitle',
            'content:ntext',
            'category',
            'tag',
            [
                'format' => 'html',
                'label' => 'Мминиатюра',
                'value' => function($data){
                    return Html::img($data->getImage(), ['width'=>200]);
                }
            ],

        ],
    ]) ?>
<?php if($model->isAllowed()):?>
    <a class="btn btn-warning" href="<?= Url::toRoute(['posting/disallow', 'id'=>$model->id]);?>">Disallow</a>
<?php else:?>
    <a class="btn btn-success" href="<?= Url::toRoute(['posting/allow', 'id'=>$model->id]);?>">Allow</a>
<?php endif?>

