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

class PartController extends ActiveController{
    public $modelClass = 'common\models\INPart';

    public function actionSearch($code){
       return INPart::findOne(array('Manufacturer_Part_Code'=>$code));
    }
} 