<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 15.10.14
     * Time: 14:45
     */

    namespace frontend\controllers;

    use Yii;
    use common\models\SVServiceTicket;
    use yii\rest\ActiveController;
    use yii\data\ActiveDataProvider;


    class TicketController extends ActiveController {
        public $modelClass = 'common\models\SVServiceTicket';

        public function actionFind() {

            $whereArr = [ ];
            if ( isset( $_REQUEST['Ticket_Status'] ) ) {
                if ( in_array( $_REQUEST['Ticket_Status'], SVServiceTicket::$AllowedStatus ) ) {
                    $whereArr['Ticket_Status'] = $_REQUEST['Ticket_Status'];
                }
            }
            if ( isset( $_REQUEST['Service_Tech_Id'] ) ) {
                $whereArr['Service_Tech_Id'] = (int) $_REQUEST['Service_Tech_Id'];
            }

            return new ActiveDataProvider( [
                'query' => SVServiceTicket::find()->where( $whereArr )->with( 'SVServiceTechRoutes' )->orderBy( [ 'Service_Ticket_Id' => SORT_DESC ] )->limit( 100 )
            ] );

        }
    }