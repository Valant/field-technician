<?php

    namespace common\models;

    use Yii;
    use yii\web\UploadedFile;


    /**
     * This is the model class for table "task_attachment".
     *
     * @property integer $id
     * @property integer $task_id
     * @property integer $tech_id
     * @property string $path
     * @property string $name
     * @property string $sign_name
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
                [['tech_id'], 'integer'],
                [['path'], 'file'],
                [['name', 'sign_name'], 'string', 'max' => 255]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'        => 'ID',
                'task_id'   => 'Task ID',
                '$tech_id'   => 'Tech ID',
                'path'      => 'Path',
                'name'      => 'Name',
                'sign_name' => 'Sign Name',
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
                $filePath = Yii::getAlias(Yii::$app->params['filePath']) . $fileUrl . $this->path;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                return true;
            } else {
                return false;
            }
        }

        public function getTask()
        {
            return $this->hasOne(SVServiceTicket::className(), ['Service_Ticket_Id' => 'task_id']);
        }

        public function beforeSave($insert) {
            $this->tech_id = Yii::$app->user->getIdentity()->technition_id;
            return parent::beforeSave($insert);
        }
    }
