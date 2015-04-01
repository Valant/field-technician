<?php

namespace console\controllers;

use common\models\SSLockTable;
use yii\console\Controller;

/**
 * SSLockTable clear
 */
class SSLockController extends Controller {

    public function actionIndex()
    {
        SSLockTable::deleteAll( "LockedTime < DATEADD(n, -5, GETDATE()) and Form = 'mobile'" );
    }


}