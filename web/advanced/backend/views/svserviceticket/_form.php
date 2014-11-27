<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SVServiceTicket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="svservice-ticket-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Ticket_Status')->textInput() ?>

    <?= $form->field($model, 'Ticket_Number')->textInput() ?>

    <?= $form->field($model, 'Customer_Id')->textInput() ?>

    <?= $form->field($model, 'Customer_Site_Id')->textInput() ?>

    <?= $form->field($model, 'Customer_System_Id')->textInput() ?>

    <?= $form->field($model, 'Multiple_Systems')->textInput() ?>

    <?= $form->field($model, 'Creation_Date')->textInput() ?>

    <?= $form->field($model, 'Requested_By')->textInput() ?>

    <?= $form->field($model, 'Requested_By_Phone')->textInput() ?>

    <?= $form->field($model, 'Problem_Id')->textInput() ?>

    <?= $form->field($model, 'Scheduled_For')->textInput() ?>

    <?= $form->field($model, 'Last_Service_Tech_Id')->textInput() ?>

    <?= $form->field($model, 'Estimated_Length')->textInput() ?>

    <?= $form->field($model, 'Resolution_Id')->textInput() ?>

    <?= $form->field($model, 'Billable')->textInput() ?>

    <?= $form->field($model, 'Billed')->textInput() ?>

    <?= $form->field($model, 'Equipment_Charge')->textInput() ?>

    <?= $form->field($model, 'Labor_Charge')->textInput() ?>

    <?= $form->field($model, 'Other_Charge')->textInput() ?>

    <?= $form->field($model, 'TaxTotal')->textInput() ?>

    <?= $form->field($model, 'FieldComments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'Regular_Hours')->textInput() ?>

    <?= $form->field($model, 'Overtime_Hours')->textInput() ?>

    <?= $form->field($model, 'Holiday_Hours')->textInput() ?>

    <?= $form->field($model, 'Trip_Charge')->textInput() ?>

    <?= $form->field($model, 'Invoice_Id')->textInput() ?>

    <?= $form->field($model, 'Regular_Rate')->textInput() ?>

    <?= $form->field($model, 'Overtime_Rate')->textInput() ?>

    <?= $form->field($model, 'Holiday_Rate')->textInput() ?>

    <?= $form->field($model, 'Bypass_Warranty')->textInput() ?>

    <?= $form->field($model, 'Bypass_ServiceLevel')->textInput() ?>

    <?= $form->field($model, 'IsInspection')->textInput() ?>

    <?= $form->field($model, 'ClosedDate')->textInput() ?>

    <?= $form->field($model, 'Manual_Labor')->textInput() ?>

    <?= $form->field($model, 'Service_Company_Id')->textInput() ?>

    <?= $form->field($model, 'Priority_Id')->textInput() ?>

    <?= $form->field($model, 'Category_Id')->textInput() ?>

    <?= $form->field($model, 'Expertise_Level')->textInput() ?>

    <?= $form->field($model, 'Entered_By')->textInput() ?>

    <?= $form->field($model, 'Invoice_Contact')->textInput() ?>

    <?= $form->field($model, 'Signer')->textInput() ?>

    <?= $form->field($model, 'Remittance')->textInput() ?>

    <?= $form->field($model, 'Signature_Image')->textInput() ?>

    <?= $form->field($model, 'Payment_Received')->textInput() ?>

    <?= $form->field($model, 'Sub_Problem_Id')->textInput() ?>

    <?= $form->field($model, 'Service_Level_Id')->textInput() ?>

    <?= $form->field($model, 'UserCode')->textInput() ?>

    <?= $form->field($model, 'Edit_Timestamp')->textInput() ?>

    <?= $form->field($model, 'PO_Number')->textInput() ?>

    <?= $form->field($model, 'CustomerComments')->textInput() ?>

    <?= $form->field($model, 'Dispatch_Regular_Minutes')->textInput() ?>

    <?= $form->field($model, 'Dispatch_Overtime_Minutes')->textInput() ?>

    <?= $form->field($model, 'Dispatch_Holiday_Minutes')->textInput() ?>

    <?= $form->field($model, 'Number_Of_Dispatches')->textInput() ?>

    <?= $form->field($model, 'Route_Id')->textInput() ?>

    <?= $form->field($model, 'Sub_Customer_Site_ID')->textInput() ?>

    <?= $form->field($model, 'Customer_CC_Id')->textInput() ?>

    <?= $form->field($model, 'Customer_Bank_Id')->textInput() ?>

    <?= $form->field($model, 'Ticket_Status_Id')->textInput() ?>

    <?= $form->field($model, 'Customer_EFT_Id')->textInput() ?>

    <?= $form->field($model, 'Auto_Notify')->textInput() ?>

    <?= $form->field($model, 'Customer_Bill_Id')->textInput() ?>

    <?= $form->field($model, 'Customer_Contact_Id')->textInput() ?>

    <?= $form->field($model, 'Requested_By_Phone_Ext')->textInput() ?>

    <?= $form->field($model, 'Inspection_Id')->textInput() ?>

    <?= $form->field($model, 'Service_Ticket_Group_Id')->textInput() ?>

    <?= $form->field($model, 'Service_Coordinator_Employee_Id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
