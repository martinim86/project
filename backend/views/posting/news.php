<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use app\models\Posting;

$this->title = 'Новости сайта';
?>
    <h1><?= Html::encode($this->title) ?></h1>
<div class="news">
    <?php foreach ($posts as $post): ?>

        <?= Html::a($post->title, ['view', 'id' => $post->id]) ?><br>

    <?php endforeach; ?>
    <?php if(\Yii::$app->user->can('admin')){?>

        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>

    <?php } ?>
</div>
<br><hr>
<div class="category">
<?php
// выполняем запрос, за место функции joinWith можно использовать функцию With
$model1 = (new \yii\db\Query())
    ->select(['u.category_name','u.category_id'])
    ->from('category u')
    ->innerJoin('posting d', 'u.category_id = d.category')
    ->groupBy('u.category_name')
    ->orderBy('u.id ASC')
    ->all();
?>
    <h2>Категории: </h2>
    <?php foreach ($model1 as $m): ?>
<!--        --><?//= $m[category_name]?><!--<br>-->
        <?= Html::a($m[category_name], ['category', 'category' => $m[category_id]]) ?><br>
    <?php endforeach; ?>
</div>

