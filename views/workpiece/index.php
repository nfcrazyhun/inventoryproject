<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\WorkpieceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \app\models\Workpiece */

$this->title = 'Workpieces';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workpiece-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Workpiece', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'rowOptions' => function ($model) { //coloring the rows
            if (!empty($model->histories)) {
                // if stock > min >> green
                if ($model->in_stock > $model->min_stock) { return ['class' => 'alert alert-success']; }

                //otherwise >> red
                return ['class' => 'alert alert-danger'];
            }

            return ['class' => 'alert alert-warning']; //default >> orange
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'category_id',
                'label' => 'Category',
                'value' => 'category.name'
            ],
            'name',
            'in_stock',
            'min_stock',

            //['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} <br> {deposit} {withdraw}',
                'buttons' => [
                    'deposit' => function ($url, $model) {
                        return  Html::a('<span class="glyphicon glyphicon-arrow-up"></span>',
                            Url::to(['workpiece/deposit', 'id' => $model->id]),
                            ['title' => 'Deposit']
                        );
                    },
                    'withdraw' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>',
                            Url::to(['workpiece/withdraw', 'id' => $model->id]),
                            ['title' => 'Withdraw']
                        );
                    }
                ],
            ]

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
