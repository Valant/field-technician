<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "SV_Service_Tech_Routes".
     *
     * @property integer $Service_Tech_Route_Id
     * @property integer $Service_Tech_Id
     * @property integer $Route_Id
     */
    class SVServiceTechRoutes extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'SV_Service_Tech_Routes';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'Service_Tech_Id', 'Route_Id' ], 'integer' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'Service_Tech_Route_Id' => 'Service  Tech  Route  ID',
                'Service_Tech_Id'       => 'Service  Tech  ID',
                'Route_Id'              => 'Route  ID',
            ];
        }
    }
