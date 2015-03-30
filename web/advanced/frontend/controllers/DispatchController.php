<?php
/**
 * Created by PhpStorm.
 * User: godson
 * Date: 12/12/14
 * Time: 14:37
 */

namespace frontend\controllers;

use common\behaviors\SYEditLog;
use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;

class DispatchController extends ActiveController {
    public $modelClass = 'common\models\SVServiceTicketDispatch';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        $behaviors['syeditlogger'] = [
            'class' => SYEditLog::className()
        ];
        return $behaviors;
    }
    public function actions()
    {

        $actions = [
            'update' => [
                'class' => 'frontend\controllers\Dispatch\UpdateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->updateScenario,
            ],
        ];

        return array_merge( parent::actions(), $actions );
    }

}