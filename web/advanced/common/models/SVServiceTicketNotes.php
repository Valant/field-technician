<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "SV_Service_Ticket_Notes".
     *
     * @property integer $Service_Ticket_Notes_Id
     * @property integer $Service_Ticket_Id
     * @property integer $Access_Level
     * @property string $UserCode
     * @property string $Entered_Date
     * @property string $Edit_UserCode
     * @property string $Edit_Date
     * @property string $Is_Resolution
     * @property string $Notes
     */
    class SVServiceTicketNotes extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'SV_Service_Ticket_Notes';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'Service_Ticket_Id' ], 'required' ],
                [ [ 'Service_Ticket_Id', 'Access_Level' ], 'integer' ],
                [ [ 'UserCode', 'Edit_UserCode', 'Is_Resolution', 'Notes' ], 'string' ],
                [ [ 'Entered_Date', 'Edit_Date' ], 'safe' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'Service_Ticket_Notes_Id' => 'Service  Ticket  Notes  ID',
                'Service_Ticket_Id'       => 'Service  Ticket  ID',
                'Access_Level'            => 'Access  Level',
                'UserCode'                => 'User Code',
                'Entered_Date'            => 'Entered  Date',
                'Edit_UserCode'           => 'Edit  User Code',
                'Edit_Date'               => 'Edit  Date',
                'Is_Resolution'           => 'Is  Resolution',
                'Notes'                   => 'Notes',
            ];
        }
        public function beforeSave($insert){

            if($insert) {
            $this->Access_Level = 2;
            $this->Is_Resolution = 'N';
            }
            return parent::beforeSave($insert);
        }
    }
