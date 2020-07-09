<?php

use app\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Workpiece */
/* @var $form yii\widgets\ActiveForm */
/* @var $validator yii\base\DynamicModel */
?>

<div class="workpiece-form-deposit">

    <?php if (!empty($validator)): ?>
        <div class="error-summary">
            <p> Please fix the following errors: </p>
            <ul>
                <?php foreach ($validator->getErrors() as $key): ?>
                    <?php foreach ($key as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?= Html::beginForm(['workpiece/deposit', 'id' => $model->id], 'POST') ?>

    <!-- quantity -->
    <div class="form-group">
        <?= HTML::label('Quantity:', 'quantity') ?>
        <?= HTML::input('text', 'quantity', (isset($validator)) ? $validator->attributes['quantity']:null, ['id' => 'quantity', 'class' => 'form-control']) ?>
    </div>

    <!-- remark -->
    <div class="form-group">
        <?= HTML::label('Remark:', 'remark') ?>
        <?= HTML::input('text', 'remark', (isset($validator)) ? $validator->attributes['remark']:null, ['id' => 'remark', 'class' => 'form-control']) ?>
    </div>

    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>

    <?= Html::endForm() ?>

    <hr>

    <!-- in_stock -->
    <span>
        <h3>Current stock: <?= $model->in_stock ?>  </h3>
    </span>

    <hr>

    <!-- history -->
    <h2>Deposit History</h2>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Quantity</th>
            <th>Remark</th>
            <th>Created at</th>
        </tr>
        </thead>

        <?php foreach ($model->deposits as $history): ?>
            <tr>
                <td> <?= $history->id ?> </td>
                <td> <?= $history->quantity ?> </td>
                <td> <?= $history->remark ?> </td>
                <td> <?= $history->created_at ?> </td>
            </tr>
        <?php endforeach; ?>
    </table>


</div>
