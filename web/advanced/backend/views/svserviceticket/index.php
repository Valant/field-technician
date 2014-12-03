<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SVServiceTicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Service Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="svservice-ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Service_Ticket_Id',
            'Ticket_Status',
            'Ticket_Number',
            'Customer_Id',
            'Customer_Site_Id',
            // 'Customer_System_Id',
            // 'Multiple_Systems',
            // 'Creation_Date',
            // 'Requested_By',
            // 'Requested_By_Phone',
            // 'Problem_Id',
//             'Scheduled_For',
            // 'Last_Service_Tech_Id',
            // 'Estimated_Length',
            // 'Resolution_Id',
            // 'Billable',
            // 'Billed',
            // 'Equipment_Charge',
            // 'Labor_Charge',
            // 'Other_Charge',
            // 'TaxTotal',
            // 'FieldComments:ntext',
            // 'Regular_Hours',
            // 'Overtime_Hours',
            // 'Holiday_Hours',
            // 'Trip_Charge',
            // 'Invoice_Id',
            // 'Regular_Rate',
            // 'Overtime_Rate',
            // 'Holiday_Rate',
            // 'Bypass_Warranty',
            // 'Bypass_ServiceLevel',
            // 'IsInspection',
            // 'ClosedDate',
            // 'Manual_Labor',
            // 'Service_Company_Id',
            // 'Priority_Id',
            // 'Category_Id',
            // 'Expertise_Level',
            // 'Entered_By',
            // 'Invoice_Contact',
            // 'Signer',
            // 'Remittance',
            // 'Signature_Image',
            // 'Payment_Received',
            // 'Sub_Problem_Id',
            // 'Service_Level_Id',
            // 'UserCode',
            // 'Edit_Timestamp',
            // 'PO_Number',
            // 'CustomerComments',
            // 'Dispatch_Regular_Minutes',
            // 'Dispatch_Overtime_Minutes:datetime',
            // 'Dispatch_Holiday_Minutes',
            // 'Number_Of_Dispatches',
            // 'Route_Id',
            // 'Sub_Customer_Site_ID',
            // 'Customer_CC_Id',
            // 'Customer_Bank_Id',
            // 'Ticket_Status_Id',
            // 'Customer_EFT_Id',
            // 'Auto_Notify',
            // 'Customer_Bill_Id',
            // 'Customer_Contact_Id',
            // 'Requested_By_Phone_Ext',
            // 'Inspection_Id',
            // 'Service_Ticket_Group_Id',
            // 'Service_Coordinator_Employee_Id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
