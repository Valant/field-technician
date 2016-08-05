<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LoginStats */

$this->title = 'Create Login Stats';
$this->params['breadcrumbs'][] = ['label' => 'Login Stats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-stats-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
