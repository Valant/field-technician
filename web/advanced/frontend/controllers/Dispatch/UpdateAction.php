<?php

namespace frontend\controllers\Dispatch;

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
     * @param string $id the primary key of the model.
     * @return \yii\db\ActiveRecordInterface the model being updated
     * @throws ServerErrorHttpException if there is any error when updating the model
     */
    public function run($id)
    {   $modelClass = $this->modelClass;
        $keys = array('Dispatch_Id', 'Service_Ticket_Id');
        $values = explode(',', $id);
        if (!Yii::$app->getUser()->isGuest) {
            $params = array_combine($keys, $values);
            $params['Service_Tech_Id']=Yii::$app->getUser()->getIdentity()->technition_id;
            /* @var $model \yii\db\ActiveRecord */
            $model = $modelClass::findOne($params);
        }else{
            /* @var $model \yii\db\ActiveRecord */
            $model = $this->findModel($id);
        }

//        $this->findByAttributes(array('first_name'=>$firstName,'last_name'=>$lastName));
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->scenario = $this->scenario;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;
    }
}
