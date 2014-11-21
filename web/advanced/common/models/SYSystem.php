<?php

	namespace common\models;

	use Yii;

	/**
	 * This is the model class for table "SY_System".
	 *
	 * @property integer $System_Id
	 * @property string $System_Code
	 * @property string $Description
	 * @property string $Inactive
	 * @property integer $Route_Id
	 */
	class SYSystem extends \yii\db\ActiveRecord
	{
		/**
		 * @inheritdoc
		 */
		public static function tableName()
		{
			return 'SY_System';
		}

		/**
		 * @inheritdoc
		 */
		public function rules()
		{
			return [
				[ [ 'System_Code' ], 'required' ],
				[ [ 'System_Code', 'Description', 'Inactive' ], 'string' ],
				[ [ 'Route_Id' ], 'integer' ]
			];
		}

		/**
		 * @inheritdoc
		 */
		public function attributeLabels()
		{
			return [
				'System_Id'   => 'System  ID',
				'System_Code' => 'System  Code',
				'Description' => 'Description',
				'Inactive'    => 'Inactive',
				'Route_Id'    => 'Route  ID',
			];
		}
	}
