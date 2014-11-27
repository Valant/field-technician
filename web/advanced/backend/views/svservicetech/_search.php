<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SVServiceTechSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="svservice-tech-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Service_Tech_Id') ?>

    <?= $form->field($model, 'Emp_or_Vendor') ?>

    <?= $form->field($model, 'Employee_Id') ?>

    <?= $form->field($model, 'Vendor_Id') ?>

    <?= $form->field($model, 'Service_Company_Id') ?>

    <?php // echo $form->field($model, 'Inactive') ?>

    <?php // echo $form->field($model, 'Warehouse_Id') ?>

    <?php // echo $form->field($model, 'Address_1') ?>

    <?php // echo $form->field($model, 'GE_Table1_Id') ?>

    <?php // echo $form->field($model, 'GE_Table2_Id') ?>

    <?php // echo $form->field($model, 'GE_Table3_Id') ?>

    <?php // echo $form->field($model, 'Country_Id') ?>

    <?php // echo $form->field($model, 'Address_2') ?>

    <?php // echo $form->field($model, 'Address_3') ?>

    <?php // echo $form->field($model, 'GE_Table4_Id') ?>

    <?php // echo $form->field($model, 'GE_Table5_Id') ?>

    <?php // echo $form->field($model, 'Zip_Code_Plus4') ?>

    <?php // echo $form->field($model, 'Service') ?>

    <?php // echo $form->field($model, 'Installer') ?>

    <?php // echo $form->field($model, 'RegularPayRate') ?>

    <?php // echo $form->field($model, 'OvertimePayRate') ?>

    <?php // echo $form->field($model, 'HolidayPayRate') ?>

    <?php // echo $form->field($model, 'Expertise_Level') ?>

    <?php // echo $form->field($model, 'Install_Company_id') ?>

    <?php // echo $form->field($model, 'Text_Message_Address') ?>

    <?php // echo $form->field($model, 'SageQuest_Driver') ?>

    <?php // echo $form->field($model, 'rowguid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
