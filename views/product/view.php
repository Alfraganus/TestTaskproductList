<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$image ='/covers/'.$model->image;
if(empty($model->image)) {
    $image ='/covers/noimage.png';
}

?>
<div class="products-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            [
                'attribute' => 'image',
                'value' => Html::img($image, ['width' => '100px']),
                'format' => 'html',
            ],
            'sku',
            [
                'attribute' => 'Left in stock',
                'value' =>$model->productWarehouses->quantity,
            ],

            [
                'attribute' => 'product_type',
                'value' => $model->productType->title ?? 'Data not found!',
            ],
        ],
    ]) ?>

</div>
