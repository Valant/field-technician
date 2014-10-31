<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 06.10.14
     * Time: 13:44
     */

    namespace frontend\controllers;

    use Yii;
    use common\models\Task;
    use yii\rest\ActiveController;


    class TaskController extends ActiveController {
        public $modelClass = 'common\models\Task';

    }