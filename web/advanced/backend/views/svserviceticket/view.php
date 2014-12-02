<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SVServiceTicket */

$this->title = $model->Service_Ticket_Id;
$this->params['breadcrumbs'][] = ['label' => 'Service Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="svservice-ticket-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->Service_Ticket_Id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->Service_Ticket_Id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Service_Ticket_Id',
            'Ticket_Status',
            'Ticket_Number',
            'Customer_Id',
            'Customer_Site_Id',
            'Customer_System_Id',
            'Multiple_Systems',
            'Creation_Date',
            'Requested_By',
            'Requested_By_Phone',
            'Problem_Id',
            'Scheduled_For',
            'Last_Service_Tech_Id',
            'Estimated_Length',
            'Resolution_Id',
            'Billable',
            'Billed',
            'Equipment_Charge',
            'Labor_Charge',
            'Other_Charge',
            'TaxTotal',
            'FieldComments:ntext',
            'Regular_Hours',
            'Overtime_Hours',
            'Holiday_Hours',
            'Trip_Charge',
            'Invoice_Id',
            'Regular_Rate',
            'Overtime_Rate',
            'Holiday_Rate',
            'Bypass_Warranty',
            'Bypass_ServiceLevel',
            'IsInspection',
            'ClosedDate',
            'Manual_Labor',
            'Service_Company_Id',
            'Priority_Id',
            'Category_Id',
            'Expertise_Level',
            'Entered_By',
            'Invoice_Contact',
            'Signer',
            'Remittance',
            'Signature_Image',
            'Payment_Received',
            'Sub_Problem_Id',
            'Service_Level_Id',
            'UserCode',
            'Edit_Timestamp',
            'PO_Number',
            'CustomerComments',
            'Dispatch_Regular_Minutes',
            'Dispatch_Overtime_Minutes:datetime',
            'Dispatch_Holiday_Minutes',
            'Number_Of_Dispatches',
            'Route_Id',
            'Sub_Customer_Site_ID',
            'Customer_CC_Id',
            'Customer_Bank_Id',
            'Ticket_Status_Id',
            'Customer_EFT_Id',
            'Auto_Notify',
            'Customer_Bill_Id',
            'Customer_Contact_Id',
            'Requested_By_Phone_Ext',
            'Inspection_Id',
            'Service_Ticket_Group_Id',
            'Service_Coordinator_Employee_Id',
        ],
    ]) ?>

</div>
