<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserModel */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Yangi foydalanuvchi kiritish', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Taxrirlash', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('O\'chirish', ['delete', 'id' => $model->id], [
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
            'username',
            'password',
            'fullname',
            'status',
        ],
    ]) ?>

</div>
