<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "AR_Customer_Bill".
     *
     * @property integer $Customer_Bill_Id
     * @property integer $Customer_Id
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
     * @property string $GE1_Description
     * @property string $GE2_Description
     * @property string $GE2_Short
     * @property string $GE3_Description
     * @property string $GE4_Description
     * @property string $GE5_Description
     * @property string $Is_Primary
     * @property string $Inactive
     * @property integer $Branch_Id
     * @property string $Email_Invoice
     * @property string $Business_Name_2
     */
    class ARCustomerBill extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'AR_Customer_Bill';
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
                        'GE_Table1_Id',
                        'GE_Table2_Id',
                        'GE_Table3_Id',
                        'GE_Table4_Id',
                        'GE_Table5_Id',
                        'Country_Id',
                        'Branch_Id'
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
                        'GE1_Description',
                        'GE2_Description',
                        'GE2_Short',
                        'GE3_Description',
                        'GE4_Description',
                        'GE5_Description',
                        'Is_Primary',
                        'Inactive',
                        'Email_Invoice',
                        'Business_Name_2'
                    ],
                    'string'
                ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'Customer_Bill_Id' => 'Customer  Bill  ID',
                'Customer_Id'      => 'Customer  ID',
                'Commercial'       => 'Commercial',
                'Honorific'        => 'Honorific',
                'First_Name'       => 'First  Name',
                'Last_Name'        => 'Last  Name',
                'Middle_Initial'   => 'Middle  Initial',
                'Business_Name'    => 'Business  Name',
                'Address_1'        => 'Address 1',
                'Address_2'        => 'Address 2',
                'Address_3'        => 'Address 3',
                'GE_Table1_Id'     => 'Ge  Table1  ID',
                'GE_Table2_Id'     => 'Ge  Table2  ID',
                'GE_Table3_Id'     => 'Ge  Table3  ID',
                'GE_Table4_Id'     => 'Ge  Table4  ID',
                'GE_Table5_Id'     => 'Ge  Table5  ID',
                'Zip_Code_Plus4'   => 'Zip  Code  Plus4',
                'Country_Id'       => 'Country  ID',
                'Phone_1'          => 'Phone 1',
                'Phone_2'          => 'Phone 2',
                'Fax'              => 'Fax',
                'E_Mail'           => 'E  Mail',
                'GE1_Description'  => 'Ge1  Description',
                'GE2_Description'  => 'Ge2  Description',
                'GE2_Short'        => 'Ge2  Short',
                'GE3_Description'  => 'Ge3  Description',
                'GE4_Description'  => 'Ge4  Description',
                'GE5_Description'  => 'Ge5  Description',
                'Is_Primary'       => 'Is  Primary',
                'Inactive'         => 'Inactive',
                'Branch_Id'        => 'Branch  ID',
                'Email_Invoice'    => 'Email  Invoice',
                'Business_Name_2'  => 'Business  Name 2',
            ];
        }
    }
