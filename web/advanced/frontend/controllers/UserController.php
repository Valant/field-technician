<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 17.11.14
     * Time: 10:57
     */

    namespace frontend\controllers;

    use Yii;
    use yii\filters\auth\QueryParamAuth;
    use yii\rest\ActiveController;
    use common\models\LoginForm;




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

        public function behaviors()
        {
            $behaviors = parent::behaviors();
            $behaviors['authenticator'] = [
                'class' => QueryParamAuth::className(),
                'except'=>['login']
            ];
            return $behaviors;
        }
    }