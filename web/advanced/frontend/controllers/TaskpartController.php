<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 27.11.14
     * Time: 11:38
     */

    namespace frontend\controllers;


    use common\behaviors\SSLock;
    use common\models\SVServiceTicketParts;
    use common\models\TaskPart;
    use yii\filters\auth\QueryParamAuth;
    use common\behaviors\SYEditLog;



    class TaskpartController extends \yii\rest\ActiveController {
        public $modelClass = 'common\models\SVServiceTicketParts';


        public function actions() {

            $actions = [
                'search' => [
                    'class'       => 'frontend\controllers\Taskpart\SearchAction',
                    'modelClass'  => $this->modelClass,
                    'checkAccess' => [$this, 'checkAccess'],
                    'params'      => \Yii::$app->request->get()
                ],
                'create' => [
                    'class'       => 'frontend\controllers\Taskpart\CreateAction',
                    'modelClass'  => $this->modelClass,
                    'checkAccess' => [$this, 'checkAccess'],
                    'params'      => \Yii::$app->request->post()
                ],
                'update' => [
                  'class'       => 'frontend\controllers\Taskpart\UpdateAction',
                  'modelClass'  => $this->modelClass,
                  'checkAccess' => [$this, 'checkAccess'],
                  'params'      => \Yii::$app->request->post()
                ],
                'delete' => [
                    'class'       => 'frontend\controllers\Taskpart\DeleteAction',
                    'modelClass'  => $this->modelClass,
                    'checkAccess' => [$this, 'checkAccess'],
                    'params'      => \Yii::$app->request->post()
                ],
            ];

            return array_merge(parent::actions(), $actions);
        }

        public function verbs() {

            $verbs = [
                'search'   => ['GET'],
                'empty'   => ['GET'],
                'delete'   => ['POST']
            ];
            return array_merge(parent::verbs(), $verbs);
        }
        public function behaviors()
        {
            $behaviors = parent::behaviors();
            $behaviors['authenticator'] = [
                'class' => QueryParamAuth::className(),
            ];
            $behaviors['syeditlogger'] = [
                'class' => SYEditLog::className()
            ];
            $behaviors['sslock'] = [
                'class' => SSLock::className()
            ];
            return $behaviors;
        }

        public function actionEmpty($Service_Ticket_Id){
            return ["deleted"=>SVServiceTicketParts::deleteAll(['Service_Ticket_Id'=>$Service_Ticket_Id])];
        }

    }