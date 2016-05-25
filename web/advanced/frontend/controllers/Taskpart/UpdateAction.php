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
    use yii\rest\Action;

    class UpdateAction extends Action
    {
        public $params;

        public function run()
        {
            if ($part = INPart::findOne($this->params['Part_Id'])) {

                return json_decode(PageLoaderComponent::load(\Yii::$app->params['api.url'] . "/api/ServiceTicketPart/" . $this->params['service_ticket_part_id'],
                  [
                    "service_ticket_part_id" => $this->params['service_ticket_part_id'],
                    "ServiceTicketNumber"    => $this->params['Ticket_Number'],
                    "PartCode"               => $part->Part_Code,
                    "Quantity"               => $this->params['Quantity'],
                    "Rate"                   => $part->Service_Price * 3.5,
                    "WarehouseCode"          => !empty($this->params['Warehouse_Code']) ? $this->params['Warehouse_Code'] : (!empty($this->params['Warehouse_Id']) ? $this->params['Warehouse_Id'] : "0"),
                    "ServiceTechCode"        => $this->params['ServiceTechCode'],
                    "FromStock"              => true
                  ], true, true));
            } else {
                return $this->params;
            }

        }

    }