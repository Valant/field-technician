<?php

    namespace frontend\controllers;

    use common\models\TaskHistory;

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
    }
