<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "AR_Category".
     *
     * @property integer $Category_Id
     * @property string $Category_Code
     * @property string $Description
     * @property string $Inactive
     * @property string $GL_Code
     */
    class ARCategory extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'AR_Category';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'Category_Code', 'Description', 'Inactive', 'GL_Code' ], 'string' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'Category_Id'   => 'Category  ID',
                'Category_Code' => 'Category  Code',
                'Description'   => 'Description',
                'Inactive'      => 'Inactive',
                'GL_Code'       => 'Gl  Code',
            ];
        }
    }
