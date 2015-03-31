<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SS_LockTable".
 *
 * @property integer $LockTable_Id
 * @property string $Table_Name
 * @property string $Code
 * @property string $LockedByUser
 * @property string $LockedTime
 * @property string $Form
 * @property string $Description
 * @property string $Table_Or_Process
 * @property integer $Application_Id
 */
class SSLockTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SS_LockTable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Table_Name', 'Code', 'LockedByUser', 'Form', 'Description', 'Table_Or_Process'], 'string'],
            [['LockedTime'], 'safe'],
            [['Application_Id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'LockTable_Id' => 'Lock Table  ID',
            'Table_Name' => 'Table  Name',
            'Code' => 'Code',
            'LockedByUser' => 'Locked By User',
            'LockedTime' => 'Locked Time',
            'Form' => 'Form',
            'Description' => 'Description',
            'Table_Or_Process' => 'Table  Or  Process',
            'Application_Id' => 'Application  ID',
        ];
    }
}
