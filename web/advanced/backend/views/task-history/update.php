<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TaskHistory */

$this->title = 'Update Task History: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Task Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
