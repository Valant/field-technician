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

class DispatchController extends ActiveController {
    public $modelClass = 'common\models\SVServiceTicketDispatch';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }
}