<?php

use app\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Workpiece */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="workpiece-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- name -->
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <!-- category_id -->
    <?= $form->field($model, 'category_id')->label('Category')->dropDownList(Category::getCategories(), [
        'prompt' => [
            'text' => 'Select a category...',
            'options' => ['disabled' => true, 'selected' => true]
        ]]
    ) ?>

    <!-- in_stock (unused) -->
    <?php //echo $form->field($model, 'in_stock')->textInput() ?>

    <!-- min_stock -->
    <?= $form->field($model, 'min_stock')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
