<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "SY_Panel_Type".
     *
     * @property integer $Panel_Type_Id
     * @property string $Panel_Type_Code
     * @property string $Description
     * @property string $Inactive
     */
    class SYPanelType extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'SY_Panel_Type';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'Panel_Type_Code' ], 'required' ],
                [ [ 'Panel_Type_Code', 'Description', 'Inactive' ], 'string' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'Panel_Type_Id'   => 'Panel  Type  ID',
                'Panel_Type_Code' => 'Panel  Type  Code',
                'Description'     => 'Description',
                'Inactive'        => 'Inactive',
            ];
        }
    }
