<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SVServiceTicket;

/**
 * SVServiceTicketSearch represents the model behind the search form about `common\models\SVServiceTicket`.
 */
class SVServiceTicketSearch extends SVServiceTicket
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Service_Ticket_Id', 'Ticket_Number', 'Customer_Id', 'Customer_Site_Id', 'Customer_System_Id', 'Problem_Id', 'Last_Service_Tech_Id', 'Estimated_Length', 'Resolution_Id', 'Invoice_Id', 'Service_Company_Id', 'Priority_Id', 'Category_Id', 'Expertise_Level', 'Sub_Problem_Id', 'Service_Level_Id', 'Dispatch_Regular_Minutes', 'Dispatch_Overtime_Minutes', 'Dispatch_Holiday_Minutes', 'Number_Of_Dispatches', 'Route_Id', 'Sub_Customer_Site_ID', 'Customer_CC_Id', 'Customer_Bank_Id', 'Ticket_Status_Id', 'Customer_EFT_Id', 'Customer_Bill_Id', 'Customer_Contact_Id', 'Inspection_Id', 'Service_Ticket_Group_Id', 'Service_Coordinator_Employee_Id'], 'integer'],
            [['Ticket_Status', 'Multiple_Systems', 'Creation_Date', 'Requested_By', 'Requested_By_Phone', 'Scheduled_For', 'Billable', 'Billed', 'FieldComments', 'Bypass_Warranty', 'Bypass_ServiceLevel', 'IsInspection', 'ClosedDate', 'Manual_Labor', 'Entered_By', 'Invoice_Contact', 'Signer', 'Remittance', 'Signature_Image', 'Payment_Received', 'UserCode', 'Edit_Timestamp', 'PO_Number', 'CustomerComments', 'Auto_Notify', 'Requested_By_Phone_Ext'], 'safe'],
            [['Equipment_Charge', 'Labor_Charge', 'Other_Charge', 'TaxTotal', 'Regular_Hours', 'Overtime_Hours', 'Holiday_Hours', 'Trip_Charge', 'Regular_Rate', 'Overtime_Rate', 'Holiday_Rate'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SVServiceTicket::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'Service_Ticket_Id' => $this->Service_Ticket_Id,
            'Ticket_Number' => $this->Ticket_Number,
            'Customer_Id' => $this->Customer_Id,
            'Customer_Site_Id' => $this->Customer_Site_Id,
            'Customer_System_Id' => $this->Customer_System_Id,
            'Creation_Date' => $this->Creation_Date,
            'Problem_Id' => $this->Problem_Id,
            'Scheduled_For' => $this->Scheduled_For,
            'Last_Service_Tech_Id' => $this->Last_Service_Tech_Id,
            'Estimated_Length' => $this->Estimated_Length,
            'Resolution_Id' => $this->Resolution_Id,
            'Equipment_Charge' => $this->Equipment_Charge,
            'Labor_Charge' => $this->Labor_Charge,
            'Other_Charge' => $this->Other_Charge,
            'TaxTotal' => $this->TaxTotal,
            'Regular_Hours' => $this->Regular_Hours,
            'Overtime_Hours' => $this->Overtime_Hours,
            'Holiday_Hours' => $this->Holiday_Hours,
            'Trip_Charge' => $this->Trip_Charge,
            'Invoice_Id' => $this->Invoice_Id,
            'Regular_Rate' => $this->Regular_Rate,
            'Overtime_Rate' => $this->Overtime_Rate,
            'Holiday_Rate' => $this->Holiday_Rate,
            'ClosedDate' => $this->ClosedDate,
            'Service_Company_Id' => $this->Service_Company_Id,
            'Priority_Id' => $this->Priority_Id,
            'Category_Id' => $this->Category_Id,
            'Expertise_Level' => $this->Expertise_Level,
            'Sub_Problem_Id' => $this->Sub_Problem_Id,
            'Service_Level_Id' => $this->Service_Level_Id,
            'Edit_Timestamp' => $this->Edit_Timestamp,
            'Dispatch_Regular_Minutes' => $this->Dispatch_Regular_Minutes,
            'Dispatch_Overtime_Minutes' => $this->Dispatch_Overtime_Minutes,
            'Dispatch_Holiday_Minutes' => $this->Dispatch_Holiday_Minutes,
            'Number_Of_Dispatches' => $this->Number_Of_Dispatches,
            'Route_Id' => $this->Route_Id,
            'Sub_Customer_Site_ID' => $this->Sub_Customer_Site_ID,
            'Customer_CC_Id' => $this->Customer_CC_Id,
            'Customer_Bank_Id' => $this->Customer_Bank_Id,
            'Ticket_Status_Id' => $this->Ticket_Status_Id,
            'Customer_EFT_Id' => $this->Customer_EFT_Id,
            'Customer_Bill_Id' => $this->Customer_Bill_Id,
            'Customer_Contact_Id' => $this->Customer_Contact_Id,
            'Inspection_Id' => $this->Inspection_Id,
            'Service_Ticket_Group_Id' => $this->Service_Ticket_Group_Id,
            'Service_Coordinator_Employee_Id' => $this->Service_Coordinator_Employee_Id,
        ]);

        $query->andFilterWhere(['like', 'Ticket_Status', $this->Ticket_Status])
            ->andFilterWhere(['like', 'Multiple_Systems', $this->Multiple_Systems])
            ->andFilterWhere(['like', 'Requested_By', $this->Requested_By])
            ->andFilterWhere(['like', 'Requested_By_Phone', $this->Requested_By_Phone])
            ->andFilterWhere(['like', 'Billable', $this->Billable])
            ->andFilterWhere(['like', 'Billed', $this->Billed])
            ->andFilterWhere(['like', 'FieldComments', $this->FieldComments])
            ->andFilterWhere(['like', 'Bypass_Warranty', $this->Bypass_Warranty])
            ->andFilterWhere(['like', 'Bypass_ServiceLevel', $this->Bypass_ServiceLevel])
            ->andFilterWhere(['like', 'IsInspection', $this->IsInspection])
            ->andFilterWhere(['like', 'Manual_Labor', $this->Manual_Labor])
            ->andFilterWhere(['like', 'Entered_By', $this->Entered_By])
            ->andFilterWhere(['like', 'Invoice_Contact', $this->Invoice_Contact])
            ->andFilterWhere(['like', 'Signer', $this->Signer])
            ->andFilterWhere(['like', 'Remittance', $this->Remittance])
            ->andFilterWhere(['like', 'Signature_Image', $this->Signature_Image])
            ->andFilterWhere(['like', 'Payment_Received', $this->Payment_Received])
            ->andFilterWhere(['like', 'UserCode', $this->UserCode])
            ->andFilterWhere(['like', 'PO_Number', $this->PO_Number])
            ->andFilterWhere(['like', 'CustomerComments', $this->CustomerComments])
            ->andFilterWhere(['like', 'Auto_Notify', $this->Auto_Notify])
            ->andFilterWhere(['like', 'Requested_By_Phone_Ext', $this->Requested_By_Phone_Ext]);

        return $dataProvider;
    }
}
