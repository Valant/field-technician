<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SVServiceTicket */

$this->title = 'Update Service Ticket: ' . ' ' . $model->Service_Ticket_Id;
$this->params['breadcrumbs'][] = ['label' => 'Service Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Service_Ticket_Id, 'url' => ['view', 'id' => $model->Service_Ticket_Id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="svservice-ticket-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
