<?php
/**
 * Created by PhpStorm.
 * User: godson
 * Date: 27.11.14
 * Time: 11:38
 */

namespace frontend\controllers;


use common\models\TaskPart;

class TaskpartController extends \yii\rest\ActiveController {
    public $modelClass = 'common\models\TaskPart';

//    public function actionSearch($task_id){
//        $taskParts = TaskPart::findAll(['task_id'=>$task_id]);
//        return $taskParts;
//    }

    public function actions() {

        $actions = [
            'search' => [
                'class'       => 'frontend\controllers\Taskpart\SearchAction',
                'modelClass'  => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'params'      => \Yii::$app->request->get()
            ],
        ];

        return array_merge(parent::actions(), $actions);
    }

    public function verbs() {

        $verbs = [
            'search'   => ['GET']
        ];
        return array_merge(parent::verbs(), $verbs);
    }
} 