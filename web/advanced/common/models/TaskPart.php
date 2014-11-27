<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_part".
 *
 * @property integer $id
 * @property integer $tech_id
 * @property integer $task_id
 * @property string $part_id
 * @property integer $count
 * @property string $created_at
 */
class TaskPart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_part';
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
            [['tech_id', 'task_id'], 'required'],
            [['tech_id', 'task_id', 'count'], 'integer'],
            [['created_at'], 'safe'],
            [['part_id'], 'string', 'max' => 255],
            [['task_id', 'part_id'], 'unique', 'targetAttribute' => ['task_id', 'part_id'], 'message' => 'The combination of Task ID and Part ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tech_id' => 'Tech ID',
            'task_id' => 'Task ID',
            'part_id' => 'Part ID',
            'count' => 'Count',
            'created_at' => 'Created At',
        ];
    }

    public function getPart(){
        return $this->hasOne( INPart::className(), [ 'Part_Id' => 'part_id' ] );
    }

    public function extraFields()
    {
        return ['part'];
    }
}
