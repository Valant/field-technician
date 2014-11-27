<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SVServiceTicket */

$this->title = 'Create Svservice Ticket';
$this->params['breadcrumbs'][] = ['label' => 'Svservice Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="svservice-ticket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
