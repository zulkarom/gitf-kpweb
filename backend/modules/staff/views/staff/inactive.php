<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\modules\staff\models\StaffPosition;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\staff\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transfered/Quit Staff';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-index">


    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'staff_no',
			[
				'attribute' => 'staff_name',
				'label' => 'Staff Name',
				'value' => function($model){
					if($model->user){
						return $model->staff_title . ' ' . $model->user->fullname;
					}
					
				}
				
			],
			[
				'attribute' => 'position_id',
				'filter' => Html::activeDropDownList($searchModel, 'position_id', ArrayHelper::map(StaffPosition::find()->where(['>', 'id',0])->all(),'id', 'position_name'),['class'=> 'form-control','prompt' => 'Choose Position']),
				'value' => function($model){
					return $model->staffPosition->position_name;
				}
				
			],
            
            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('RESTORE',['/staff/staff/restore/', 'id' => $model->id],['class'=>'btn btn-danger btn-sm']);
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>
</div>
