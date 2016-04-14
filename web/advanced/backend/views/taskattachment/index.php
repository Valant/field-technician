<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TaskAttachmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Task Attachments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-attachment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Task Attachment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'task_id',
//            'path',
            [
                'label'=>'Image',
                'format' => 'raw',
                'value'=>function ($data) {

                    return Html::img( Yii::$app->urlManagerFrontend->createUrl("/uploads/".$data['task_id']."/".$data['path']),["width"=>"100px"]);
                },
            ],
            'name',
            'sign_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
