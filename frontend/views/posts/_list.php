<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="news-item">
    <h2><?= Html::encode($model->name) ?></h2>
    <p><?= Html::encode($model->email) ?></p>
    <?= HtmlPurifier::process($model->content) ?>
</div>