<?php

	namespace common\models;

	use Yii;

	/**
	 * This is the model class for table "SV_Service_Ticket".
	 *
	 * @property integer $Service_Ticket_Id
	 * @property string $Ticket_Status
	 * @property integer $Ticket_Number
	 * @property integer $Customer_Id
	 * @property integer $Customer_Site_Id
	 * @property integer $Customer_System_Id
	 * @property string $Multiple_Systems
	 * @property string $Creation_Date
	 * @property string $Requested_By
	 * @property string $Requested_By_Phone
	 * @property integer $Problem_Id
	 * @property string $Scheduled_For
	 * @property integer $Last_Service_Tech_Id
	 * @property integer $Estimated_Length
	 * @property integer $Resolution_Id
	 * @property string $Billable
	 * @property string $Billed
	 * @property string $Equipment_Charge
	 * @property string $Labor_Charge
	 * @property string $Other_Charge
	 * @property string $TaxTotal
	 * @property string $FieldComments
	 * @property double $Regular_Hours
	 * @property double $Overtime_Hours
	 * @property double $Holiday_Hours
	 * @property string $Trip_Charge
	 * @property integer $Invoice_Id
	 * @property string $Regular_Rate
	 * @property string $Overtime_Rate
	 * @property string $Holiday_Rate
	 * @property string $Bypass_Warranty
	 * @property string $Bypass_ServiceLevel
	 * @property string $IsInspection
	 * @property string $ClosedDate
	 * @property string $Manual_Labor
	 * @property integer $Service_Company_Id
	 * @property integer $Priority_Id
	 * @property integer $Category_Id
	 * @property integer $Expertise_Level
	 * @property string $Entered_By
	 * @property string $Invoice_Contact
	 * @property string $Signer
	 * @property string $Remittance
	 * @property resource $Signature_Image
	 * @property string $Payment_Received
	 * @property integer $Sub_Problem_Id
	 * @property integer $Service_Level_Id
	 * @property string $UserCode
	 * @property string $Edit_Timestamp
	 * @property string $PO_Number
	 * @property string $CustomerComments
	 * @property integer $Dispatch_Regular_Minutes
	 * @property integer $Dispatch_Overtime_Minutes
	 * @property integer $Dispatch_Holiday_Minutes
	 * @property integer $Number_Of_Dispatches
	 * @property integer $Route_Id
	 * @property integer $Sub_Customer_Site_ID
	 * @property integer $Customer_CC_Id
	 * @property integer $Customer_Bank_Id
	 * @property integer $Ticket_Status_Id
	 * @property integer $Customer_EFT_Id
	 * @property string $Auto_Notify
	 * @property integer $Customer_Bill_Id
	 * @property integer $Customer_Contact_Id
	 * @property string $Requested_By_Phone_Ext
	 * @property integer $Inspection_Id
	 * @property integer $Service_Ticket_Group_Id
	 * @property integer $Service_Coordinator_Employee_Id
	 */
	class SVServiceTicket extends \yii\db\ActiveRecord
	{

        public static $AllowedStatus = [ 'CL', 'DP', 'GB', 'IP', 'OP', 'RS', 'SC' ];

		/**
		 * @inheritdoc
		 */
		public static function tableName()
		{
			return 'SV_Service_Ticket';
		}


		/**
		 * @inheritdoc
		 */
		public function rules()
		{
			return [
				[
					[
						'Ticket_Status',
						'Ticket_Number',
						'Customer_Id',
						'Customer_System_Id',
						'Problem_Id',
						'Last_Service_Tech_Id',
						'Resolution_Id',
						'Invoice_Id'
					],
					'required'
				],
				[
					[
						'Ticket_Status',
						'Multiple_Systems',
						'Requested_By',
						'Requested_By_Phone',
						'Billable',
						'Billed',
						'FieldComments',
						'Bypass_Warranty',
						'Bypass_ServiceLevel',
						'IsInspection',
						'Manual_Labor',
						'Entered_By',
						'Invoice_Contact',
						'Signer',
						'Remittance',
						'Signature_Image',
						'Payment_Received',
						'UserCode',
						'PO_Number',
						'CustomerComments',
						'Auto_Notify',
						'Requested_By_Phone_Ext'
					],
					'string'
				],
				[
					[
						'Ticket_Number',
						'Customer_Id',
						'Customer_Site_Id',
						'Customer_System_Id',
						'Problem_Id',
						'Last_Service_Tech_Id',
						'Estimated_Length',
						'Resolution_Id',
						'Invoice_Id',
						'Service_Company_Id',
						'Priority_Id',
						'Category_Id',
						'Expertise_Level',
						'Sub_Problem_Id',
						'Service_Level_Id',
						'Dispatch_Regular_Minutes',
						'Dispatch_Overtime_Minutes',
						'Dispatch_Holiday_Minutes',
						'Number_Of_Dispatches',
						'Route_Id',
						'Sub_Customer_Site_ID',
						'Customer_CC_Id',
						'Customer_Bank_Id',
						'Ticket_Status_Id',
						'Customer_EFT_Id',
						'Customer_Bill_Id',
						'Customer_Contact_Id',
						'Inspection_Id',
						'Service_Ticket_Group_Id',
						'Service_Coordinator_Employee_Id'
					],
					'integer'
				],
				[ [ 'Creation_Date', 'Scheduled_For', 'ClosedDate', 'Edit_Timestamp' ], 'safe' ],
				[
					[
						'Equipment_Charge',
						'Labor_Charge',
						'Other_Charge',
						'TaxTotal',
						'Regular_Hours',
						'Overtime_Hours',
						'Holiday_Hours',
						'Trip_Charge',
						'Regular_Rate',
						'Overtime_Rate',
						'Holiday_Rate'
					],
					'number'
				]
			];
		}

		/**
		 * @inheritdoc
		 */
		public function attributeLabels()
		{
			return [
				'Service_Ticket_Id'               => 'Service  Ticket  ID',
				'Ticket_Status'                   => 'Ticket  Status',
				'Ticket_Number'                   => 'Ticket  Number',
				'Customer_Id'                     => 'Customer  ID',
				'Customer_Site_Id'                => 'Customer  Site  ID',
				'Customer_System_Id'              => 'Customer  System  ID',
				'Multiple_Systems'                => 'Multiple  Systems',
				'Creation_Date'                   => 'Creation  Date',
				'Requested_By'                    => 'Requested  By',
				'Requested_By_Phone'              => 'Requested  By  Phone',
				'Problem_Id'                      => 'Problem  ID',
				'Scheduled_For'                   => 'Scheduled  For',
				'Last_Service_Tech_Id'            => 'Last  Service  Tech  ID',
				'Estimated_Length'                => 'Estimated  Length',
				'Resolution_Id'                   => 'Resolution  ID',
				'Billable'                        => 'Billable',
				'Billed'                          => 'Billed',
				'Equipment_Charge'                => 'Equipment  Charge',
				'Labor_Charge'                    => 'Labor  Charge',
				'Other_Charge'                    => 'Other  Charge',
				'TaxTotal'                        => 'Tax Total',
				'FieldComments'                   => 'Field Comments',
				'Regular_Hours'                   => 'Regular  Hours',
				'Overtime_Hours'                  => 'Overtime  Hours',
				'Holiday_Hours'                   => 'Holiday  Hours',
				'Trip_Charge'                     => 'Trip  Charge',
				'Invoice_Id'                      => 'Invoice  ID',
				'Regular_Rate'                    => 'Regular  Rate',
				'Overtime_Rate'                   => 'Overtime  Rate',
				'Holiday_Rate'                    => 'Holiday  Rate',
				'Bypass_Warranty'                 => 'Bypass  Warranty',
				'Bypass_ServiceLevel'             => 'Bypass  Service Level',
				'IsInspection'                    => 'Is Inspection',
				'ClosedDate'                      => 'Closed Date',
				'Manual_Labor'                    => 'Manual  Labor',
				'Service_Company_Id'              => 'Service  Company  ID',
				'Priority_Id'                     => 'Priority  ID',
				'Category_Id'                     => 'Category  ID',
				'Expertise_Level'                 => 'Expertise  Level',
				'Entered_By'                      => 'Entered  By',
				'Invoice_Contact'                 => 'Invoice  Contact',
				'Signer'                          => 'Signer',
				'Remittance'                      => 'Remittance',
				'Signature_Image'                 => 'Signature  Image',
				'Payment_Received'                => 'Payment  Received',
				'Sub_Problem_Id'                  => 'Sub  Problem  ID',
				'Service_Level_Id'                => 'Service  Level  ID',
				'UserCode'                        => 'User Code',
				'Edit_Timestamp'                  => 'Edit  Timestamp',
				'PO_Number'                       => 'Po  Number',
				'CustomerComments'                => 'Customer Comments',
				'Dispatch_Regular_Minutes'        => 'Dispatch  Regular  Minutes',
				'Dispatch_Overtime_Minutes'       => 'Dispatch  Overtime  Minutes',
				'Dispatch_Holiday_Minutes'        => 'Dispatch  Holiday  Minutes',
				'Number_Of_Dispatches'            => 'Number  Of  Dispatches',
				'Route_Id'                        => 'Route  ID',
				'Sub_Customer_Site_ID'            => 'Sub  Customer  Site  ID',
				'Customer_CC_Id'                  => 'Customer  Cc  ID',
				'Customer_Bank_Id'                => 'Customer  Bank  ID',
				'Ticket_Status_Id'                => 'Ticket  Status  ID',
				'Customer_EFT_Id'                 => 'Customer  Eft  ID',
				'Auto_Notify'                     => 'Auto  Notify',
				'Customer_Bill_Id'                => 'Customer  Bill  ID',
				'Customer_Contact_Id'             => 'Customer  Contact  ID',
				'Requested_By_Phone_Ext'          => 'Requested  By  Phone  Ext',
				'Inspection_Id'                   => 'Inspection  ID',
				'Service_Ticket_Group_Id'         => 'Service  Ticket  Group  ID',
				'Service_Coordinator_Employee_Id' => 'Service  Coordinator  Employee  ID',
			];
        }

        public static function find() {
            return parent::find()->where( [ 'Ticket_Status' => 'OP' ] )->orderBy( [ 'Service_Ticket_Id' => SORT_DESC ] )->limit( 100 );
		}

        public function getProblem() {
            return $this->hasMany( 'SVProblem', [ 'problem_id' => 'problem_id' ] );
        }

	}