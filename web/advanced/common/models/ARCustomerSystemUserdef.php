<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "AR_Customer_System_Userdef".
 *
 * @property integer $Customer_System_Userdef_Id
 * @property integer $Customer_System_Id
 * @property integer $Customer_Site_Id
 * @property integer $Customer_Id
 * @property integer $Table7_Id
 * @property integer $Table8_Id
 * @property integer $Table9_Id
 * @property string $Text1
 * @property string $Text2
 * @property string $Text3
 * @property string $Text4
 * @property string $Text5
 * @property string $Money1
 * @property string $Money2
 * @property string $Check1
 * @property string $Check2
 * @property string $Check3
 * @property string $Check4
 * @property string $Check5
 * @property string $Date1
 * @property string $Date2
 */
class ARCustomerSystemUserdef extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AR_Customer_System_Userdef';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Customer_System_Id', 'Customer_Site_Id', 'Customer_Id'], 'required'],
            [['Customer_System_Id', 'Customer_Site_Id', 'Customer_Id', 'Table7_Id', 'Table8_Id', 'Table9_Id'], 'integer'],
            [['Text1', 'Text2', 'Text3', 'Text4', 'Text5', 'Check1', 'Check2', 'Check3', 'Check4', 'Check5'], 'string'],
            [['Money1', 'Money2'], 'number'],
            [['Date1', 'Date2'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Customer_System_Userdef_Id' => 'Customer  System  Userdef  ID',
            'Customer_System_Id' => 'Customer  System  ID',
            'Customer_Site_Id' => 'Customer  Site  ID',
            'Customer_Id' => 'Customer  ID',
            'Table7_Id' => 'Table7  ID',
            'Table8_Id' => 'Table8  ID',
            'Table9_Id' => 'Table9  ID',
            'Text1' => 'Text1',
            'Text2' => 'Text2',
            'Text3' => 'Text3',
            'Text4' => 'Text4',
            'Text5' => 'Text5',
            'Money1' => 'Money1',
            'Money2' => 'Money2',
            'Check1' => 'Check1',
            'Check2' => 'Check2',
            'Check3' => 'Check3',
            'Check4' => 'Check4',
            'Check5' => 'Check5',
            'Date1' => 'Date1',
            'Date2' => 'Date2',
        ];
    }
}
