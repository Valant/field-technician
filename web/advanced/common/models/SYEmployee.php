<?php

	namespace common\models;

	use Yii;

	/**
	 * This is the model class for table "SY_Employee".
	 *
	 * @property integer $Employee_Id
	 * @property string $Employee_Code
	 * @property integer $Employee_Type_Id
	 * @property string $First_Name
	 * @property string $Last_Name
	 * @property string $Middle_Init
	 * @property string $Social_Security
	 * @property integer $Department_Id
	 * @property integer $Supervisor_Id
	 * @property string $UserCode
	 * @property string $Receive_Inventory
	 * @property string $Inactive
	 * @property integer $Branch_Id
	 * @property integer $Category_Id
	 * @property integer $Payroll_Account_Id
	 * @property string $Is_Salary
	 * @property string $Salary
	 * @property string $Regular_Rate
	 * @property string $Overtime_Rate
	 * @property string $Payroll_File_No
	 * @property string $Entered_By
	 * @property string $Entered_Date
	 * @property string $Updated_By
	 * @property string $Updated_Date
	 * @property string $Hire_Date
	 * @property string $Termination_Date
	 * @property string $Overtime_Mult
	 * @property integer $User_Id
	 * @property string $Supervisor_Commission_Pctg
	 * @property integer $Job_Approval_Group_Id
	 * @property resource $Picture
	 */
	class SYEmployee extends \yii\db\ActiveRecord
	{
		/**
		 * @inheritdoc
		 */
		public static function tableName()
		{
			return 'SY_Employee';
		}

		/**
		 * @inheritdoc
		 */
		public function rules()
		{
			return [
				[
					[
						'Employee_Code',
						'First_Name',
						'Last_Name',
						'Middle_Init',
						'Social_Security',
						'UserCode',
						'Receive_Inventory',
						'Inactive',
						'Is_Salary',
						'Payroll_File_No',
						'Entered_By',
						'Updated_By',
						'Picture'
					],
					'string'
				],
				[
					[
						'Employee_Type_Id',
						'Department_Id',
						'Supervisor_Id',
						'Branch_Id',
						'Category_Id',
						'Payroll_Account_Id',
						'User_Id',
						'Job_Approval_Group_Id'
					],
					'integer'
				],
				[
					[ 'Salary', 'Regular_Rate', 'Overtime_Rate', 'Overtime_Mult', 'Supervisor_Commission_Pctg' ],
					'number'
				],
				[ [ 'Entered_Date', 'Updated_Date', 'Hire_Date', 'Termination_Date' ], 'safe' ]
			];
		}

		/**
		 * @inheritdoc
		 */
		public function attributeLabels()
		{
			return [
				'Employee_Id'                => 'Employee  ID',
				'Employee_Code'              => 'Employee  Code',
				'Employee_Type_Id'           => 'Employee  Type  ID',
				'First_Name'                 => 'First  Name',
				'Last_Name'                  => 'Last  Name',
				'Middle_Init'                => 'Middle  Init',
				'Social_Security'            => 'Social  Security',
				'Department_Id'              => 'Department  ID',
				'Supervisor_Id'              => 'Supervisor  ID',
				'UserCode'                   => 'User Code',
				'Receive_Inventory'          => 'Receive  Inventory',
				'Inactive'                   => 'Inactive',
				'Branch_Id'                  => 'Branch  ID',
				'Category_Id'                => 'Category  ID',
				'Payroll_Account_Id'         => 'Payroll  Account  ID',
				'Is_Salary'                  => 'Is  Salary',
				'Salary'                     => 'Salary',
				'Regular_Rate'               => 'Regular  Rate',
				'Overtime_Rate'              => 'Overtime  Rate',
				'Payroll_File_No'            => 'Payroll  File  No',
				'Entered_By'                 => 'Entered  By',
				'Entered_Date'               => 'Entered  Date',
				'Updated_By'                 => 'Updated  By',
				'Updated_Date'               => 'Updated  Date',
				'Hire_Date'                  => 'Hire  Date',
				'Termination_Date'           => 'Termination  Date',
				'Overtime_Mult'              => 'Overtime  Mult',
				'User_Id'                    => 'User  ID',
				'Supervisor_Commission_Pctg' => 'Supervisor  Commission  Pctg',
				'Job_Approval_Group_Id'      => 'Job  Approval  Group  ID',
				'Picture'                    => 'Picture',
			];
		}
	}
