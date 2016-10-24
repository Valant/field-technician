<?php

    namespace common\models;

    use Yii;
    use yii\base\Exception;
    use yii\base\NotSupportedException;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;
    use yii\web\IdentityInterface;
    use yii\db\Expression;

    /**
     * This is the model class for table "user".
     *
     * @property integer $id
     * @property string $username
     * @property string $auth_key
     * @property string $password_hash
     * @property string $password_reset_token
     * @property string $email
     * @property integer $role
     * @property integer $status
     * @property integer $created_at
     * @property integer $updated_at
     * @property integer $technition_id
     */
    class User extends ActiveRecord implements IdentityInterface
    {


        const STATUS_DELETED = 0;
        const STATUS_ACTIVE = 10;
        
        const ROLE_USER = 10;
        const ROLE_ADMIN = 20;
        
        public static $roleLabels = [
            self::ROLE_USER => 'User',
            self::ROLE_ADMIN => 'Admin'
        ];
        
        public static $roleAccess = [
            'app-frontend' => self::ROLE_USER,
            'app-backend' => self::ROLE_ADMIN
        ];
        
        public function validateRole() 
        {
            return self::$roleAccess[Yii::$app->id] === $this->role;
        }

        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'user';
        }

        /**
         * @return \yii\db\Connection the database connection used by this AR class.
         */
        public static function getDb()
        {
            return Yii::$app->get( 'db_mysql' );
        }

        /**
         * @inheritdoc
         */
        public function behaviors()
        {
            return [
                [
                    'class'              => TimestampBehavior::className(),
                    'createdAtAttribute' => 'created_at',
                    'updatedAtAttribute' => 'updated_at',
                    'value'              => new Expression( 'NOW()' )
                ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'username',  'password_hash', 'email' ], 'required', 'on'=>'create' ],
                [ [ 'username',  'email' ], 'required', 'on'=>'update' ],
                [ [ 'role', 'status', 'technition_id','branch_id' ], 'integer' ],
                [ [ 'username', 'password_hash', 'password_reset_token', 'email', 'userCode' ], 'string', 'max' => 255 ],
                [ [ 'auth_key' ], 'string', 'max' => 32 ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'                   => 'ID',
                'username'             => 'Username',
                'auth_key'             => 'Auth Key',
                'password_hash'        => 'Password Hash',
                'password_reset_token' => 'Password Reset Token',
                'email'                => 'Email',
                'role'                 => 'Role',
                'status'               => 'Status',
                'created_at'           => 'Created At',
                'updated_at'           => 'Updated At',
                'technition_id'        => 'Technician ID',
            ];
        }


        public static function findIdentity( $id )
        {
            return static::findOne( [ 'id' => $id, 'status' => self::STATUS_ACTIVE ] );
        }

        /**
         * @inheritdoc
         */
        public static function findIdentityByAccessToken($token, $type = null)
        {
            return static::findOne(['auth_key' => $token]);
        }

        /**
         * Finds user by username
         *
         * @param string $username
         *
         * @return static|null
         */
        public static function findByUsername( $username )
        {
            return static::findOne( [ 'username' => $username, 'status' => self::STATUS_ACTIVE ] );
        }

        /**
         * Finds user by password reset token
         *
         * @param string $token password reset token
         *
         * @return static|null
         */
        public static function findByPasswordResetToken( $token )
        {
            $expire    = Yii::$app->params['user.passwordResetTokenExpire'];
            $parts     = explode( '_', $token );
            $timestamp = (int) end( $parts );
            if ($timestamp + $expire < time()) {
                // token expired
                return null;
            }

            return static::findOne( [
                'password_reset_token' => $token,
                'status'               => self::STATUS_ACTIVE,
            ] );
        }

        /**
         * @inheritdoc
         */
        public function getId()
        {
            return $this->getPrimaryKey();
        }

        /**
         * @inheritdoc
         */
        public function getAuthKey()
        {
            return $this->auth_key;
        }

        /**
         * @inheritdoc
         */
        public function validateAuthKey( $authKey )
        {
            return $this->getAuthKey() === $authKey;
        }

        /**
         * Validates password
         *
         * @param string $password password to validate
         *
         * @return boolean if password provided is valid for current user
         */
        public function validatePassword( $password )
        {
            return Yii::$app->security->validatePassword( $password, $this->password_hash );
        }

        /**
         * Generates password hash from password and sets it to the model
         *
         * @param string $password
         */
        public function setPassword( $password )
        {
            $this->password_hash = Yii::$app->security->generatePasswordHash( $password );
        }

        /**
         * Generates "remember me" authentication key
         */
        public function generateAuthKey()
        {
            $this->auth_key = Yii::$app->security->generateRandomString();
        }

        /**
         * Generates new password reset token
         */
        public function generatePasswordResetToken()
        {
            $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
        }

        /**
         * Removes password reset token
         */
        public function removePasswordResetToken()
        {
            $this->password_reset_token = null;
        }

        public function beforeSave($insert){

            if($insert) {
                $this->setPassword( $this->password_hash );
                $this->generateAuthKey();
            }else{
                if($this->auth_key == ""){
                    $this->generateAuthKey();
                }
                if($this->created_at == ""){
                    $this->created_at = new Exception("NOW()");
                }
                if($this->password_hash == ""){
                    unset($this->password_hash);
                }else{
                    if($this->password_hash != $this->getOldAttribute('password_hash')) {
                        $this->setPassword( $this->password_hash );
                    }
                }
            }
            return parent::beforeSave($insert);
        }

        public function getTechnition(){
            return $this->hasOne( SVServiceTech::className(), [ 'Service_Tech_ID' => 'technition_id'  ] );
        }

        public function getTechnitionName(){
            if($this->technition) {
                return $this->technition->employee->First_Name . " " . $this->technition->employee->Last_Name;
            }
        }
        public function getUserCode(){
            if($this->technition) {
                return $this->technition->employee->UserCode;
            }
        }
        public function getBranch(){
            return $this->hasOne(Branches::className(),['id'=>'branch_id']);
        }
        public function extraFields()
        {
            return ['technition'];
        }
        public function fields()
        {
            $fields = parent::fields();

            $fields['usercode'] = function(){
                return $this->technition->employee->UserCode;
            };
            $fields['warehoise_id'] = function(){
                return $this->technition->Warehouse_Id;
            };
            $fields['warehouse_code'] = function(){
                return $this->technition->warehouse->Warehouse_Code;
            };
            $fields['servicetechcode'] = function(){
                return $this->technition->employee->Employee_Code;
            };
            return $fields;
        }
    }
