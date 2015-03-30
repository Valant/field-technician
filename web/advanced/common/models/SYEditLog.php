<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SY_Edit_Log".
 *
 * @property integer $Edit_Log_Id
 * @property string $UserCode
 * @property string $Edit_Timestamp
 * @property string $TableName
 * @property string $Edit_Type_AUD
 * @property string $KeyField
 * @property string $KeyData
 * @property string $UserComments
 * @property string $SystemComments
 * @property string $Edit_Column_Name
 * @property string $OldData
 * @property string $NewData
 */
class SYEditLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SY_Edit_Log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['UserCode', 'TableName', 'Edit_Type_AUD', 'KeyField', 'KeyData', 'UserComments', 'SystemComments', 'Edit_Column_Name', 'OldData', 'NewData'], 'string'],
            [['Edit_Timestamp'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Edit_Log_Id' => 'Edit  Log  ID',
            'UserCode' => 'User Code',
            'Edit_Timestamp' => 'Edit  Timestamp',
            'TableName' => 'Table Name',
            'Edit_Type_AUD' => 'Edit  Type  Aud',
            'KeyField' => 'Key Field',
            'KeyData' => 'Key Data',
            'UserComments' => 'User Comments',
            'SystemComments' => 'System Comments',
            'Edit_Column_Name' => 'Edit  Column  Name',
            'OldData' => 'Old Data',
            'NewData' => 'New Data',
        ];
    }
}
