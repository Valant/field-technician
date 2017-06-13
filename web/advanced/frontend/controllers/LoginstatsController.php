<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 8/8/16
     * Time: 14:32
     */

    namespace frontend\controllers;


    use common\models\LoginStats;
    use yii\db\Exception;
    use yii\db\Expression;
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

        public function actionLogout(){
            if($stat_id = \Yii::$app->request->post("stat_id")){
                if($stat = LoginStats::findOne($stat_id)){
                    $stat->login_time = $stat->login_time;
                    $stat->logout_time = new Expression("NOW()");
                    $stat->save();
                    $stat->refresh();
                    return $stat;
                }
            }
        }
    }