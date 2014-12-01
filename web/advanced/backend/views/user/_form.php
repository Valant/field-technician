<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;

    /* @var $this yii\web\View */
    /* @var $model common\models\User */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'auth_key')->hiddenInput(['value'=>1, 'enableLabel'=>false])->label("") ?>
    <?= $form->field($model, 'created_at')->hiddenInput(['value'=>time(), 'enableLabel'=>false])->label(""); ?>
    <?= $form->field($model, 'updated_at')->hiddenInput(['value'=>time(), 'enableLabel'=>false])->label(""); ?>


    <?= $form->field( $model, 'username' )->textInput( [ 'maxlength' => 255 ] ) ?>

    <?= $form->field( $model, 'email' )->textInput( [ 'maxlength' => 255 ] ) ?>

    <?= $form->field( $model, 'technition_id' )->dropDownList(
        ArrayHelper::map( \common\models\SVServiceTech::find()->with('employee')->asArray()->all(), 'Service_Tech_Id', function($element){
;
            return $element['Service_Tech_Id']." - ".$element['employee']['First_Name'].' '.$element['employee']['Last_Name'];
        } ),['value'=>$model->technition_id]
    )->label( "Technition" ) ?>

    <?= $form->field( $model, 'password_hash' )->textInput( [ 'maxlength' => 255] )->label( "Password" ) ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update',
            [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
