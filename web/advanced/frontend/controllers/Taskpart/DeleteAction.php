<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 12/23/15
     * Time: 14:27
     */

    namespace frontend\controllers\Taskpart;


    use common\components\PageLoaderComponent;
    use common\models\INPart;
    use common\models\SVServiceTicketParts;
    use yii\rest\Action;

    class DeleteAction extends Action
    {
        public $params;

        public function run()
        {

            if ($part = INPart::findOne( $this->params['part_id'] )) {

                return json_decode( PageLoaderComponent::load( \Yii::$app->params['api.url'] . "/api/ServiceTicketPart",
                    [
                        "ServiceTicketNumber" => $this->params['Ticket_Number'],
                        "PartCode"            => $part->Part_Code,
                        "Quantity"            => $this->params['Quantity'] * -1,
                        "Rate"                => $part->Service_Price * 3.5,
                        "WarehouseCode"       => $this->params['Warehouse_Code'],
                        "ServiceTechCode"     => $this->params['ServiceTechCode'],
                        "FromStock"           => true
                    ], true, false ) );
            } else {
                return $this->params;
            }

//            return ["deleted"=>SVServiceTicketParts::deleteAll(['Service_Ticket_Id'=>$this->params['ticket_id'], 'Part_Id'=>$this->params['part_id']])];

        }

    }