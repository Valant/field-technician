<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "SV_Service_Ticket_Dispatch".
     *
     * @property integer $Dispatch_Id
     * @property integer $Service_Ticket_Id
     * @property integer $Service_Tech_Id
     * @property string $Schedule_Time
     * @property string $Dispatch_Time
     * @property string $Arrival_Time
     * @property string $Departure_Time
     * @property integer $Estimated_Length
     * @property integer $Resolution_Id
     * @property resource $Signature
     * @property string $Resolves_Ticket
     * @property string $IsGoBack
     * @property string $UserCode
     * @property string $Edit_Timestamp
     * @property string $Signer
     * @property integer $Note_id
     * @property integer $Register_Id
     * @property string $FSU_No_Signer_Available
     * @property string $rowguid
     * @property integer $Send_To_FSU
     * @property integer $Holiday
     * @property integer $Overtime
     * @property integer $Is_Firm
     */
    class SVServiceTicketDispatch extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'SV_Service_Ticket_Dispatch';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'Service_Ticket_Id', 'Service_Tech_Id' ], 'required' ],
                [
                    [
                        'Service_Ticket_Id',
                        'Service_Tech_Id',
                        'Estimated_Length',
                        'Resolution_Id',
                        'Note_id',
                        'Register_Id',
                        'Send_To_FSU',
                        'Holiday',
                        'Overtime',
                        'Is_Firm'
                    ],
                    'integer'
                ],
                [ [ 'Schedule_Time', 'Dispatch_Time', 'Arrival_Time', 'Departure_Time', 'Edit_Timestamp' ], 'safe' ],
                [
                    [
                        'Signature',
                        'Resolves_Ticket',
                        'IsGoBack',
                        'UserCode',
                        'Signer',
                        'FSU_No_Signer_Available',
                        'rowguid'
                    ],
                    'string'
                ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'Dispatch_Id'             => 'Dispatch  ID',
                'Service_Ticket_Id'       => 'Service  Ticket  ID',
                'Service_Tech_Id'         => 'Service  Tech  ID',
                'Schedule_Time'           => 'Schedule  Time',
                'Dispatch_Time'           => 'Dispatch  Time',
                'Arrival_Time'            => 'Arrival  Time',
                'Departure_Time'          => 'Departure  Time',
                'Estimated_Length'        => 'Estimated  Length',
                'Resolution_Id'           => 'Resolution  ID',
                'Signature'               => 'Signature',
                'Resolves_Ticket'         => 'Resolves  Ticket',
                'IsGoBack'                => 'Is Go Back',
                'UserCode'                => 'User Code',
                'Edit_Timestamp'          => 'Edit  Timestamp',
                'Signer'                  => 'Signer',
                'Note_id'                 => 'Note ID',
                'Register_Id'             => 'Register  ID',
                'FSU_No_Signer_Available' => 'Fsu  No  Signer  Available',
                'rowguid'                 => 'Rowguid',
                'Send_To_FSU'             => 'Send  To  Fsu',
                'Holiday'                 => 'Holiday',
                'Overtime'                => 'Overtime',
                'Is_Firm'                 => 'Is  Firm',
            ];
        }
    }
