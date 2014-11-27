<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SVServiceTechSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Svservice Teches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="svservice-tech-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Svservice Tech', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Service_Tech_Id',
            'Emp_or_Vendor',
            'Employee_Id',
            'Vendor_Id',
            'Service_Company_Id',
            // 'Inactive',
            // 'Warehouse_Id',
            // 'Address_1',
            // 'GE_Table1_Id',
            // 'GE_Table2_Id',
            // 'GE_Table3_Id',
            // 'Country_Id',
            // 'Address_2',
            // 'Address_3',
            // 'GE_Table4_Id',
            // 'GE_Table5_Id',
            // 'Zip_Code_Plus4',
            // 'Service',
            // 'Installer',
            // 'RegularPayRate',
            // 'OvertimePayRate',
            // 'HolidayPayRate',
            // 'Expertise_Level',
            // 'Install_Company_id',
            // 'Text_Message_Address',
            // 'SageQuest_Driver',
            // 'rowguid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
