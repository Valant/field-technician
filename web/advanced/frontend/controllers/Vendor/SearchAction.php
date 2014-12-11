<?php
/**
 * Created by PhpStorm.
 * User: godson
 * Date: 27.11.14
 * Time: 17:11
 */

namespace frontend\controllers\Vendor;


use yii\rest\Action;

use Yii;
use yii\data\ActiveDataProvider;
class SearchAction extends  Action  {
    public $prepareDataProvider;
    public $params;

    /**
     * @return ActiveDataProvider
     */
    public function run() {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        return $this->prepareDataProvider();
    }

    /**
     * Prepares the data provider that should return the requested collection of the models.
     * @return ActiveDataProvider
     */
    protected function prepareDataProvider() {
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }

        /**
         * @var \yii\db\BaseActiveRecord $modelClass
         */
        $modelClass = $this->modelClass;

        $model = new $this->modelClass([
        ]);

        $safeAttributes = $model->safeAttributes();
        $params = array();

        foreach($this->params as $key => $value){
            if(in_array($key, $safeAttributes)){
                $params[$key] = $value;
            }
        }


        $query = $modelClass::find();
        if(isset($params['VENDNM'])){
            $query->where("VENDNM LIKE :vendnm");
            $query->addParams([':vendnm'=>$params['VENDNM']."%"]);
            unset($params['VENDNM']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (empty($params)) {
            return $dataProvider;
        }


        foreach ($params as $param => $value) {
            $query->andFilterWhere([
                $param => $value,
            ]);
        }

        return $dataProvider;
    }
} 