<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LoginStats */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="login-stats-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'login_time')->textInput() ?>

    <?= $form->field($model, 'logout_time')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
