<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "AR_Branch".
     *
     * @property integer $Branch_Id
     * @property string $Branch_Code
     * @property string $Description
     * @property integer $Last_Cycle_Id
     * @property string $Inactive
     * @property integer $AlternateAddress_Id
     * @property string $GL_Code
     * @property string $ACH_Direct_MerchantId
     */
    class ARBranch extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'AR_Branch';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'Branch_Code', 'Description', 'Inactive', 'GL_Code', 'ACH_Direct_MerchantId', 'q' ], 'string' ],
                [ [ 'Last_Cycle_Id', 'AlternateAddress_Id' ], 'integer' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'Branch_Id'             => 'Branch  ID',
                'Branch_Code'           => 'Branch  Code',
                'Description'           => 'Description',
                'Last_Cycle_Id'         => 'Last  Cycle  ID',
                'Inactive'              => 'Inactive',
                'AlternateAddress_Id'   => 'Alternate Address  ID',
                'GL_Code'               => 'Gl  Code',
                'ACH_Direct_MerchantId' => 'Ach  Direct  Merchant ID',
            ];
        }
    }
