<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Products */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Products', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

            <!--dropdon menus-->
    <div class="row">
        <div class="col-md-6">
            <?=Yii::$app->controller->renderPartial('dropdown_values')?>
        </div>
        <div class="col-md-6" style="display: inline-block">
            <?=Html::beginForm(['product/bulk-delete'],'post');?>
            <?=Html::submitButton('Delete the selected elements', ['class' => 'btn btn-danger pull-right sb']);?>
        </div>
    </div>




    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            [
                'attribute' => 'image',
                'value' => function ($model) {
                    if (empty($model->image)) {
                        return null;
                    }
                    $photoPath = '/covers/' . $model->image;
                    return Html::img($photoPath, ['width' => '90px']);
                },
                'format' => 'html',
                'contentOptions' => [ 'style' => 'width:90px; white-space: normal;', 'class' => 'collapsable-image'],
                'headerOptions' => ['class' => 'collapsable-image' ]
            ],
            [
                'attribute' => 'title',
                'header' => 'Title and Sku',
                'value' => function ($model) {
                    return $model->title.'  (sku: '.$model->sku.' )';
                },
                'contentOptions' => [ 'class' => 'collapsable-title'],
                'headerOptions' => [ 'class' => 'collapsable-title']
            ],

            [
                'attribute' => 'Left in stock',
                'value' => function ($model) {
                    return $model->productWarehouses->quantity ?? 0;
                },
                'contentOptions' => ['class' => 'collapsable-stock' ],
                'headerOptions' => ['class' => 'collapsable-stock']
            ],

            [
                'attribute' => 'product_type',
                'value' => function ($model) {
                    return $model->productType->title ?? 'Data not found!';
                },
                'contentOptions' => ['class' => 'collapsable-type' ],
                'headerOptions' => ['class' => 'collapsable-type']
            ],

            ['class' => 'yii\grid\ActionColumn', 'headerOptions' => ['class' => 'collapsable-action']],
        ],
    ]); ?>
    <?= Html::endForm();?>
</div>





