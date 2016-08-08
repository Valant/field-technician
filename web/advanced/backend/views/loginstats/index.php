<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Login Stats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-stats-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Login Stats', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user',
                [
                        'label'=>'Type',
                        'format' => 'raw',
                        'value'=>function ($data) {
                            $result = "";

                            switch ($data['type']){
                                case 1:
                                    $result = 'Login';
                                    break;
                                default:
                                    $result = 'Logout';
                                    break;

                            }
                            return $result;
                        },
                ],
            'time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
