<?php
/**
 * Created by PhpStorm.
 * User: dem1k
 * Date: 27.03.15
 * Time: 16:32
 */
namespace common\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use \common\models\SYEditLog as SYEditLogModel;

class SYEditLog extends Behavior
{

    public function events()
    {
        return [
            yii\rest\Controller::EVENT_AFTER_ACTION => 'saveSyEditLog',
        ];
    }

    public function saveSyEditLog($event)
    {

        $ticketNumber = null;
        if (!in_array($event->action->id, ['list', 'getdispatch', 'search', 'keyword', 'empty'])) {
            $request = Yii::$app->request;
            $model = $event->result;

            if ($model instanceof \yii\db\ActiveRecord) {
                switch ($model->tableName()) {
                    case 'SV_Service_Ticket_Dispatch':
                        $type = 'ticket dispatch';
                        break;
                    case 'SV_Service_Ticket':
                        $type = 'ticket';
                        break;
                    case 'SV_Service_Ticket_Notes':
                        $type = 'ticket notes';
                        break;
                    case 'SV_Service_Ticket_Parts':
                        $type = 'ticket parts';
                        break;
                    case 'task_attachment':
                        $type = 'task attachment';
                        break;
                    default:
                        $type = 'ticket';
                        break;
                }
                $tableName = $model->tableName();
                $userCode = $request->getBodyParam('UserCode', '');
                $ticketNumber = $request->getBodyParam('Ticket_Number', '');
            } elseif ($model instanceof \yii\data\ActiveDataProvider) {

                $type = 'ticket';
                $model = new $event->action->controller->modelClass;

                $tableName = $model->tableName();
                $ticketNumber = $request->getQueryParam('Ticket_Number', null);
                $userCode = $request->getQueryParam('UserCode', '');
            } else {
                return;
            }

            switch ($event->action->id) {
                case 'empty':
                    $userComments = 'mobile User Cleared ' . $type;
                    $editTypeAUD = 'D';

                    break;
                case 'update':
                    $userComments = 'mobile User Updated ' . $type;
                    $editTypeAUD = 'U';

                    break;
                case 'create':
                    $userComments = 'mobile User Created ' . $type;
                    $editTypeAUD = 'A';

                    break;
                case 'view':
                case 'find':
                    $userComments = 'mobile User Viewed ' . $type;
                    $editTypeAUD = 'O';

                    break;
                default:
                    $userComments = 'mobile ';
                    $editTypeAUD = 'A';

            }

            $log = new \common\models\SYEditLog();
            $log->UserCode = $userCode;
            $log->Edit_Timestamp = new yii\db\Expression(" GETDATE()");
            $log->SystemComments = "mobile";
            $log->UserComments = $userComments;
            $log->TableName = $tableName;
            $log->KeyField = 'Ticket_Number';//$primaryKey;
            $log->KeyData = $ticketNumber;//$primaryKeyValue;
            $log->Edit_Type_AUD = $editTypeAUD;
            $log->save();
        }

    }
}
