<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SVServiceTech */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="svservice-tech-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Emp_or_Vendor')->textInput() ?>

    <?= $form->field($model, 'Employee_Id')->textInput() ?>

    <?= $form->field($model, 'Vendor_Id')->textInput() ?>

    <?= $form->field($model, 'Service_Company_Id')->textInput() ?>

    <?= $form->field($model, 'Inactive')->textInput() ?>

    <?= $form->field($model, 'Warehouse_Id')->textInput() ?>

    <?= $form->field($model, 'Address_1')->textInput() ?>

    <?= $form->field($model, 'GE_Table1_Id')->textInput() ?>

    <?= $form->field($model, 'GE_Table2_Id')->textInput() ?>

    <?= $form->field($model, 'GE_Table3_Id')->textInput() ?>

    <?= $form->field($model, 'Country_Id')->textInput() ?>

    <?= $form->field($model, 'Address_2')->textInput() ?>

    <?= $form->field($model, 'Address_3')->textInput() ?>

    <?= $form->field($model, 'GE_Table4_Id')->textInput() ?>

    <?= $form->field($model, 'GE_Table5_Id')->textInput() ?>

    <?= $form->field($model, 'Zip_Code_Plus4')->textInput() ?>

    <?= $form->field($model, 'Service')->textInput() ?>

    <?= $form->field($model, 'Installer')->textInput() ?>

    <?= $form->field($model, 'RegularPayRate')->textInput() ?>

    <?= $form->field($model, 'OvertimePayRate')->textInput() ?>

    <?= $form->field($model, 'HolidayPayRate')->textInput() ?>

    <?= $form->field($model, 'Expertise_Level')->textInput() ?>

    <?= $form->field($model, 'Install_Company_id')->textInput() ?>

    <?= $form->field($model, 'Text_Message_Address')->textInput() ?>

    <?= $form->field($model, 'SageQuest_Driver')->textInput() ?>

    <?= $form->field($model, 'rowguid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
