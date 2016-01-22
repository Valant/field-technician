<?php

    namespace frontend\controllers\Dispatch;

    use common\components\PageLoaderComponent;
    use yii\rest\Action;

    use Yii;
    use yii\base\Model;
    use yii\db\ActiveRecord;
    use yii\web\ServerErrorHttpException;

    class UpdateAction extends Action
    {
        /**
         * @var string the scenario to be assigned to the model before it is validated and updated.
         */
        public $scenario = Model::SCENARIO_DEFAULT;


        /**
         * Updates an existing model.
         *
         * @param string $id the primary key of the model.
         *
         * @return \yii\db\ActiveRecordInterface the model being updated
         * @throws ServerErrorHttpException if thereясно, ну мне Вованыч is any error when updating the model
         */
        public function run( $id )
        {
            $modelClass = $this->modelClass;
            $keys       = array( 'Dispatch_Id', 'Service_Ticket_Id' );
            $values     = explode( ',', $id );
            if ( ! Yii::$app->getUser()->isGuest) {
                $params                    = array_combine( $keys, $values );
                $params['Service_Tech_Id'] = Yii::$app->getUser()->getIdentity()->technition_id;
                /* @var $model \yii\db\ActiveRecord */
                $model = $modelClass::findOne( $params );
            } else {
                /* @var $model \yii\db\ActiveRecord */
                $model = $this->findModel( $id );
            }

//        $this->findByAttributes(array('first_name'=>$firstName,'last_name'=>$lastName));
            if ($this->checkAccess) {
                call_user_func( $this->checkAccess, $this->id, $model );
            }

            $model->scenario = $this->scenario;
            $requestParams   = Yii::$app->getRequest()->getBodyParams();


            $preparedRequest = [];
            $preparedRequest['DispatchId'] = $params['Dispatch_Id'];
            $preparedRequest['ServiceTechCode'] = $requestParams['UserCode'];
            $preparedRequest['UserCode'] = $requestParams['UserCode'];
            if(!empty($requestParams['Dispatch_Time'])&&($requestParams['Dispatch_Time'] != 0)){
                $preparedRequest['DispatchTime'] = $requestParams['Dispatch_Time'];
            }
            if(!empty($requestParams['Arrival_Time'])&&($requestParams['Arrival_Time'] != 0)){
                $preparedRequest['ArrivalTime'] = $requestParams['Arrival_Time'];
            }
            if(!empty($requestParams['Departure_Time'])&&($requestParams['Departure_Time'] != 0)){
                $preparedRequest['DepartureTime'] = $requestParams['Departure_Time'];
            }

            if (isset( $requestParams['Ticket_Status'] ) && ! empty( $requestParams['Ticket_Status'] )) {
                switch ($requestParams['Ticket_Status']) {
                    case "GB":
                        $preparedRequest['GoBack'] = true;
                        break;
                    case "RS":
                        $preparedRequest['ResolvesTicket'] = true;
                        if(!empty($requestParams['Resolution_Code'])){
                            $preparedRequest['ResolutionCode'] = $requestParams['Resolution_Code'];
                        }
                        break;
                }
            }

            return json_decode( PageLoaderComponent::load(
                \Yii::$app->params['api.url'] . "/api/serviceticketdispatch/" . $params['Dispatch_Id'], $preparedRequest, true, false, true
            ) );

        }
    }
