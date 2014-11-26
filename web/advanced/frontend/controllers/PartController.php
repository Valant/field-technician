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
use yii\data\ActiveDataProvider;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;


class PartController extends ActiveController{
    public $modelClass = 'common\models\INPart';

    public function actionSearch($code){
       if($part = INPart::findOne(array('Manufacturer_Part_Code'=>$code))){
           return $part;
       }else{
           return ['status'=>'error'];
       }
    }

    public function behaviors(){
        return  ArrayHelper::merge([[
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // restrict access to
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['POST', 'PUT','GET','DELETE'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Headers' => ['X-Wsse'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Allow-Credentials' => true,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 3600,
            ],
        ]],parent::behaviors());
    }
} 