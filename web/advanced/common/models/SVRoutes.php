<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "SV_Routes".
     *
     * @property integer $Route_Id
     * @property string $Route_Code
     * @property string $Description
     * @property string $Inactive
     * @property integer $Inspection_Route
     * @property integer $Service_Route
     */
    class SVRoutes extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'SV_Routes';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'Route_Code', 'Description', 'Inactive' ], 'string' ],
                [ [ 'Inspection_Route', 'Service_Route' ], 'integer' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'Route_Id'         => 'Route  ID',
                'Route_Code'       => 'Route  Code',
                'Description'      => 'Description',
                'Inactive'         => 'Inactive',
                'Inspection_Route' => 'Inspection  Route',
                'Service_Route'    => 'Service  Route',
            ];
        }
    }
