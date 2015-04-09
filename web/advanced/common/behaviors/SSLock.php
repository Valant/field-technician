<?php
/**
 * Created by PhpStorm.
 * User: dem1k
 * Date: 27.03.15
 * Time: 16:32
 */
namespace common\behaviors;

use common\models\SSLockTable;
use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Query;

class SSLock extends Behavior
{


    public function events()
    {
        return [
            yii\rest\Controller::EVENT_BEFORE_ACTION => 'updateSSLockTable',
        ];
    }

    public function updateSSLockTable($event)
    {

        if (in_array($event->action->controller->id, ['ticket', 'dispatch', 'taskpart'])) {

            switch ($event->action->id) {
                case 'find':
                    $params = Yii::$app->request->getQueryParams();
                    $ticketNumber = $params['ticket_number'];
                    $userCode = $params['UserCode'];
                    break;
                case 'update':
                case 'create':
                    if ($event->action->controller->id == 'dispatch'||$event->action->controller->id == 'taskpart') {
                        $params = Yii::$app->request->getBodyParams();
                        $ticketNumber = $params['ticket_number'];
                        $userCode = $params['UserCode'];
                    } else return;

/*
                    if ($event->action->controller->id == 'taskpart') {
                        $params = Yii::$app->request->getBodyParams();
                        $ticketNumber = $params['ticket_number'];
                        $userCode = $params['UserCode'];
                    } else return;*/
                    break;
                case 'list':
                    $params = Yii::$app->request->getQueryParams();
                    $userCode = $params['UserCode'];
                    SSLockTable::deleteAll("LockedByUser ='".$userCode."' and Form = 'mobile'");
                    return;
                    break;
                default:
                    return;
            }

            $query = new Query;
            $query->select('SV_Service_Ticket.Service_Ticket_Id,
        SV_Service_Ticket.Ticket_Number,
        SS_LockTable.LockTable_Id,
        SS_LockTable.LockedByUser,
        SS_LockTable.LockedTime')
                ->from('SV_Service_Ticket')
                ->leftJoin('SS_LockTable', 'SV_Service_Ticket.Ticket_Number = SS_LockTable.Code')
                ->where("SV_Service_Ticket.Ticket_Number = :Ticket_Number", [":Ticket_Number" => $ticketNumber]);
            $tickedLocked = $query->one();

            $lock = new SSLockTable();
            $lock->Table_Name = 'SV_Service_Ticket';

            $lock->LockedByUser = $userCode;
            $lock->LockedTime = new yii\db\Expression( " GETDATE()" );
            $lock->Code = $ticketNumber;
            $lock->Form = 'Mobile';
            $lock->Description = 'User:' . $userCode;
            $lock->Table_Or_Process = 'P';
            $lock->Application_Id = '3';

            if (!$tickedLocked || $tickedLocked['LockTable_Id'] == null) {

                $lock->save();
            } elseif ((time() - strtotime($tickedLocked['LockedTime'])) > 60 *5 || $tickedLocked['LockedByUser'] == $userCode) {
                SSLockTable::deleteAll("Code ='".$ticketNumber."' and Form = 'mobile'");
                $lock->save();
            }
        }
    }
}