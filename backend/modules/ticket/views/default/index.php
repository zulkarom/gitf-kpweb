<?php

use yii\grid\GridView;
use yii\helpers\Html;
use backend\modules\ticket\models\Ticket;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\ticket\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">
    <div class="alert alert-default">
        A central platform where users can report issues, follow their ticket status, and communicate with support—making the entire process smoother and more transparent.<br />The issues should be limited to this system or within the jurisdiction of the faculty.
    </div>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> Create Ticket', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">My Tickets</h3>
        </div>
        <div class="box-body">
        <div class="table-responsive">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                    ],
                    
                    [
                        'attribute' => 'id',
                        'header' => 'Ticket ID',
                        'value' => function ($data) {
                            return '#' . $data->id;
                        },
                    ],
                    'title',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'filter' => Ticket::getStatusList(),
                        'value' => function ($model) {
                            return $model->getStatusLabel();
                        },
                    ],
                    [
                        'attribute' => 'priority',
                        'format' => 'raw',
                        'filter' => Ticket::getPriorityList(),
                        'value' => function ($model) {
                            return $model->getPriorityLabel();
                        },
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('View', $url, [
                                    'title' => Yii::t('yii', 'View'),
                                    'class' => 'btn btn-sm btn-primary',
                                ]);
                            }
                        ],
                    ],
        ],
    ]) ?>
    </div>
</div>
