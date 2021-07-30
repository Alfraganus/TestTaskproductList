<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
if($model->isNewRecord) {
    $valueSku = $sku;
} else {
    $valueSku = $model->sku;
}
$productTypes = \yii\helpers\ArrayHelper::map(\app\models\ProductTypes::find()->all(),'id','title');
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true,'placeholder'=>'Title of product']) ?>

    <?= $form->field($model, 'image')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions'=>[
            'allowedFileExtensions'=>['jpg', 'gif', 'png', 'bmp'],
            'showUpload' => true,
           'initialPreview' => [
                $model->image ? Html::img($model->image,['width'=>200,'height'=>220]) : null, // checks the models to display the preview
            ],
            'overwriteInitial' => false,
        ],
    ]); ?>

    <?= $form->field($model, 'inStock')->textInput(['placeholder'=>'quantity in stock']) ?>
    <?= $form->field($model, 'sku')->textInput(['value'=>$valueSku,'readonly'=>true]) ?>


    <?= $form->field($model, 'product_type')->dropDownList($productTypes) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
