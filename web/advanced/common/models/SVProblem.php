<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "SV_Problem".
     *
     * @property integer $Problem_Id
     * @property string $Problem_Code
     * @property string $Description
     * @property integer $Estimated_Time
     * @property string $Inactive
     * @property integer $Priority_Id
     * @property integer $Expertise_Level
     * @property string $Is_Master
     * @property string $Use_SedonaWeb
     */
    class SVProblem extends \yii\db\ActiveRecord {
        /**
         * @inheritdoc
         */
        public static function tableName() {
            return 'SV_Problem';
        }

        /**
         * @inheritdoc
         */
        public function rules() {
            return [
                [ [ 'Problem_Code', 'Description', 'Inactive', 'Is_Master', 'Use_SedonaWeb' ], 'string' ],
                [ [ 'Estimated_Time', 'Priority_Id', 'Expertise_Level' ], 'integer' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels() {
            return [
                'Problem_Id'      => 'Problem  ID',
                'Problem_Code'    => 'Problem  Code',
                'Description'     => 'Description',
                'Estimated_Time'  => 'Estimated  Time',
                'Inactive'        => 'Inactive',
                'Priority_Id'     => 'Priority  ID',
                'Expertise_Level' => 'Expertise  Level',
                'Is_Master'       => 'Is  Master',
                'Use_SedonaWeb'   => 'Use  Sedona Web',
            ];
        }
    }
