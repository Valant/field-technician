<?php

    use yii\helpers\Html;
    use kartik\export\ExportMenu;


    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title                   = 'Login Stats';
    $this->params['breadcrumbs'][] = $this->title;


    $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
            'login_time',
            'logout_time',
            ['class' => 'yii\grid\ActionColumn'],
    ];

?>
<div class="login-stats-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php echo ExportMenu::widget([
                                              'dataProvider' => $dataProvider,
                                              'columns'      => $gridColumns
                                      ]); ?>
    </p>
    <?php echo \kartik\grid\GridView::widget([
                                                     'dataProvider' => $dataProvider,
                                                     'columns'      => $gridColumns
                                             ]); ?>
</div>
