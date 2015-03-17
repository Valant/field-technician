<?php
/**
 * Created by PhpStorm.
 * User: godson
 * Date: 24.11.14
 * Time: 12:42
 */

namespace frontend\controllers;

use common\models\INPart;
use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;

use yii\data\ActiveDataProvider;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;


class PartController extends ActiveController{
    public $modelClass = 'common\models\INPart';

    public function actionSearch($code){
       if($part = INPart::findOne(array('Part_Code'=>$code))){
           return $part;
       }else{
           return ['status'=>'error'];
       }
    }
    public function actionCodesearch($code){
        $res = INPart::find()->where("CONVERT(varchar(11), Part_Code) like :code", array(':code'=>$code.'%'));
        return $res->all();
    }
    public function actionKeyword($code){
    $res = INPart::find()
        ->where("Description like :code", array(':code'=>'%'.$code.'%'))
        ->orWhere("Detail like :code", array(':code'=>'%'.$code.'%'))
    ;

    return $res->all();
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className()
        ];
        return $behaviors;
    }
} 