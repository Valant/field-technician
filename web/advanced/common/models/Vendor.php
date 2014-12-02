<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vendor".
 *
 * @property string $VENDCD
 * @property string $VENDNM
 * @property string $VENDAD1
 * @property string $VENDAD2
 * @property string $VENDCITY
 * @property string $VENDSTATE
 * @property string $VENDZIP
 * @property string $VENDPHN1
 * @property string $VENDPHN2
 * @property string $VENDPHN3
 * @property string $VENDCNTC
 * @property double $VENDCHECK
 * @property integer $VENDTYPE
 * @property integer $VENDTERMS
 * @property double $VENDGLACCT
 * @property integer $VENDCOUNT
 * @property string $VNOURNO
 * @property string $VENDACTCD
 * @property string $VENDCKMEMO
 * @property string $VENDCNTRY
 * @property string $VENDINV
 * @property string $VENDBUYER
 * @property string $VENDCMNT
 * @property string $VENDCMNT1
 * @property string $VENDCMNT2
 * @property integer $Vendor_Id
 * @property string $Vendor_Code
 */
class Vendor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vendor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VENDCD'], 'required'],
            [['VENDCD', 'VENDNM', 'VENDAD1', 'VENDAD2', 'VENDCITY', 'VENDSTATE', 'VENDZIP', 'VENDPHN1', 'VENDPHN2', 'VENDPHN3', 'VENDCNTC', 'VNOURNO', 'VENDACTCD', 'VENDCKMEMO', 'VENDCNTRY', 'VENDINV', 'VENDBUYER', 'VENDCMNT', 'VENDCMNT1', 'VENDCMNT2', 'Vendor_Code'], 'string'],
            [['VENDCHECK', 'VENDGLACCT'], 'number'],
            [['VENDTYPE', 'VENDTERMS', 'VENDCOUNT', 'Vendor_Id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'VENDCD' => 'Vendcd',
            'VENDNM' => 'Vendnm',
            'VENDAD1' => 'Vendad1',
            'VENDAD2' => 'Vendad2',
            'VENDCITY' => 'Vendcity',
            'VENDSTATE' => 'Vendstate',
            'VENDZIP' => 'Vendzip',
            'VENDPHN1' => 'Vendphn1',
            'VENDPHN2' => 'Vendphn2',
            'VENDPHN3' => 'Vendphn3',
            'VENDCNTC' => 'Vendcntc',
            'VENDCHECK' => 'Vendcheck',
            'VENDTYPE' => 'Vendtype',
            'VENDTERMS' => 'Vendterms',
            'VENDGLACCT' => 'Vendglacct',
            'VENDCOUNT' => 'Vendcount',
            'VNOURNO' => 'Vnourno',
            'VENDACTCD' => 'Vendactcd',
            'VENDCKMEMO' => 'Vendckmemo',
            'VENDCNTRY' => 'Vendcntry',
            'VENDINV' => 'Vendinv',
            'VENDBUYER' => 'Vendbuyer',
            'VENDCMNT' => 'Vendcmnt',
            'VENDCMNT1' => 'Vendcmnt1',
            'VENDCMNT2' => 'Vendcmnt2',
            'Vendor_Id' => 'Vendor  ID',
            'Vendor_Code' => 'Vendor  Code',
        ];
    }
}
