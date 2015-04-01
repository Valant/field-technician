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
        $res = SSLockTable::find("LockedTime > (CURRENT_TIMESTAMP - 300) and Form = 'mobile'");
        var_dump($res);die;
        echo "cron service runnning";
    }

}