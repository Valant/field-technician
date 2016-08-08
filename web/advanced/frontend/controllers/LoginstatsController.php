<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 8/8/16
     * Time: 14:32
     */

    namespace frontend\controllers;


    use yii\filters\auth\QueryParamAuth;
    use yii\rest\ActiveController;

    class LoginstatsController extends ActiveController{
        public $modelClass = 'common\models\LoginStats';

        public function behaviors()
        {
            $behaviors                  = parent::behaviors();
            $behaviors['authenticator'] = [
              'class'  => QueryParamAuth::className()
            ];
            return $behaviors;
        }
    }