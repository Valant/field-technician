<?php
/**
 * Created by PhpStorm.
 * User: godson
 * Date: 27.11.14
 * Time: 11:38
 */

namespace frontend\controllers;


use common\models\TaskPart;
use yii\filters\auth\QueryParamAuth;


class TaskpartController extends \yii\rest\ActiveController {
    public $modelClass = 'common\models\SVServiceTicketParts';


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
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }
} 