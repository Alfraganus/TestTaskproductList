<?php

use app\models\Sales;
use app\models\SalesOverallPayment;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Foydalanuvchilar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Yangi foydalanuvchi yaratish', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fullname',
            'username',
            [
                'attribute' => 'Xuquqi',
                'value' => 'roleName.name',
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->status == '10' ? '<span style="color:green;">Active</span>' : '<span style="color:red;">Inactive</span>';
                },
                'filter' => array(10 => "Aktiv", 5 => "Bloklangan", 0 => 'NoAktiv'),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
