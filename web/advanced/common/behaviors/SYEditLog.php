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

        /*
         * string(6) "action"
        string(6) "result"
        string(7) "isValid"
        string(4) "name"
        string(6) "sender"
        string(7) "handled"
        string(4) "data"
         */

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
                if (is_array($model->getPrimaryKey())) {

                    foreach ($model->getPrimaryKey() as $key => $val) {
                        $keys[] = $key;
                        $vals[] = $val;
                    }
                    $primaryKey = implode(',', $keys);
                    $primaryKeyValue = implode(',', $vals);
                } else {
                    $primaryKey = $model->getPrimaryKey();
                    $primaryKeyValue = $model->primaryKey()[0];
                }
                $tableName = $model->tableName();
                $userCode = isset($request->getBodyParams()['UserCode']) ? $request->getBodyParams()['UserCode'] : '';
            } elseif ($model instanceof \yii\data\ActiveDataProvider) {

                $type = 'ticket';
                $model = new $event->action->controller->modelClass;

                $tableName = $model->tableName();

                $primaryKey = $model->primaryKey()[0];
                $actionParams = $event->action->controller->actionParams;
                $id = $actionParams['id'] ? $actionParams['id'] : $actionParams['task_id'];
                $primaryKeyValue = $id;

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

            $json = json_encode([
                'controller' => $event->action->controller->id,
                'action' => $event->action->id,
                'ip' => $request->getUserIp()]);
            $log = new \common\models\SYEditLog();
            $log->UserCode = $userCode;
            $log->Edit_Timestamp =  new yii\db\Expression( " GETDATE()" );
            $log->SystemComments = $json;
            $log->UserComments = $userComments;
            $log->TableName = $tableName;
            $log->KeyField = $primaryKey;
            $log->KeyData = $primaryKeyValue;
            $log->Edit_Type_AUD = $editTypeAUD;
            $log->save();
        }

    }
}

/*
 * CREATE TABLE SY_Edit_Log
(
    Edit_Log_Id INT NOT NULL,
    UserCode VARCHAR(25),
    Edit_Timestamp DATETIME,
    TableName VARCHAR(50),
    Edit_Type_AUD CHAR(1),
    KeyField VARCHAR(50),
    KeyData VARCHAR(50),
    UserComments VARCHAR(255),
    SystemComments VARCHAR(255),
    Edit_Column_Name VARCHAR(50),
    OldData VARCHAR(255),
    NewData VARCHAR(255)
);
CREATE UNIQUE INDEX fk_keydata ON SY_Edit_Log (KeyData);
CREATE UNIQUE INDEX fk_keyfield ON SY_Edit_Log (KeyField);
CREATE UNIQUE INDEX fk_tablename ON SY_Edit_Log (TableName);
CREATE UNIQUE INDEX fk_usercode ON SY_Edit_Log (UserCode);
CREATE UNIQUE INDEX pk_edit_log_id ON SY_Edit_Log (Edit_Log_Id);

 */