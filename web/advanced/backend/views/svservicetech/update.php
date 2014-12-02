<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SVServiceTech */

$this->title = 'Update Service Tech: ' . ' ' . $model->Service_Tech_Id;
$this->params['breadcrumbs'][] = ['label' => 'Svservice Teches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Service_Tech_Id, 'url' => ['view', 'id' => $model->Service_Tech_Id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="svservice-tech-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
