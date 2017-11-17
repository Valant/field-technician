<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 15.10.14
     * Time: 14:45
     */

    namespace frontend\controllers;

    use common\models\SVServiceTicket;
    use common\models\SVServiceTicketNotes;
    use Yii;
    use yii\rest\ActiveController;
    use yii\filters\auth\QueryParamAuth;
    use yii\helpers\ArrayHelper;
    use common\behaviors\SYEditLog;


    class TicketnotesController extends ActiveController
    {
        public $modelClass = 'common\models\SVServiceTicketNotes';

        public function actionList()
        {
            return SVServiceTicket::getList( Yii::$app->user->getIdentity()->technition_id );
        }

        public function actionFind($dispatch_id, $ticket_number)
        {
            return SVServiceTicket::getSingleInfo( $dispatch_id, $ticket_number );
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
            return $behaviors;
        }

        public function actionGetdispatch($task_id){
            return SVServiceTicketNotes::find()->where(['Service_Ticket_Id'=>$task_id, 'Service_Tech_Id'=>Yii::$app->user->getIdentity()->technition_id])->orderBy(['Dispatch_Id'=>SORT_DESC])->one();
        }

        public function actionGetticketnotes($service_ticked_id){
			return new ActiveDataProvider([
                          'query' => SVServiceTicketNotes::find()->where(['Service_Ticket_Id'=>$service_ticked_id]),
                          'pagination' => [
                              'pageSize' => 20,
                          ],
                      ]);
        }
    }