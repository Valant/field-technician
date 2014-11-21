<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "SV_Service_Ticket_Parts".
     *
     * @property integer $Service_Ticket_Part_Id
     * @property integer $Service_Ticket_Id
     * @property integer $Part_Id
     * @property double $Quantity
     * @property string $Rate
     * @property string $Location
     * @property integer $Asset_Register_Id
     * @property integer $COGS_Register_Id
     * @property integer $Service_Tech_Id
     * @property integer $Journal_Id
     * @property string $Issue_From_Stock
     * @property integer $WIP_Register_Id
     * @property integer $InterCompany_Register_Id
     * @property string $Serial_Number
     * @property string $Lot_Number
     * @property integer $Customer_Equipment_ID
     * @property integer $Warehouse_Id
     */
    class SVServiceTicketParts extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'SV_Service_Ticket_Parts';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'Service_Ticket_Id', 'Part_Id' ], 'required' ],
                [
                    [
                        'Service_Ticket_Id',
                        'Part_Id',
                        'Asset_Register_Id',
                        'COGS_Register_Id',
                        'Service_Tech_Id',
                        'Journal_Id',
                        'WIP_Register_Id',
                        'InterCompany_Register_Id',
                        'Customer_Equipment_ID',
                        'Warehouse_Id'
                    ],
                    'integer'
                ],
                [ [ 'Quantity', 'Rate' ], 'number' ],
                [ [ 'Location', 'Issue_From_Stock', 'Serial_Number', 'Lot_Number' ], 'string' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'Service_Ticket_Part_Id'   => 'Service  Ticket  Part  ID',
                'Service_Ticket_Id'        => 'Service  Ticket  ID',
                'Part_Id'                  => 'Part  ID',
                'Quantity'                 => 'Quantity',
                'Rate'                     => 'Rate',
                'Location'                 => 'Location',
                'Asset_Register_Id'        => 'Asset  Register  ID',
                'COGS_Register_Id'         => 'Cogs  Register  ID',
                'Service_Tech_Id'          => 'Service  Tech  ID',
                'Journal_Id'               => 'Journal  ID',
                'Issue_From_Stock'         => 'Issue  From  Stock',
                'WIP_Register_Id'          => 'Wip  Register  ID',
                'InterCompany_Register_Id' => 'Inter Company  Register  ID',
                'Serial_Number'            => 'Serial  Number',
                'Lot_Number'               => 'Lot  Number',
                'Customer_Equipment_ID'    => 'Customer  Equipment  ID',
                'Warehouse_Id'             => 'Warehouse  ID',
            ];
        }
    }
