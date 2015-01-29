<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "GL_Account".
     *
     * @property integer $Account_Id
     * @property string $Account_Code
     * @property string $Description
     * @property integer $Account_Type_Id
     * @property string $Current_Balance
     * @property string $Last_Ending_Balance
     * @property string $Inactive
     * @property integer $Vendor_Id
     */
    class GLAccount extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'GL_Account';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'Account_Code', 'Description', 'Inactive' ], 'string' ],
                [ [ 'Account_Type_Id', 'Vendor_Id' ], 'integer' ],
                [ [ 'Current_Balance', 'Last_Ending_Balance' ], 'number' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'Account_Id'          => 'Account  ID',
                'Account_Code'        => 'Account  Code',
                'Description'         => 'Description',
                'Account_Type_Id'     => 'Account  Type  ID',
                'Current_Balance'     => 'Current  Balance',
                'Last_Ending_Balance' => 'Last  Ending  Balance',
                'Inactive'            => 'Inactive',
                'Vendor_Id'           => 'Vendor  ID',
            ];
        }
    }
