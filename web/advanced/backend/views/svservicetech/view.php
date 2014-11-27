<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SVServiceTech */

$this->title = $model->Service_Tech_Id;
$this->params['breadcrumbs'][] = ['label' => 'Svservice Teches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="svservice-tech-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->Service_Tech_Id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->Service_Tech_Id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Service_Tech_Id',
            'Emp_or_Vendor',
            'Employee_Id',
            'Vendor_Id',
            'Service_Company_Id',
            'Inactive',
            'Warehouse_Id',
            'Address_1',
            'GE_Table1_Id',
            'GE_Table2_Id',
            'GE_Table3_Id',
            'Country_Id',
            'Address_2',
            'Address_3',
            'GE_Table4_Id',
            'GE_Table5_Id',
            'Zip_Code_Plus4',
            'Service',
            'Installer',
            'RegularPayRate',
            'OvertimePayRate',
            'HolidayPayRate',
            'Expertise_Level',
            'Install_Company_id',
            'Text_Message_Address',
            'SageQuest_Driver',
            'rowguid',
        ],
    ]) ?>

</div>
