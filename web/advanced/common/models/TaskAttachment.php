<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_attachment".
 *
 * @property integer $id
 * @property integer $task_id
 * @property string $path
 * @property string $name
 */
class TaskAttachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['task_id'], 'integer'],
            [['path'], 'string', 'max' => 400],
            [['name'], 'string', 'max' => 255]
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
            'path' => 'Path',
            'name' => 'Name',
        ];
    }
}
