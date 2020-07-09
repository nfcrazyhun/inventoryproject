<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Workpiece */

$this->title = 'Create Workpiece';
$this->params['breadcrumbs'][] = ['label' => 'Workpieces', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workpiece-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
