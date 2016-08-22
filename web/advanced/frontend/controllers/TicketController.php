<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 15.10.14
     * Time: 14:45
     */

    namespace frontend\controllers;

    use common\behaviors\SSLock;
    use common\components\PageLoaderComponent;
    use common\models\SVServiceTech;
    use common\models\SVServiceTicket;
    use common\models\SVServiceTicketDispatch;
    use Yii;
    use yii\data\ActiveDataProvider;
    use yii\db\Query;
    use yii\rest\ActiveController;
    use yii\filters\auth\QueryParamAuth;
    use yii\helpers\ArrayHelper;
    use common\behaviors\SYEditLog;


    class TicketController extends ActiveController
    {
        public $modelClass = 'common\models\SVServiceTicket';

        public function actionList()
        {
            return SVServiceTicket::getList( Yii::$app->user->getIdentity()->technition_id );
        }

        public function actionFind($id, $Ticket_Number)
        {
            return SVServiceTicket::getSingleInfo( $id, $Ticket_Number );
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

        public function actionGetdispatch($dispatch_id){
//            return json_decode(PageLoaderComponent::load(Yii::$app->params['api.url']."/api/serviceticketdispatch/{$task_id}/byserviceticketid"));
//            return SVServiceTicketDispatch::find()->where(['Service_Ticket_Id'=>$task_id, 'Service_Tech_Id'=>Yii::$app->user->getIdentity()->technition_id])->orderBy(['Dispatch_Id'=>SORT_DESC])->one();
            $query = new Query();
            return new ActiveDataProvider([
                'query' => $query
                    ->select('
             SV_Service_Ticket_Dispatch.Dispatch_Id,
             SV_Service_Ticket_Dispatch.Service_Ticket_Id,
             SV_Service_Ticket_Dispatch.Service_Tech_Id,
             SV_Service_Ticket_Dispatch.Schedule_Time,
             SV_Service_Ticket_Dispatch.Dispatch_Time,
             SV_Service_Ticket_Dispatch.Arrival_Time,
             SV_Service_Ticket_Dispatch.Departure_Time,
             SV_Service_Ticket_Dispatch.Estimated_Length,
             SV_Service_Ticket_Dispatch.Resolution_Id,
             SV_Service_Ticket_Dispatch.Signature,
             SV_Service_Ticket_Dispatch.Resolves_Ticket,
             SV_Service_Ticket_Dispatch.IsGoBack,
             SV_Service_Ticket_Dispatch.UserCode,
             SV_Service_Ticket_Dispatch.Edit_Timestamp,
             SV_Service_Ticket_Dispatch.Signer,
             SV_Service_Ticket_Dispatch.Note_id,
             SV_Service_Ticket_Dispatch.Register_Id,
             SV_Service_Ticket_Dispatch.FSU_No_Signer_Available,
             SV_Service_Ticket_Dispatch.rowguid,
             SV_Service_Ticket_Dispatch.Send_To_FSU,
             SV_Service_Ticket_Dispatch.Holiday,
             SV_Service_Ticket_Dispatch.Overtime,
             SV_Service_Ticket_Dispatch.Is_Firm,
             SS_LockTable.LockedByUser,
             DATEDIFF(n, SS_LockTable.LockedTime, GETDATE()) as locked_length,
             SS_LockTable.LockedTime as when_locked,
             SS_LockTable.Form as form,
             ')
                    ->from('SV_Service_Ticket_Dispatch')
                    ->innerJoin('SV_Service_Ticket', 'SV_Service_Ticket.Service_Ticket_Id = SV_Service_Ticket_Dispatch.Service_Ticket_Id')
                    ->leftJoin('SS_LockTable', 'SV_Service_Ticket.Ticket_Number = SS_LockTable.Code AND SS_LockTable.Table_Name = "sv_service_ticket"')
                    ->where(['SV_Service_Ticket_Dispatch.Dispatch_Id'=>$dispatch_id, 'Service_Tech_Id'=>Yii::$app->user->getIdentity()->technition_id])
                    ->orderBy(['Dispatch_Id'=>SORT_DESC])
                    ->limit(1)
                , 'pagination' => false
            ]);
        }
    }
    /*
     *
    <>344384</Dispatch_Id>
    <>1119097</Service_Ticket_Id>
    <>219</Service_Tech_Id>
    <>Mar 4 2015 08:00:00:000AM</Schedule_Time>
    <>Apr 14 2015 02:49:14:000PM</Dispatch_Time>
    <>Apr 14 2015 02:53:01:000PM</Arrival_Time>
    <>Dec 30 1899 12:00:00:000AM</Departure_Time>
    <>30</Estimated_Length>
    <>73</Resolution_Id>
    </>
    <>N</Resolves_Ticket>
    <>N</IsGoBack>
    <>dsurrency</UserCode>
    <>Mar 4 2015 10:26:48:403AM</Edit_Timestamp>
    </>
    <>1</Note_id>
    <>7676087</Register_Id>
    <>N</FSU_No_Signer_Available>
    <>6C9B83D5-82C2-E411-9894-002655D28484</rowguid>
    <>0</Send_To_FSU>
    <>0</Holiday>
    <>0</Overtime>
    <>0</Is_Firm>
     */