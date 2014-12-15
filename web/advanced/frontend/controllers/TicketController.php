<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 15.10.14
     * Time: 14:45
     */

    namespace frontend\controllers;

    use common\models\SVServiceTech;
    use common\models\SVServiceTicket;
    use common\models\SVServiceTicketDispatch;
    use Yii;
    use yii\rest\ActiveController;
    use yii\filters\auth\QueryParamAuth;
    use yii\helpers\ArrayHelper;


    class TicketController extends ActiveController
    {
        public $modelClass = 'common\models\SVServiceTicket';

        public function actionList()
        {
            return SVServiceTicket::getList( Yii::$app->user->getIdentity()->technition_id );
        }

        public function actionFind($id)
        {
            return SVServiceTicket::getSingleInfo( $id );
        }

        public function behaviors()
        {
            $behaviors = parent::behaviors();
            $behaviors['authenticator'] = [
                'class' => QueryParamAuth::className(),
            ];
            return $behaviors;
        }

        public function actionGetdispatch($task_id){
            return SVServiceTicketDispatch::find()->where(['Service_Ticket_Id'=>$task_id, 'Service_Tech_Id'=>Yii::$app->user->getIdentity()->technition_id])->orderBy(['Dispatch_Id'=>SORT_DESC])->one();
        }
    }