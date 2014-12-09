<?php

    namespace frontend\controllers;

    use common\models\TaskHistory;
    use yii\filters\auth\QueryParamAuth;


    class TaskhistoryController extends \yii\rest\ActiveController
    {
        public $modelClass = 'common\models\TaskHistory';

        public function actionSearch( $task_id, $tech_id, $status )
        {
            if ($history = TaskHistory::findOne( [
                    'task_id' => $task_id,
                    'tech_id' => $tech_id,
                    'status'  => $status
                ] )
            ) {
                return $history;
            } else {
                return [ 'status' => 'error' ];
            }
        }
        public function behaviors()
        {
            $behaviors = parent::behaviors();
            $behaviors['authenticator'] = [
                'class' => QueryParamAuth::className(),
            ];
            return $behaviors;
        }
    }
