<?php

	namespace common\models;

	use Yii;

	/**
	 * This is the model class for table "IN_Part".
	 *
	 * @property integer $Part_Id
	 * @property string $Part_Code
	 * @property string $Description
	 * @property string $Detail
	 * @property integer $Item_Id
	 * @property integer $Product_Line_Id
	 * @property integer $Unit_Of_Measure_Id
	 * @property string $Non_Value_Part
	 * @property string $Purchase_Cost
	 * @property integer $Purchase_UOM_Id
	 * @property string $Purchase_Description
	 * @property integer $Primary_Vendor_Id
	 * @property string $Vendor_Part
	 * @property integer $Issue_UOM_Id
	 * @property string $Customer_Equipment
	 * @property string $Service_Price
	 * @property string $Service_Description
	 * @property string $Sales_Price
	 * @property string $Sales_Description
	 * @property string $Inactive
	 * @property integer $Manufacturer_Id
	 * @property string $Labor_Units
	 * @property string $Service_Part
	 * @property string $Manufacturer_Part_Code
	 * @property string $UPC
	 * @property string $Notes
	 * @property string $Sales_Part
	 * @property string $Special_Order
	 * @property string $Standard_Cost
	 * @property integer $PPV_Account_Id
	 * @property integer $Dir_Expense_Account_Id
	 * @property string $Customer_Equipment_Breakout
	 * @property integer $Costing_Method_Id
	 * @property string $Service_Price_2
	 * @property string $Job_Use_Default
	 * @property string $Freeze_Purchasing
	 * @property integer $Manufacturer_Warranty_Id
	 */
	class INPart extends \yii\db\ActiveRecord
	{
		/**
		 * @inheritdoc
		 */
		public static function tableName()
		{
			return 'IN_Part';
		}

		/**
		 * @inheritdoc
		 */
		public function rules()
		{
			return [
				[
					[
						'Part_Code',
						'Item_Id',
						'Product_Line_Id',
						'Unit_Of_Measure_Id',
						'Purchase_UOM_Id',
						'Primary_Vendor_Id',
						'Issue_UOM_Id',
						'Manufacturer_Part_Code',
						'UPC',
						'Sales_Part',
						'Special_Order'
					],
					'required'
				],
				[
					[
						'Part_Code',
						'Description',
						'Detail',
						'Non_Value_Part',
						'Purchase_Description',
						'Vendor_Part',
						'Customer_Equipment',
						'Service_Description',
						'Sales_Description',
						'Inactive',
						'Service_Part',
						'Manufacturer_Part_Code',
						'UPC',
						'Notes',
						'Sales_Part',
						'Special_Order',
						'Standard_Cost',
						'Customer_Equipment_Breakout',
						'Job_Use_Default',
						'Freeze_Purchasing'
					],
					'string'
				],
				[
					[
						'Item_Id',
						'Product_Line_Id',
						'Unit_Of_Measure_Id',
						'Purchase_UOM_Id',
						'Primary_Vendor_Id',
						'Issue_UOM_Id',
						'Manufacturer_Id',
						'PPV_Account_Id',
						'Dir_Expense_Account_Id',
						'Costing_Method_Id',
						'Manufacturer_Warranty_Id'
					],
					'integer'
				],
				[ [ 'Purchase_Cost', 'Service_Price', 'Sales_Price', 'Labor_Units', 'Service_Price_2' ], 'number' ]
			];
		}

		/**
		 * @inheritdoc
		 */
		public function attributeLabels()
		{
			return [
				'Part_Id'                     => 'Part  ID',
				'Part_Code'                   => 'Part  Code',
				'Description'                 => 'Description',
				'Detail'                      => 'Detail',
				'Item_Id'                     => 'Item  ID',
				'Product_Line_Id'             => 'Product  Line  ID',
				'Unit_Of_Measure_Id'          => 'Unit  Of  Measure  ID',
				'Non_Value_Part'              => 'Non  Value  Part',
				'Purchase_Cost'               => 'Purchase  Cost',
				'Purchase_UOM_Id'             => 'Purchase  Uom  ID',
				'Purchase_Description'        => 'Purchase  Description',
				'Primary_Vendor_Id'           => 'Primary  Vendor  ID',
				'Vendor_Part'                 => 'Vendor  Part',
				'Issue_UOM_Id'                => 'Issue  Uom  ID',
				'Customer_Equipment'          => 'Customer  Equipment',
				'Service_Price'               => 'Service  Price',
				'Service_Description'         => 'Service  Description',
				'Sales_Price'                 => 'Sales  Price',
				'Sales_Description'           => 'Sales  Description',
				'Inactive'                    => 'Inactive',
				'Manufacturer_Id'             => 'Manufacturer  ID',
				'Labor_Units'                 => 'Labor  Units',
				'Service_Part'                => 'Service  Part',
				'Manufacturer_Part_Code'      => 'Manufacturer  Part  Code',
				'UPC'                         => 'Upc',
				'Notes'                       => 'Notes',
				'Sales_Part'                  => 'Sales  Part',
				'Special_Order'               => 'Special  Order',
				'Standard_Cost'               => 'Standard  Cost',
				'PPV_Account_Id'              => 'Ppv  Account  ID',
				'Dir_Expense_Account_Id'      => 'Dir  Expense  Account  ID',
				'Customer_Equipment_Breakout' => 'Customer  Equipment  Breakout',
				'Costing_Method_Id'           => 'Costing  Method  ID',
				'Service_Price_2'             => 'Service  Price 2',
				'Job_Use_Default'             => 'Job  Use  Default',
				'Freeze_Purchasing'           => 'Freeze  Purchasing',
				'Manufacturer_Warranty_Id'    => 'Manufacturer  Warranty  ID',
			];
		}
	}
