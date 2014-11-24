<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_history".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $tech_id
 * @property string $status
 * @property string $created_at
 */
class TaskHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_history';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mysql');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'tech_id'], 'required'],
            [['task_id', 'tech_id'], 'integer'],
            [['created_at'], 'safe'],
            [['status'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'tech_id' => 'Tech ID',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
