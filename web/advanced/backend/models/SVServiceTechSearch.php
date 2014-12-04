<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SVServiceTech;

/**
 * SVServiceTechSearch represents the model behind the search form about `common\models\SVServiceTech`.
 */
class SVServiceTechSearch extends SVServiceTech
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Service_Tech_Id', 'Employee_Id', 'Vendor_Id', 'Service_Company_Id', 'Warehouse_Id', 'GE_Table1_Id', 'GE_Table2_Id', 'GE_Table3_Id', 'Country_Id', 'GE_Table4_Id', 'GE_Table5_Id', 'Expertise_Level', 'Install_Company_id'], 'integer'],
            [['Emp_or_Vendor', 'Inactive', 'Address_1', 'Address_2', 'Address_3', 'Zip_Code_Plus4', 'Service', 'Installer', 'Text_Message_Address', 'SageQuest_Driver', 'rowguid'], 'safe'],
            [['RegularPayRate', 'OvertimePayRate', 'HolidayPayRate'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SVServiceTech::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'Service_Tech_Id' => $this->Service_Tech_Id,
            'Employee_Id' => $this->Employee_Id,
            'Vendor_Id' => $this->Vendor_Id,
            'Service_Company_Id' => $this->Service_Company_Id,
            'Warehouse_Id' => $this->Warehouse_Id,
            'GE_Table1_Id' => $this->GE_Table1_Id,
            'GE_Table2_Id' => $this->GE_Table2_Id,
            'GE_Table3_Id' => $this->GE_Table3_Id,
            'Country_Id' => $this->Country_Id,
            'GE_Table4_Id' => $this->GE_Table4_Id,
            'GE_Table5_Id' => $this->GE_Table5_Id,
            'RegularPayRate' => $this->RegularPayRate,
            'OvertimePayRate' => $this->OvertimePayRate,
            'HolidayPayRate' => $this->HolidayPayRate,
            'Expertise_Level' => $this->Expertise_Level,
            'Install_Company_id' => $this->Install_Company_id,
        ]);

        $query->andFilterWhere(['like', 'Emp_or_Vendor', $this->Emp_or_Vendor])
            ->andFilterWhere(['like', 'Inactive', $this->Inactive])
            ->andFilterWhere(['like', 'Address_1', $this->Address_1])
            ->andFilterWhere(['like', 'Address_2', $this->Address_2])
            ->andFilterWhere(['like', 'Address_3', $this->Address_3])
            ->andFilterWhere(['like', 'Zip_Code_Plus4', $this->Zip_Code_Plus4])
            ->andFilterWhere(['like', 'Service', $this->Service])
            ->andFilterWhere(['like', 'Installer', $this->Installer])
            ->andFilterWhere(['like', 'Text_Message_Address', $this->Text_Message_Address])
            ->andFilterWhere(['like', 'SageQuest_Driver', $this->SageQuest_Driver])
            ->andFilterWhere(['like', 'rowguid', $this->rowguid]);

        return $dataProvider;
    }
}
