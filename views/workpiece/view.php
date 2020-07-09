<?php

use yii\grid\GridView;use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Workpiece */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Workpieces', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="workpiece-view">

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
        <?= Html::a('Deposit<span class="glyphicon glyphicon-arrow-up"></span>', ['deposit', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Withdraw<span class="glyphicon glyphicon-arrow-down"></span>', ['withdraw', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'category_id',
            [
                'label' => 'Category',
                'value' => $model->category->name,
            ],
            'name',
            'in_stock',
            'min_stock',
        ],
    ]) ?>
<hr>
    <!-- history -->
    <h2>Inventory History</h2>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Quantity</th>
            <th>Remark</th>
            <th>Created at</th>
        </tr>
        </thead>

        <?php foreach ($model->histories as $history): ?>
            <tr class="alert <?= ($history->quantity > 0) ? 'alert-success':'alert-danger' ?>">
                <td> <?= $history->id ?> </td>
                <td> <?= $history->quantity ?> </td>
                <td> <?= $history->remark ?> </td>
                <td> <?= $history->created_at ?> </td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>
