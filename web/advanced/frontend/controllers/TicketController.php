<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 15.10.14
     * Time: 14:45
     */

    namespace frontend\controllers;

    use common\models\ArCustomer;
    use common\models\SVProblem;
    use Yii;
    use common\models\SVServiceTicket;
    use yii\rest\ActiveController;
    use yii\data\ActiveDataProvider;
    use yii\db\Query;


    class TicketController extends ActiveController {
        public $modelClass = 'common\models\SVServiceTicket';

        public function actionFind() {

            $whereArr = [ ];
            if ( isset( $_REQUEST['Ticket_Status'] ) ) {
                if ( in_array( $_REQUEST['Ticket_Status'], SVServiceTicket::$AllowedStatus ) ) {
                    $whereArr[':Ticket_Status'] = $_REQUEST['Ticket_Status'];
                }
            }
            if ( isset( $_REQUEST['Service_Tech_Id'] ) ) {
                $whereArr[':Service_Tech_Id'] = (int) $_REQUEST['Service_Tech_Id'];
            }

            $query = new Query;


            return new ActiveDataProvider( [
                'query' => $query->select( '
                SV_Service_Ticket.CustomerComments, SV_Service_Ticket.Service_Ticket_Id, SV_Service_Ticket.Ticket_Number,
                SV_Service_Ticket.Customer_Id, SV_Service_Ticket.Requested_By, SV_Service_Ticket.Estimated_Length,
                SV_Service_Ticket.Creation_Date, SV_Service_Ticket.Scheduled_For, SV_Service_Ticket.Category_Id,
                SV_Service_Ticket.Route_Id, SV_Routes.Route_Code, SV_Routes.Description as  RouteDescription, SV_Problem.Problem_Code,
                SV_Problem.Description as ProblemDescription, AR_Customer.Customer_Name, ar_customer.customer_number,
                ar_customer_bill.address_1, ar_customer_bill.ge1_description, ar_customer_bill.ge2_short, ar_customer_bill.ge3_description,
                ar_customer_site.business_name, ar_customer_site.address_1 as Customer_Site_Address, ar_customer_site.ge1_description as Customer_Site_Ge1_Description,
                ar_customer_site.ge2_short as Customer_Site_Ge2_Short, ar_customer_site.ge3_description as Customer_Site_Ge3_Description,
                ar_customer_system.alarm_account, sy_system.description as System_Description, sy_panel_type.description as System_Panel_Description,
                ar_customer_site.phone_1, ar_customer_site.cross_street, ar_customer_system.system_comments
                ' )->from( 'SV_Service_Ticket' )
                                 ->innerJoin( 'AR_Customer', 'AR_Customer.Customer_Id = SV_Service_Ticket.Customer_Id' )
                                 ->innerJoin( 'AR_Customer_Bill',
                                     'AR_Customer_Bill.Customer_Id = AR_Customer.Customer_Id' )
                                 ->innerJoin( 'AR_Customer_Site',
                                     'AR_Customer_Site.Customer_Id = AR_Customer.Customer_Id' )
                                 ->innerJoin( 'AR_Customer_System',
                                     'AR_Customer_System.Customer_Id = AR_Customer.Customer_Id' )
                                 ->innerJoin( 'SY_System', 'AR_Customer_System.System_Id = SY_System.System_Id' )
                                 ->innerJoin( 'SY_Panel_Type',
                                     'SY_Panel_Type.panel_type_id = ar_customer_system.panel_type_id' )
                                 ->innerJoin( 'SV_Service_Tech_Routes',
                                     'SV_Service_Tech_Routes.Route_Id = SV_Service_Ticket.Route_Id' )
                                 ->innerJoin( 'SV_Problem', 'SV_Service_Ticket.Problem_Id = SV_Problem.Problem_Id' )
                                 ->innerJoin( 'SV_Routes', 'SV_Routes.Route_Id = SV_Service_Tech_Routes.Route_Id' )
                                 ->where( "SV_Service_Ticket.Ticket_Status = :Ticket_Status AND SV_Service_Tech_Routes.Service_Tech_Id = :Service_Tech_Id",
                                     $whereArr )
                                 ->orderBy( 'Service_Ticket_Id', 'DESC' )->limit( 100 )
            ] );

        }
    }