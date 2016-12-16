<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "login_stats".
 *
 * @property integer $id
 * @property string $login_time
 * @property string $logout_time
 * @property integer $user_id
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
            [['login_time', 'logout_time', 'user', 'username'], 'safe'],
            [['user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login_time' => 'Login Time',
            'logout_time' => 'Logout Time',
            'user_id' => 'User ID',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getUsername(){
        return isset($this->user->username)?$this->user->username:"";
    }

    public function beforeSave($insert) {
        if(parent::beforeSave($insert)){
            if($insert){
                if(!$this->user_id){
                    $this->user_id = \Yii::$app->getUser()->id;
                }
            }
            return true;
        }
    }

}
