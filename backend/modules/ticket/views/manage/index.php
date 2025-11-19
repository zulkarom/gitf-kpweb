<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\ticket\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-manage-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
            'status',
            'priority',
            'created_by',
            'assigned_to',
            'created_at:datetime',
            [
                'class' => 'yii\\grid\\ActionColumn',
                'controller' => '/ticket/manage',
            ],
        ],
    ]) ?>
</div>
