<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
<?php if ($model->isNewRecord) : ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
<?php else : ?>
    <?= $form->field($model, 'tempPassword')->passwordInput(['placeholder' => 'Yangi parol']) ?>
<?php endif;?>
    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
