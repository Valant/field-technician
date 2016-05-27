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

            if(!empty($this->params['service_ticket_part_id'])) {
                return json_decode(PageLoaderComponent::load(\Yii::$app->params['api.url'] . "/api/ServiceTicketPart/" . $this->params['service_ticket_part_id'],
                  [], true, false, false, true));
            }else{
                return $this->params;
            }

        }

    }