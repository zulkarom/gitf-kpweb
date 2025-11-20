<?php

use yii\grid\GridView;
use yii\helpers\Html;
use backend\modules\ticket\models\Ticket;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\ticket\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Assigned Tickets';
$this->params['breadcrumbs'][] = ['label' => 'All Tickets', 'url' => ['/ticket/manage/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-manage-index">

    <div class="box box-solid">

        <div class="box-body">
            <div class="table-responsive">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'class' => 'yii\\grid\\SerialColumn',
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
                            'attribute' => 'created_by',
                            'label' => 'Send By',
                            'value' => function ($data) {
                                return $data->creator && $data->creator->fullname
                                    ? $data->creator->fullname
                                    : $data->created_by;
                            },
                        ],
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
                        [
                            'class' => 'yii\\grid\\ActionColumn',
                            'controller' => '/ticket/manage',
                            'template' => '{view}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('View', $url, [
                                        'title' => Yii::t('yii', 'View'),
                                        'class' => 'btn btn-sm btn-primary',
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
