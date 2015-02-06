<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "SV_Service_Tech".
     *
     * @property integer $Service_Tech_Id
     * @property string $Emp_or_Vendor
     * @property integer $Employee_Id
     * @property integer $Vendor_Id
     * @property integer $Service_Company_Id
     * @property string $Inactive
     * @property integer $Warehouse_Id
     * @property string $Address_1
     * @property integer $GE_Table1_Id
     * @property integer $GE_Table2_Id
     * @property integer $GE_Table3_Id
     * @property integer $Country_Id
     * @property string $Address_2
     * @property string $Address_3
     * @property integer $GE_Table4_Id
     * @property integer $GE_Table5_Id
     * @property string $Zip_Code_Plus4
     * @property string $Service
     * @property string $Installer
     * @property string $RegularPayRate
     * @property string $OvertimePayRate
     * @property string $HolidayPayRate
     * @property integer $Expertise_Level
     * @property integer $Install_Company_id
     * @property string $Text_Message_Address
     * @property string $SageQuest_Driver
     * @property string $rowguid
     */
    class SVServiceTech extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'SV_Service_Tech';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [
                    [
                        'Emp_or_Vendor',
                        'Inactive',
                        'Address_1',
                        'Address_2',
                        'Address_3',
                        'Zip_Code_Plus4',
                        'Service',
                        'Installer',
                        'Text_Message_Address',
                        'SageQuest_Driver',
                        'rowguid'
                    ],
                    'string'
                ],
                [
                    [
                        'Employee_Id',
                        'Vendor_Id',
                        'Service_Company_Id',
                        'Warehouse_Id',
                        'GE_Table1_Id',
                        'GE_Table2_Id',
                        'GE_Table3_Id',
                        'Country_Id',
                        'GE_Table4_Id',
                        'GE_Table5_Id',
                        'Expertise_Level',
                        'Install_Company_id'
                    ],
                    'integer'
                ],
                [ [ 'RegularPayRate', 'OvertimePayRate', 'HolidayPayRate' ], 'number' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'Service_Tech_Id'      => 'Service  Tech  ID',
                'Emp_or_Vendor'        => 'Emp Or  Vendor',
                'Employee_Id'          => 'Employee  ID',
                'Vendor_Id'            => 'Vendor  ID',
                'Service_Company_Id'   => 'Service  Company  ID',
                'Inactive'             => 'Inactive',
                'Warehouse_Id'         => 'Warehouse  ID',
                'Address_1'            => 'Address 1',
                'GE_Table1_Id'         => 'Ge  Table1  ID',
                'GE_Table2_Id'         => 'Ge  Table2  ID',
                'GE_Table3_Id'         => 'Ge  Table3  ID',
                'Country_Id'           => 'Country  ID',
                'Address_2'            => 'Address 2',
                'Address_3'            => 'Address 3',
                'GE_Table4_Id'         => 'Ge  Table4  ID',
                'GE_Table5_Id'         => 'Ge  Table5  ID',
                'Zip_Code_Plus4'       => 'Zip  Code  Plus4',
                'Service'              => 'Service',
                'Installer'            => 'Installer',
                'RegularPayRate'       => 'Regular Pay Rate',
                'OvertimePayRate'      => 'Overtime Pay Rate',
                'HolidayPayRate'       => 'Holiday Pay Rate',
                'Expertise_Level'      => 'Expertise  Level',
                'Install_Company_id'   => 'Install  Company ID',
                'Text_Message_Address' => 'Text  Message  Address',
                'SageQuest_Driver'     => 'Sage Quest  Driver',
                'rowguid'              => 'Rowguid',
            ];
        }

        public function getEmployee(){
            return $this->hasOne( SYEmployee::className(), [ 'Employee_Id' => 'Employee_Id' ] );
        }
        public function fields()
        {
            $fields = parent::fields();


            $fields['techname'] = function(){
                return $this->employee->fullname;
            };
            $fields['usercode'] = function(){
                return $this->employee->usercode;
            };
            return $fields;
        }
//        public function getTechname(){
////            return $this->employee->First_name;
//            return "DDD";
//        }
    }
