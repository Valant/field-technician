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
    use yii\filters\Cors;
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
        public function behaviors(){
            return  ArrayHelper::merge([[
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'PUT','GET','DELETE'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Headers' => ['X-Wsse'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                ],
            ]],parent::behaviors());
        }
    }