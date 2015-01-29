<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 06.10.14
     * Time: 13:44
     */

    namespace frontend\controllers;

    use Yii;
    use yii\rest\ActiveController;


    class BranchController extends ActiveController
    {
        public $modelClass = 'common\models\ARBranch';

        public function actions()
        {

            $actions = [
                'search' => [
                    'class'       => 'frontend\controllers\Branch\SearchAction',
                    'modelClass'  => $this->modelClass,
                    'checkAccess' => [ $this, 'checkAccess' ],
                    'params'      => \Yii::$app->request->get()
                ],
            ];

            return array_merge( parent::actions(), $actions );
        }

    }