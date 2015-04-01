<?php

namespace console\controllers;

use common\models\SSLockTable;
use yii\console\Controller;

/**
 * SSLockTable clear
 */
class SSLockController extends Controller {
    /**
     *
     */
    public function actionIndex() {return;}
    public function actionClear() {
        SSLockTable::deleteAll( "LockedTime > (CURRENT_TIMESTAMP - 300) and Form = 'mobile'" );
    }

}