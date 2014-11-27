<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SVServiceTech */

$this->title = 'Create Svservice Tech';
$this->params['breadcrumbs'][] = ['label' => 'Svservice Teches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="svservice-tech-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
