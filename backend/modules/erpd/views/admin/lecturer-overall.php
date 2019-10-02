<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\modules\erpd\models\PubType;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\ResearchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report: ' . $staff->staff_title . ' ' . $staff->user->fullname;
$this->params['breadcrumbs'][] = 'report';


$colums = [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					
					return '<a href="'.Url::to(['/erpd/research/download-file', 'attr' => 'res', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
				}
				
			],
			[
                'attribute' => 'res_title',
				'label' => 'Title',
                'format' => 'html',
                'contentOptions' => [ 'style' => 'width: 50%;' ],
				'value' => function($model){
					return '<i>' . $model->res_title . '<br />' . '<span class="fa fa-user"></span> ' . $model->leader . '</i>';
				}
            ],
			[
				'attribute' => 'duration',
				'filter' => Html::activeDropDownList($searchModel, 'duration', $searchModel->listYears(),['class'=> 'form-control','prompt' => 'All']),
				'label' => 'Duration',
				'format' => 'html',
				'value' => function($model){
					return date('d/m/Y', strtotime($model->date_start)) . '<br />' . date('d/m/Y', strtotime($model->date_end));
				}
				
			],
			[
				'attribute' => 'res_grant',
				'filter' => Html::activeDropDownList($searchModel, 'res_grant', $searchModel->listGrants(),['class'=> 'form-control','prompt' => 'All']),
				'label' => 'Grant',
				'value' => function($model){
					if($model->researchGrant){
						return $model->researchGrant->gra_abbr . ' RM' . number_format($model->res_amount,2);
					}
					
				}
				
			],
			[
				'attribute' => 'res_progress',
				'filter' => Html::activeDropDownList($searchModel, 'res_grant', $searchModel->progressArr(),['class'=> 'form-control','prompt' => 'All']),
				'format' => 'html',
				'value' => function($model){
					return $model->showProgress();
				}
			],
          
       
            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['/erpd/admin/view-research', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
                        
                    }
                ],
            
            ],

        ];


?>
<div class="research-index">


  <div class="box">
<div class="box-header">
<div class="box-title">
Research
</div>
</div>
<div class="box-body"> <div class="table-responsive"> 
<?php Pjax::begin();?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'options' => [ 'style' => 'table-layout:fixed;' ],
		
        'columns' => $colums,
    ]); ?>
<?php Pjax::end();?>
	
	</div></div>
</div>
</div>


<div class="box">
<div class="box-header">
<div class="box-title">Publication</div>
</div>
<div class="box-body">  

<?php Pjax::begin();?>
 <?= GridView::widget([
        'dataProvider' => $dataProviderPub,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        'filterModel' => $searchPublication,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					
					return '<a href="'.Url::to(['/erpd/publication/download-file', 'attr' => 'pubupload', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
				}
				
			],
			[
				'attribute' => 'pub_year',
				'contentOptions' => [ 'style' => 'width: 10%;' ],
				'filter' => Html::activeDropDownList($searchPublication, 'pub_year', $searchPublication->myUniqueYear(),['class'=> 'form-control','prompt' => 'All']),
			],
            [
				'attribute' => 'pub_type',
				'filter' => Html::activeDropDownList($searchPublication, 'pub_type', ArrayHelper::map(PubType::find()->all(), 'id','type_name'),['class'=> 'form-control','prompt' => 'Choose Type']),
				'value' => function($model){
					return $model->pubType->type_name;
				},
				'label' => 'Type'
			],
            
			[
                'attribute' => 'pub_title',
                'format' => 'html',
				'value' => function($model){
					return $model->showApaStyle();
				},
                'contentOptions' => [ 'style' => 'width: 60%;' ],
            ],
			

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['/erpd/admin/view-publication', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
                       
                    }
                ],
            
            ],

        ],
    ]); ?>
	<?php Pjax::end();?>
	
	</div>
</div>


