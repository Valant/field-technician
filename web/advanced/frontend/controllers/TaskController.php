<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 06.10.14
     * Time: 13:44
     */

    namespace frontend\controllers;

    use Yii;
    use yii\rest\ActiveController;
    use yii\filters\auth\QueryParamAuth;



    class TaskController extends ActiveController
    {
        public $modelClass = 'common\models\Task';

        public function behaviors()
        {
            $behaviors = parent::behaviors();
            $behaviors['authenticator'] = [
                'class' => QueryParamAuth::className(),
            ];
            return $behaviors;
        }

    }