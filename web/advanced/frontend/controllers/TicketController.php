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
    use Yii;
    use yii\rest\ActiveController;
    use yii\filters\auth\QueryParamAuth;
    use yii\helpers\ArrayHelper;


    class TicketController extends ActiveController
    {
        public $modelClass = 'common\models\SVServiceTicket';

        public function actionList()
        {
            if (isset( $_REQUEST['Service_Tech_Id'] )) {
                return SVServiceTicket::getList( (int) $_REQUEST['Service_Tech_Id'] );
            } else {
                return [ "status" => "error", "message" => "Service_Tech_Id params is required" ];
            }
        }

        public function actionFind()
        {
            if (isset( $_REQUEST['id'] )) {
                return SVServiceTicket::getSingleInfo( $_REQUEST['id'] );
            } else {
                return [ "status" => "error", "message" => "ID params is required" ];
            }
        }

        public function behaviors()
        {
            $behaviors = parent::behaviors();
            $behaviors['authenticator'] = [
                'class' => QueryParamAuth::className(),
            ];
            return $behaviors;
        }
    }