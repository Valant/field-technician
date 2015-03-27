<?php
/**
 * Created by PhpStorm.
 * User: godson
 * Date: 12/12/14
 * Time: 14:37
 */

namespace frontend\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;

class ResolutionController extends ActiveController {
    public $modelClass = 'common\models\SVResolution';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }
    public function actions() {

        $actions = [
            'index' => [
                'class' => 'frontend\controllers\Resolution\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
        ];

        return array_merge(parent::actions(), $actions);
    }
}