<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SVServiceTicketSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="svservice-ticket-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Service_Ticket_Id') ?>

    <?= $form->field($model, 'Ticket_Status') ?>

    <?= $form->field($model, 'Ticket_Number') ?>

    <?= $form->field($model, 'Customer_Id') ?>

    <?= $form->field($model, 'Customer_Site_Id') ?>

    <?php // echo $form->field($model, 'Customer_System_Id') ?>

    <?php // echo $form->field($model, 'Multiple_Systems') ?>

    <?php // echo $form->field($model, 'Creation_Date') ?>

    <?php // echo $form->field($model, 'Requested_By') ?>

    <?php // echo $form->field($model, 'Requested_By_Phone') ?>

    <?php // echo $form->field($model, 'Problem_Id') ?>

    <?php // echo $form->field($model, 'Scheduled_For') ?>

    <?php // echo $form->field($model, 'Last_Service_Tech_Id') ?>

    <?php // echo $form->field($model, 'Estimated_Length') ?>

    <?php // echo $form->field($model, 'Resolution_Id') ?>

    <?php // echo $form->field($model, 'Billable') ?>

    <?php // echo $form->field($model, 'Billed') ?>

    <?php // echo $form->field($model, 'Equipment_Charge') ?>

    <?php // echo $form->field($model, 'Labor_Charge') ?>

    <?php // echo $form->field($model, 'Other_Charge') ?>

    <?php // echo $form->field($model, 'TaxTotal') ?>

    <?php // echo $form->field($model, 'FieldComments') ?>

    <?php // echo $form->field($model, 'Regular_Hours') ?>

    <?php // echo $form->field($model, 'Overtime_Hours') ?>

    <?php // echo $form->field($model, 'Holiday_Hours') ?>

    <?php // echo $form->field($model, 'Trip_Charge') ?>

    <?php // echo $form->field($model, 'Invoice_Id') ?>

    <?php // echo $form->field($model, 'Regular_Rate') ?>

    <?php // echo $form->field($model, 'Overtime_Rate') ?>

    <?php // echo $form->field($model, 'Holiday_Rate') ?>

    <?php // echo $form->field($model, 'Bypass_Warranty') ?>

    <?php // echo $form->field($model, 'Bypass_ServiceLevel') ?>

    <?php // echo $form->field($model, 'IsInspection') ?>

    <?php // echo $form->field($model, 'ClosedDate') ?>

    <?php // echo $form->field($model, 'Manual_Labor') ?>

    <?php // echo $form->field($model, 'Service_Company_Id') ?>

    <?php // echo $form->field($model, 'Priority_Id') ?>

    <?php // echo $form->field($model, 'Category_Id') ?>

    <?php // echo $form->field($model, 'Expertise_Level') ?>

    <?php // echo $form->field($model, 'Entered_By') ?>

    <?php // echo $form->field($model, 'Invoice_Contact') ?>

    <?php // echo $form->field($model, 'Signer') ?>

    <?php // echo $form->field($model, 'Remittance') ?>

    <?php // echo $form->field($model, 'Signature_Image') ?>

    <?php // echo $form->field($model, 'Payment_Received') ?>

    <?php // echo $form->field($model, 'Sub_Problem_Id') ?>

    <?php // echo $form->field($model, 'Service_Level_Id') ?>

    <?php // echo $form->field($model, 'UserCode') ?>

    <?php // echo $form->field($model, 'Edit_Timestamp') ?>

    <?php // echo $form->field($model, 'PO_Number') ?>

    <?php // echo $form->field($model, 'CustomerComments') ?>

    <?php // echo $form->field($model, 'Dispatch_Regular_Minutes') ?>

    <?php // echo $form->field($model, 'Dispatch_Overtime_Minutes') ?>

    <?php // echo $form->field($model, 'Dispatch_Holiday_Minutes') ?>

    <?php // echo $form->field($model, 'Number_Of_Dispatches') ?>

    <?php // echo $form->field($model, 'Route_Id') ?>

    <?php // echo $form->field($model, 'Sub_Customer_Site_ID') ?>

    <?php // echo $form->field($model, 'Customer_CC_Id') ?>

    <?php // echo $form->field($model, 'Customer_Bank_Id') ?>

    <?php // echo $form->field($model, 'Ticket_Status_Id') ?>

    <?php // echo $form->field($model, 'Customer_EFT_Id') ?>

    <?php // echo $form->field($model, 'Auto_Notify') ?>

    <?php // echo $form->field($model, 'Customer_Bill_Id') ?>

    <?php // echo $form->field($model, 'Customer_Contact_Id') ?>

    <?php // echo $form->field($model, 'Requested_By_Phone_Ext') ?>

    <?php // echo $form->field($model, 'Inspection_Id') ?>

    <?php // echo $form->field($model, 'Service_Ticket_Group_Id') ?>

    <?php // echo $form->field($model, 'Service_Coordinator_Employee_Id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
