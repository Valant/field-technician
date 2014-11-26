<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 17.11.14
     * Time: 10:57
     */

    namespace frontend\controllers;

    use Yii;
    use yii\rest\ActiveController;
    use common\models\LoginForm;
    use yii\filters\Cors;
    use yii\helpers\ArrayHelper;


    class UserController extends ActiveController
    {
        public $modelClass = 'common\models\User';

        public function actionLogin()
        {

            $model = new LoginForm();
            if ($model->load( Yii::$app->request->post() ) && $model->login()) {
                return $model->getUser();
            } else {
                return [ 'status' => 'error', 'message' => $model->getErrors() ];
            }
        }

        public function behaviors(){
            return  ArrayHelper::merge([[
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'PUT','GET','DELETE'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Headers' => ['X-Wsse'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                ],
            ]],parent::behaviors());
        }
    }