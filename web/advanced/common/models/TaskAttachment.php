<?php

    namespace common\models;

    use Yii;
    use yii\web\UploadedFile;


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
                [ [ 'task_id' ], 'required' ],
                [ [ 'task_id' ], 'integer' ],
                [ [ 'path' ], 'file' ],
                [ [ 'name' ], 'string', 'max' => 255 ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'      => 'ID',
                'task_id' => 'Task ID',
                'path'    => 'Path',
                'name'    => 'Name',
            ];
        }

        public static function getDb()
        {
            return \Yii::$app->db_mysql;
        }

        public function beforeDelete()
        {
            if (parent::beforeDelete()) {
                $fileUrl  = "/web/uploads/" . $this->task_id . "/";
                $filePath = Yii::getAlias( Yii::$app->params['filePath'] ) . $fileUrl . $this->path;
                if(file_exists($filePath)){
                    unlink($filePath);
                }
                return true;
            } else {
                return false;
            }
        }
    }
