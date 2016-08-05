<?php

namespace common\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "login_stats".
 *
 * @property integer $id
 * @property string $user
 * @property integer $type
 * @property string $time
 */
class LoginStats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login_stats';
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
            [['type'], 'integer'],
            [['time'], 'safe'],
            [['user'], 'string', 'max' => 100],
            [['time'],'default','value'=>time(),'isEmpty'=>true,'on'=>'insert'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'type' => 'Type',
            'time' => 'Time',
        ];
    }


}
