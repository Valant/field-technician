<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "SV_Resolution".
     *
     * @property integer $Resolution_Id
     * @property string $Resolution_Code
     * @property string $Description
     * @property string $Billable
     * @property string $Inactive
     * @property integer $Send_To_FSU
     */
    class SVResolution extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'SV_Resolution';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'Resolution_Code', 'Description', 'Billable', 'Inactive' ], 'string' ],
                [ [ 'Send_To_FSU' ], 'integer' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'Resolution_Id'   => 'Resolution  ID',
                'Resolution_Code' => 'Resolution  Code',
                'Description'     => 'Description',
                'Billable'        => 'Billable',
                'Inactive'        => 'Inactive',
                'Send_To_FSU'     => 'Send  To  Fsu',
            ];
        }
    }
