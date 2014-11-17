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


    class UserController extends ActiveController {
        public $modelClass = 'common\models\User';

        public function actionLogin() {

            $model = new LoginForm();
            $model->load( Yii::$app->request->post() );
            $model->login();

            return $model->getUser();
        }
    }