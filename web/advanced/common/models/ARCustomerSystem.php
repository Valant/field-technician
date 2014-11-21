<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "AR_Customer_System".
     *
     * @property integer $Customer_System_Id
     * @property integer $Customer_Id
     * @property integer $Customer_Site_Id
     * @property integer $System_Id
     * @property integer $Panel_Type_Id
     * @property string $Panel_Location
     * @property string $Memo
     * @property integer $Job_Id
     * @property integer $Contract_Form_Id
     * @property string $Contract_Number
     * @property integer $Warranty_Id
     * @property integer $Service_Level_Id
     * @property string $Alarm_Account
     * @property integer $Alarm_Company_Id
     * @property integer $Service_Company_Id
     * @property string $Contract_Start_Date
     * @property integer $Months
     * @property integer $Renewal_Months
     * @property integer $Invoice_Description_Id
     * @property string $Cycle_PO_Number
     * @property string $Cycle_PO_Expire
     * @property integer $Inspection_Cycle_Id
     * @property string $Last_Inspection_Date
     * @property string $Next_Inspection_Date
     * @property integer $Inspection_Problem_Id
     * @property string $InspectionNotes
     * @property string $System_Comments
     * @property string $Ok_To_Incr_Date
     * @property string $Warranty_Date
     * @property string $External_Link
     * @property integer $Inspection_Service_Level_Id
     * @property integer $Secondary_Service_Company_Id1
     * @property integer $Secondary_Service_Company_Id2
     * @property string $Inactive
     * @property string $PO_Required
     * @property integer $Route_Id
     */
    class ARCustomerSystem extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'AR_Customer_System';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [
                    [
                        'Customer_Id',
                        'Customer_Site_Id',
                        'System_Id',
                        'Panel_Type_Id',
                        'Job_Id',
                        'Contract_Form_Id',
                        'Warranty_Id',
                        'Service_Level_Id',
                        'Alarm_Company_Id',
                        'Service_Company_Id',
                        'Invoice_Description_Id',
                        'Inspection_Cycle_Id',
                        'Inspection_Problem_Id',
                        'Secondary_Service_Company_Id1',
                        'Secondary_Service_Company_Id2'
                    ],
                    'required'
                ],
                [
                    [
                        'Customer_Id',
                        'Customer_Site_Id',
                        'System_Id',
                        'Panel_Type_Id',
                        'Job_Id',
                        'Contract_Form_Id',
                        'Warranty_Id',
                        'Service_Level_Id',
                        'Alarm_Company_Id',
                        'Service_Company_Id',
                        'Months',
                        'Renewal_Months',
                        'Invoice_Description_Id',
                        'Inspection_Cycle_Id',
                        'Inspection_Problem_Id',
                        'Inspection_Service_Level_Id',
                        'Secondary_Service_Company_Id1',
                        'Secondary_Service_Company_Id2',
                        'Route_Id'
                    ],
                    'integer'
                ],
                [
                    [
                        'Panel_Location',
                        'Memo',
                        'Contract_Number',
                        'Alarm_Account',
                        'Cycle_PO_Number',
                        'InspectionNotes',
                        'System_Comments',
                        'External_Link',
                        'Inactive',
                        'PO_Required'
                    ],
                    'string'
                ],
                [
                    [
                        'Contract_Start_Date',
                        'Cycle_PO_Expire',
                        'Last_Inspection_Date',
                        'Next_Inspection_Date',
                        'Ok_To_Incr_Date',
                        'Warranty_Date'
                    ],
                    'safe'
                ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'Customer_System_Id'            => 'Customer  System  ID',
                'Customer_Id'                   => 'Customer  ID',
                'Customer_Site_Id'              => 'Customer  Site  ID',
                'System_Id'                     => 'System  ID',
                'Panel_Type_Id'                 => 'Panel  Type  ID',
                'Panel_Location'                => 'Panel  Location',
                'Memo'                          => 'Memo',
                'Job_Id'                        => 'Job  ID',
                'Contract_Form_Id'              => 'Contract  Form  ID',
                'Contract_Number'               => 'Contract  Number',
                'Warranty_Id'                   => 'Warranty  ID',
                'Service_Level_Id'              => 'Service  Level  ID',
                'Alarm_Account'                 => 'Alarm  Account',
                'Alarm_Company_Id'              => 'Alarm  Company  ID',
                'Service_Company_Id'            => 'Service  Company  ID',
                'Contract_Start_Date'           => 'Contract  Start  Date',
                'Months'                        => 'Months',
                'Renewal_Months'                => 'Renewal  Months',
                'Invoice_Description_Id'        => 'Invoice  Description  ID',
                'Cycle_PO_Number'               => 'Cycle  Po  Number',
                'Cycle_PO_Expire'               => 'Cycle  Po  Expire',
                'Inspection_Cycle_Id'           => 'Inspection  Cycle  ID',
                'Last_Inspection_Date'          => 'Last  Inspection  Date',
                'Next_Inspection_Date'          => 'Next  Inspection  Date',
                'Inspection_Problem_Id'         => 'Inspection  Problem  ID',
                'InspectionNotes'               => 'Inspection Notes',
                'System_Comments'               => 'System  Comments',
                'Ok_To_Incr_Date'               => 'Ok  To  Incr  Date',
                'Warranty_Date'                 => 'Warranty  Date',
                'External_Link'                 => 'External  Link',
                'Inspection_Service_Level_Id'   => 'Inspection  Service  Level  ID',
                'Secondary_Service_Company_Id1' => 'Secondary  Service  Company  Id1',
                'Secondary_Service_Company_Id2' => 'Secondary  Service  Company  Id2',
                'Inactive'                      => 'Inactive',
                'PO_Required'                   => 'Po  Required',
                'Route_Id'                      => 'Route  ID',
            ];
        }
    }
