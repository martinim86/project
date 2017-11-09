<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="news-item">
    <p>Содержание:<?= HtmlPurifier::process($model->content) ?></p>
    <p>Создатель:<?= Html::encode($model->user->username) ?></p>
    <p>Email:<?= Html::encode($model->user->email) ?></p>
    <p>Date:<?= Html::encode($model->date) ?></p>
    <hr>

</div>
