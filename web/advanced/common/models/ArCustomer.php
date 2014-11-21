<?php

	namespace common\models;

	use Yii;

	/**
	 * This is the model class for table "ar_customer".
	 *
	 * @property integer $Customer_Id
	 * @property string $Customer_Number
	 * @property integer $Customer_Status_Id
	 * @property integer $Customer_Type_Id
	 * @property integer $Collection_Status_Id
	 * @property integer $Dealer_Id
	 * @property integer $Owned_By_Dealer_Id
	 * @property integer $Salesperson_Id
	 * @property integer $Term_Id
	 * @property string $Tax_Exempt_Num
	 * @property string $Blanket_PO
	 * @property string $Blanket_PO_Expire
	 * @property string $Old_Customer_Number
	 * @property string $Total_RMR
	 * @property string $OK_To_Incr_Date
	 * @property string $No_Late_Fees
	 * @property string $No_Statements
	 * @property string $Last_Statement_Date
	 * @property string $StatementBalance
	 * @property string $Print_Sites_On_Bills
	 * @property string $Print_Statements
	 * @property string $Print_Cycle_Invoices
	 * @property string $RollUp_Recurring
	 * @property string $Customer_Since
	 * @property integer $Customer_Group_Id
	 * @property integer $Customer_Relation_Id
	 * @property integer $Master_Account_Id
	 * @property integer $Branch_Id
	 * @property string $Customer_Name
	 * @property string $No_Collections
	 * @property string $Salesperson_Commission_Pctg
	 * @property integer $Customer_Group2_Id
	 * @property string $Customer_Name_2
	 * @property integer $Part_Pricing_Level
	 */
	class ArCustomer extends \yii\db\ActiveRecord
	{
		/**
		 * @inheritdoc
		 */
		public static function tableName()
		{
			return 'ar_customer';
		}

		/**
		 * @inheritdoc
		 */
		public function rules()
		{
			return [
				[
					[
						'Customer_Number',
						'Customer_Status_Id',
						'Customer_Type_Id',
						'Collection_Status_Id',
						'Dealer_Id',
						'Owned_By_Dealer_Id',
						'Salesperson_Id',
						'Term_Id',
						'Customer_Group_Id',
						'Customer_Relation_Id',
						'Master_Account_Id'
					],
					'required'
				],
				[
					[
						'Customer_Number',
						'Tax_Exempt_Num',
						'Blanket_PO',
						'Old_Customer_Number',
						'No_Late_Fees',
						'No_Statements',
						'Print_Sites_On_Bills',
						'Print_Statements',
						'Print_Cycle_Invoices',
						'RollUp_Recurring',
						'Customer_Name',
						'No_Collections',
						'Customer_Name_2'
					],
					'string'
				],
				[
					[
						'Customer_Status_Id',
						'Customer_Type_Id',
						'Collection_Status_Id',
						'Dealer_Id',
						'Owned_By_Dealer_Id',
						'Salesperson_Id',
						'Term_Id',
						'Customer_Group_Id',
						'Customer_Relation_Id',
						'Master_Account_Id',
						'Branch_Id',
						'Customer_Group2_Id',
						'Part_Pricing_Level'
					],
					'integer'
				],
				[ [ 'Blanket_PO_Expire', 'OK_To_Incr_Date', 'Last_Statement_Date', 'Customer_Since' ], 'safe' ],
				[ [ 'Total_RMR', 'StatementBalance', 'Salesperson_Commission_Pctg' ], 'number' ]
			];
		}

		/**
		 * @inheritdoc
		 */
		public function attributeLabels()
		{
			return [
				'Customer_Id'                 => 'Customer  ID',
				'Customer_Number'             => 'Customer  Number',
				'Customer_Status_Id'          => 'Customer  Status  ID',
				'Customer_Type_Id'            => 'Customer  Type  ID',
				'Collection_Status_Id'        => 'Collection  Status  ID',
				'Dealer_Id'                   => 'Dealer  ID',
				'Owned_By_Dealer_Id'          => 'Owned  By  Dealer  ID',
				'Salesperson_Id'              => 'Salesperson  ID',
				'Term_Id'                     => 'Term  ID',
				'Tax_Exempt_Num'              => 'Tax  Exempt  Num',
				'Blanket_PO'                  => 'Blanket  Po',
				'Blanket_PO_Expire'           => 'Blanket  Po  Expire',
				'Old_Customer_Number'         => 'Old  Customer  Number',
				'Total_RMR'                   => 'Total  Rmr',
				'OK_To_Incr_Date'             => 'Ok  To  Incr  Date',
				'No_Late_Fees'                => 'No  Late  Fees',
				'No_Statements'               => 'No  Statements',
				'Last_Statement_Date'         => 'Last  Statement  Date',
				'StatementBalance'            => 'Statement Balance',
				'Print_Sites_On_Bills'        => 'Print  Sites  On  Bills',
				'Print_Statements'            => 'Print  Statements',
				'Print_Cycle_Invoices'        => 'Print  Cycle  Invoices',
				'RollUp_Recurring'            => 'Roll Up  Recurring',
				'Customer_Since'              => 'Customer  Since',
				'Customer_Group_Id'           => 'Customer  Group  ID',
				'Customer_Relation_Id'        => 'Customer  Relation  ID',
				'Master_Account_Id'           => 'Master  Account  ID',
				'Branch_Id'                   => 'Branch  ID',
				'Customer_Name'               => 'Customer  Name',
				'No_Collections'              => 'No  Collections',
				'Salesperson_Commission_Pctg' => 'Salesperson  Commission  Pctg',
				'Customer_Group2_Id'          => 'Customer  Group2  ID',
				'Customer_Name_2'             => 'Customer  Name 2',
				'Part_Pricing_Level'          => 'Part  Pricing  Level',
			];
		}
	}
