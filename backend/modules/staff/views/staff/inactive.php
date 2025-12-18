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

    <?php
        $currentTab = $tab ?? 'inactive';
        $countStaffTab = (int)($tabCounts['staff'] ?? 0);
        $countOtherTab = (int)($tabCounts['other'] ?? 0);
        $countInactiveTab = (int)($tabCounts['inactive'] ?? 0);
    ?>

    <div class="box">
<div class="box-header with-border">
    <ul class="nav nav-tabs">
        <li class="<?= $currentTab === 'staff' ? 'active' : '' ?>">
            <a href="<?= Yii::$app->urlManager->createUrl(['/staff/staff/index']) ?>">Staff <span class="label label-primary"><?= $countStaffTab ?></span></a>
        </li>
        <li class="<?= $currentTab === 'other' ? 'active' : '' ?>">
            <a href="<?= Yii::$app->urlManager->createUrl(['/staff/staff/external']) ?>">Other Faculty <span class="label label-primary"><?= $countOtherTab ?></span></a>
        </li>
        <li class="<?= $currentTab === 'inactive' ? 'active' : '' ?>">
            <a href="<?= Yii::$app->urlManager->createUrl(['/staff/staff/inactive']) ?>">Transfered/Quit <span class="label label-primary"><?= $countInactiveTab ?></span></a>
        </li>
    </ul>
</div>
<div class="box-body">


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
                        return Html::a('Update',['/staff/staff/update-inactive/', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>
</div>

</div>
</div>
