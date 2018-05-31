<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "IN_Warehouse".
 *
 * @property int $Warehouse_Id
 * @property string $Warehouse_Code
 * @property string $Description
 * @property int $Account_Id
 * @property int $Branch_Id
 * @property string $Inactive
 * @property string $Address_1
 * @property string $Address_2
 * @property string $Address_3
 * @property int $GE_Table1_Id
 * @property int $GE_Table2_Id
 * @property int $GE_Table3_Id
 * @property int $GE_Table4_Id
 * @property int $GE_Table5_Id
 * @property string $Zip_Code_Plus4
 * @property int $Country_Id
 * @property string $Latitude
 * @property string $Longitude
 */
class INWarehouse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'IN_Warehouse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Warehouse_Code', 'Description', 'Inactive', 'Address_1', 'Address_2', 'Address_3', 'Zip_Code_Plus4'], 'string'],
            [['Account_Id', 'Branch_Id'], 'required'],
            [['Account_Id', 'Branch_Id', 'GE_Table1_Id', 'GE_Table2_Id', 'GE_Table3_Id', 'GE_Table4_Id', 'GE_Table5_Id', 'Country_Id'], 'integer'],
            [['Latitude', 'Longitude'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Warehouse_Id' => 'Warehouse  ID',
            'Warehouse_Code' => 'Warehouse  Code',
            'Description' => 'Description',
            'Account_Id' => 'Account  ID',
            'Branch_Id' => 'Branch  ID',
            'Inactive' => 'Inactive',
            'Address_1' => 'Address 1',
            'Address_2' => 'Address 2',
            'Address_3' => 'Address 3',
            'GE_Table1_Id' => 'Ge  Table1  ID',
            'GE_Table2_Id' => 'Ge  Table2  ID',
            'GE_Table3_Id' => 'Ge  Table3  ID',
            'GE_Table4_Id' => 'Ge  Table4  ID',
            'GE_Table5_Id' => 'Ge  Table5  ID',
            'Zip_Code_Plus4' => 'Zip  Code  Plus4',
            'Country_Id' => 'Country  ID',
            'Latitude' => 'Latitude',
            'Longitude' => 'Longitude',
        ];
    }
}
