<?php

	namespace common\models;

	use Yii;

	/**
	 * This is the model class for table "AR_Customer_Site".
	 *
	 * @property integer $Customer_Site_Id
	 * @property integer $Customer_Id
	 * @property integer $Tax_Group_Id
	 * @property integer $Branch_Id
	 * @property string $Commercial
	 * @property string $Honorific
	 * @property string $First_Name
	 * @property string $Last_Name
	 * @property string $Middle_Initial
	 * @property string $Business_Name
	 * @property string $Address_1
	 * @property string $Address_2
	 * @property string $Address_3
	 * @property integer $GE_Table1_Id
	 * @property integer $GE_Table2_Id
	 * @property integer $GE_Table3_Id
	 * @property integer $GE_Table4_Id
	 * @property integer $GE_Table5_Id
	 * @property string $Zip_Code_Plus4
	 * @property integer $Country_Id
	 * @property string $Phone_1
	 * @property string $Phone_2
	 * @property string $Fax
	 * @property string $E_Mail
	 * @property string $Site_Comments
	 * @property string $Map_Code
	 * @property string $Cross_Street
	 * @property string $Customer_Since
	 * @property string $Inactive
	 * @property string $External_Link
	 * @property string $External_Serial_Number
	 * @property string $External_Version_Number
	 * @property string $GE1_Description
	 * @property string $GE2_Description
	 * @property string $GE2_Short
	 * @property string $GE3_Description
	 * @property string $GE4_Description
	 * @property string $GE5_Description
	 * @property integer $Cycle_Tax_Group_Id
	 * @property string $Tax_Exempt_Num
	 * @property string $GST_Tax_Exempt_Num
	 * @property string $Site_Number
	 * @property integer $Customer_Bill_Id
	 * @property string $Business_Name_2
	 * @property integer $GEO_Taxing_Level_Id
	 */
	class ARCustomerSite extends \yii\db\ActiveRecord
	{
		/**
		 * @inheritdoc
		 */
		public static function tableName()
		{
			return 'AR_Customer_Site';
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
						'Tax_Group_Id',
						'Branch_Id',
						'First_Name',
						'Last_Name',
						'Business_Name',
						'GE_Table1_Id',
						'GE_Table2_Id',
						'GE_Table3_Id',
						'GE_Table4_Id',
						'GE_Table5_Id',
						'Country_Id'
					],
					'required'
				],
				[
					[
						'Customer_Id',
						'Tax_Group_Id',
						'Branch_Id',
						'GE_Table1_Id',
						'GE_Table2_Id',
						'GE_Table3_Id',
						'GE_Table4_Id',
						'GE_Table5_Id',
						'Country_Id',
						'Cycle_Tax_Group_Id',
						'Customer_Bill_Id',
						'GEO_Taxing_Level_Id'
					],
					'integer'
				],
				[
					[
						'Commercial',
						'Honorific',
						'First_Name',
						'Last_Name',
						'Middle_Initial',
						'Business_Name',
						'Address_1',
						'Address_2',
						'Address_3',
						'Zip_Code_Plus4',
						'Phone_1',
						'Phone_2',
						'Fax',
						'E_Mail',
						'Site_Comments',
						'Map_Code',
						'Cross_Street',
						'Inactive',
						'External_Link',
						'External_Serial_Number',
						'External_Version_Number',
						'GE1_Description',
						'GE2_Description',
						'GE2_Short',
						'GE3_Description',
						'GE4_Description',
						'GE5_Description',
						'Tax_Exempt_Num',
						'GST_Tax_Exempt_Num',
						'Site_Number',
						'Business_Name_2'
					],
					'string'
				],
				[ [ 'Customer_Since' ], 'safe' ]
			];
		}

		/**
		 * @inheritdoc
		 */
		public function attributeLabels()
		{
			return [
				'Customer_Site_Id'        => 'Customer  Site  ID',
				'Customer_Id'             => 'Customer  ID',
				'Tax_Group_Id'            => 'Tax  Group  ID',
				'Branch_Id'               => 'Branch  ID',
				'Commercial'              => 'Commercial',
				'Honorific'               => 'Honorific',
				'First_Name'              => 'First  Name',
				'Last_Name'               => 'Last  Name',
				'Middle_Initial'          => 'Middle  Initial',
				'Business_Name'           => 'Business  Name',
				'Address_1'               => 'Address 1',
				'Address_2'               => 'Address 2',
				'Address_3'               => 'Address 3',
				'GE_Table1_Id'            => 'Ge  Table1  ID',
				'GE_Table2_Id'            => 'Ge  Table2  ID',
				'GE_Table3_Id'            => 'Ge  Table3  ID',
				'GE_Table4_Id'            => 'Ge  Table4  ID',
				'GE_Table5_Id'            => 'Ge  Table5  ID',
				'Zip_Code_Plus4'          => 'Zip  Code  Plus4',
				'Country_Id'              => 'Country  ID',
				'Phone_1'                 => 'Phone 1',
				'Phone_2'                 => 'Phone 2',
				'Fax'                     => 'Fax',
				'E_Mail'                  => 'E  Mail',
				'Site_Comments'           => 'Site  Comments',
				'Map_Code'                => 'Map  Code',
				'Cross_Street'            => 'Cross  Street',
				'Customer_Since'          => 'Customer  Since',
				'Inactive'                => 'Inactive',
				'External_Link'           => 'External  Link',
				'External_Serial_Number'  => 'External  Serial  Number',
				'External_Version_Number' => 'External  Version  Number',
				'GE1_Description'         => 'Ge1  Description',
				'GE2_Description'         => 'Ge2  Description',
				'GE2_Short'               => 'Ge2  Short',
				'GE3_Description'         => 'Ge3  Description',
				'GE4_Description'         => 'Ge4  Description',
				'GE5_Description'         => 'Ge5  Description',
				'Cycle_Tax_Group_Id'      => 'Cycle  Tax  Group  ID',
				'Tax_Exempt_Num'          => 'Tax  Exempt  Num',
				'GST_Tax_Exempt_Num'      => 'Gst  Tax  Exempt  Num',
				'Site_Number'             => 'Site  Number',
				'Customer_Bill_Id'        => 'Customer  Bill  ID',
				'Business_Name_2'         => 'Business  Name 2',
				'GEO_Taxing_Level_Id'     => 'Geo  Taxing  Level  ID',
			];
		}
	}
