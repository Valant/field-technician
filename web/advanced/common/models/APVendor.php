<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 7/15/15
     * Time: 09:30
     */

    namespace common\models;


    use yii\db\ActiveRecord;

    /**
     * Class APVendor
     * @package common\models
     *
     * @property integer $Vendor_Id
     * @property string $Vendor_Code
     * @property string $Company_Name
     * @property string $First_Name
     * @property string $Last_Name
     * @property string $Middle_Initial
     * @property string $Social_Security
     * @property string $Address_1
     * @property string $Address_2
     * @property string $Address_3
     * @property integer $GE_Table1_id
     * @property integer $GE_Table2_id
     * @property integer $GE_Table3_id
     * @property integer $GE_Table4_id
     * @property integer $GE_Table5_id
     * @property string $Zip_Code_Plus4
     * @property integer $Country_Id
     * @property string $Contact
     * @property string $Phone
     * @property string $Fax
     * @property string $Alternate_Phone
     * @property string $Alternate_Contact
     * @property integer $Pay_Form_Account_Id
     * @property integer $Term_Id
     * @property double $Credit_Limit
     * @property string $Federal_Tax_Id
     * @property string $Issue_1099
     * @property integer $Vendor_Type_id
     * @property double $Invoice_Balance
     * @property double $Credit_Balance
     * @property string $Inactive
     * @property string $Checks_Payable_To
     * @property string $CheckMemo
     * @property integer $Default_Account_Id
     * @property double $Default_Rate
     * @property string $Tax_Agency
     * @property integer $Branch_Id
     * @property integer $Category_Id
     * @property string $Pymt_Address_1
     * @property string $Pymt_Address_2
     * @property string $Pymt_Address_4
     * @property integer $Pymt_GE_Table1_Id
     * @property integer $Pymt_GE_Table2_Id
     * @property integer $Pymt_GE_Table3_Id
     * @property string $Pymt_Zip_Code_Plus4
     * @property string $GST_Exempt
     * @property string $GE1_Description
     * @property string $GE2_Description
     * @property string $GE2_Short
     * @property string $GE3_Description
     * @property string $GE4_Description
     * @property string $GE5_Description
     * @property string $Pymt_GE1_Description
     * @property string $Pymt_GE2_Description
     * @property string $Pymt_GE2_Short
     * @property string $Pymt_GE3_Description
     * @property string $Pymt_GE4_Description
     * @property string $Pymt_GE5_Description
     * @property string $Notes
     * @property string $Purchase_Order_Memo
     * @property integer $Currency_Id
     * @property string $Secure_Vendor
     *
     */
    class APVendor extends ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'AP_Vendor';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'Vendor_Id', 'Vendor_Code' ], 'required' ],
                [
                    [
                        'Vendor_Code',
                        'Company_Name',
                        'First_Name',
                        'Last_Name',
                        'Middle_Initial',
                        'Social_Security',
                        'Address_1',
                        'Address_2',
                        'Address_3',
                        'Zip_Code_Plus4',
                        'Contact',
                        'Phone',
                        'Fax',
                        'Alternate_Phone',
                        'Alternate_Contact',
                        'Federal_Tax_Id',
                        'Issue_1099',
                        'Inactive',
                        'Checks_Payable_To',
                        'CheckMemo',
                        'Tax_Agency',
                        'Pymt_Address_1',
                        'Pymt_Address_2',
                        'Pymt_Address_4',
                        'Pymt_Zip_Code_Plus4',
                        'GST_Exempt',
                        'GE1_Description',
                        'GE2_Description',
                        'GE2_Short',
                        'GE3_Description',
                        'GE4_Description',
                        'GE5_Description',
                        'Pymt_GE1_Description',
                        'Pymt_GE2_Description',
                        'Pymt_GE2_Short',
                        'Pymt_GE3_Description',
                        'Pymt_GE4_Description',
                        'Pymt_GE5_Description',
                        'Notes',
                        'Purchase_Order_Memo',
                        'Secure_Vendor'
                    ],
                    'string'
                ],
                [ [ 'Credit_Limit', 'Invoice_Balance', 'Credit_Balance', 'Default_Rate' ], 'number' ],
                [
                    [
                        'Vendor_Id',
                        'GE_Table1_id',
                        'GE_Table2_id',
                        'GE_Table3_id',
                        'GE_Table4_id',
                        'GE_Table5_id',
                        'Country_Id',
                        'Pay_Form_Account_Id',
                        'Term_Id',
                        'Vendor_Type_id',
                        'Default_Account_Id',
                        'Branch_Id',
                        'Category_Id',
                        'Pymt_GE_Table1_Id',
                        'Pymt_GE_Table2_Id',
                        'Pymt_GE_Table3_Id',
                        'Currency_Id'
                    ],
                    'integer'
                ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'Vendor_Id'            => 'Vendor_Id',
                'Vendor_Code'          => 'Vendor_Code',
                'Company_Name'         => 'Company_Name',
                'First_Name'           => 'First_Name',
                'Last_Name'            => 'Last_Name',
                'Middle_Initial'       => 'Middle_Initial',
                'Social_Security'      => 'Social_Security',
                'Address_1'            => 'Address_1',
                'Address_2'            => 'Address_2',
                'Address_3'            => 'Address_3',
                'GE_Table1_id'         => 'GE_Table1_id',
                'GE_Table2_id'         => 'GE_Table2_id',
                'GE_Table3_id'         => 'GE_Table3_id',
                'GE_Table4_id'         => 'GE_Table4_id',
                'GE_Table5_id'         => 'GE_Table5_id',
                'Zip_Code_Plus4'       => 'Zip_Code_Plus4',
                'Country_Id'           => 'Country_Id',
                'Contact'              => 'Contact',
                'Phone'                => 'Phone',
                'Fax'                  => 'Fax',
                'Alternate_Phone'      => 'Alternate_Phone',
                'Alternate_Contact'    => 'Alternate_Contact',
                'Pay_Form_Account_Id'  => 'Pay_Form_Account_Id',
                'Term_Id'              => 'Term_Id',
                'Credit_Limit'         => 'Credit_Limit',
                'Federal_Tax_Id'       => 'Federal_Tax_Id',
                'Issue_1099'           => 'Issue_1099',
                'Vendor_Type_id'       => 'Vendor_Type_id',
                'Invoice_Balance'      => 'Invoice_Balance',
                'Credit_Balance'       => 'Credit_Balance',
                'Inactive'             => 'Inactive',
                'Checks_Payable_To'    => 'Checks_Payable_To',
                'CheckMemo'            => 'CheckMemo',
                'Default_Account_Id'   => 'Default_Account_Id',
                'Default_Rate'         => 'Default_Rate',
                'Tax_Agency'           => 'Tax_Agency',
                'Branch_Id'            => 'Branch_Id',
                'Category_Id'          => 'Category_Id',
                'Pymt_Address_1'       => 'Pymt_Address_1',
                'Pymt_Address_2'       => 'Pymt_Address_2',
                'Pymt_Address_4'       => 'Pymt_Address_4',
                'Pymt_GE_Table1_Id'    => 'Pymt_GE_Table1_Id',
                'Pymt_GE_Table2_Id'    => 'Pymt_GE_Table2_Id',
                'Pymt_GE_Table3_Id'    => 'Pymt_GE_Table3_Id',
                'Pymt_Zip_Code_Plus4'  => 'Pymt_Zip_Code_Plus4',
                'GST_Exempt'           => 'GST_Exempt',
                'GE1_Description'      => 'GE1_Description',
                'GE2_Description'      => 'GE2_Description',
                'GE2_Short'            => 'GE2_Short',
                'GE3_Description'      => 'GE3_Description',
                'GE4_Description'      => 'GE4_Description',
                'GE5_Description'      => 'GE5_Description',
                'Pymt_GE1_Description' => 'Pymt_GE1_Description',
                'Pymt_GE2_Description' => 'Pymt_GE2_Description',
                'Pymt_GE2_Short'       => 'Pymt_GE2_Short',
                'Pymt_GE3_Description' => 'Pymt_GE3_Description',
                'Pymt_GE4_Description' => 'Pymt_GE4_Description',
                'Pymt_GE5_Description' => 'Pymt_GE5_Description',
                'Notes'                => 'Notes',
                'Purchase_Order_Memo'  => 'Purchase_Order_Memo',
                'Currency_Id'          => 'Currency_Id',
                'Secure_Vendor'        => 'Secure_Vendor'
            ];
        }
    }




