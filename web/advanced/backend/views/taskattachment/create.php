<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TaskAttachment */

$this->title = 'Create Task Attachment';
$this->params['breadcrumbs'][] = ['label' => 'Task Attachments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-attachment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
