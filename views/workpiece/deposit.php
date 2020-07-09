<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Workpiece */
/* @var $validator yii\base\DynamicModel */

$this->title = 'Deposit Workpiece: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Workpieces', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Deposit';
?>
<div class="workpiece-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_deposit', [
        'model' => $model,
        'validator' => $validator
    ]) ?>

</div>
