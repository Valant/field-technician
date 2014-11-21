<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "task".
     *
     * @property integer $id
     * @property string $name
     * @property string $address
     * @property string $city
     * @property string $description
     * @property string $status
     * @property string $time
     * @property integer $user_id
     */
    class Task extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'task';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'address' ], 'required' ],
                [ [ 'address', 'description' ], 'string' ],
                [ [ 'time' ], 'safe' ],
                [ [ 'user_id' ], 'integer' ],
                [ [ 'name', 'city', 'status' ], 'string', 'max' => 255 ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'          => 'ID',
                'name'        => 'Name',
                'address'     => 'Address',
                'city'        => 'City',
                'description' => 'Description',
                'status'      => 'Status',
                'time'        => 'Time',
                'user_id'     => 'User ID',
            ];
        }
    }
