<?php

    use yii\helpers\Html;
    use yii\grid\GridView;

    /* @var $this yii\web\View */
    /* @var $searchModel backend\models\SVServiceTicketSearch */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = 'User Tickets';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="svservice-ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Ticket Number',
                'format' => 'raw',
                'value'=>function ($data) {

                    return Html::a( $data['Ticket_Number'],
                        [ '/svserviceticket/view', 'id' => $data['Service_Ticket_Id'] ] );
                },
            ],
//            'Service_Ticket_Id',
            'ProblemDescription',
            'Customer_Name',
            'City',
            'Ticket_Status',
            [
                'label'=>'View attachment',
                'format'=>'raw',
                'value'=>function($data){
                    return Html::a("Attachments", ['taskattachment/index', 'TaskAttachmentSearch[task_id]'=>$data['Service_Ticket_Id']]);
                }
            ]

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
