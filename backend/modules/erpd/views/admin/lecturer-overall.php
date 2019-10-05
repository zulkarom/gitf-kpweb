<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
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
				'filter' => Html::activeDropDownList($searchModel, 'res_progress', $searchModel->progressArr(),['class'=> 'form-control','prompt' => 'All']),
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
<?php Pjax::begin(['id'=>'pjax_research']); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
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

<?php Pjax::begin(['id'=>'pjax_publication']); ?>
 <?= GridView::widget([
        'dataProvider' => $dataProviderPub,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        //'filterModel' => $searchPublication,
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



<div class="box">
<div class="box-header">
<div class="box-title">Membership</div>
</div>
<div class="box-body">    <?= GridView::widget([
        'dataProvider' => $dataProviderMsp,
       // 'filterModel' => $searchMembership,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					
					return '<a href="'.Url::to(['/erpd/membership/download-file', 'attr' => 'msp', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
				}
				
			],
			
            'msp_body',
			[
				'attribute' => 'msp_level',
				'filter' => Html::activeDropDownList($searchMembership, 'msp_level', $searchMembership->listLevel(),['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->levelName;
				}
			]
            ,
			
			[
				'attribute' => 'duration',
				'filter' => Html::activeDropDownList($searchMembership, 'duration', $searchMembership->listYears(),['class'=> 'form-control','prompt' => 'All']),
				'label' => 'Duration',
				'format' => 'html',
				'value' => function($model){
					if($model->date_end=='0000-00-00'){
						$end = 'No End';
					}else{
						$end = date('d/m/Y', strtotime($model->date_end));
					}
					return date('d/m/Y', strtotime($model->date_start)) . '<br />' . $end;
				}
				
			],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['/erpd/admin/view-membership', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
                        
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>



<div class="box">
<div class="box-header">
<div class="box-title">Award</div>
</div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProviderAwd,
        //'filterModel' => $searchAward,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					return '<a href="'.Url::to(['/erpd/award/download-file', 'attr' => 'awd', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
				}
				
			],
            'awd_name',
			[
				'attribute' => 'awd_level',
				'filter' => Html::activeDropDownList($searchAward, 'awd_level', $searchAward->listLevel(),['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->levelName;
				}
			]
            ,
			[
				'attribute' => 'awd_date',
				'filter' => Html::activeDropDownList($searchAward, 'duration', $searchAward->listYears(),['class'=> 'form-control','prompt' => 'All']),
				'format' => 'date',
			],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['/erpd/admin/view-award', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
                        
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>


<div class="box">
<div class="box-header">
<div class="box-title">Consultation</div>
</div>
<div class="box-body"> <?= GridView::widget([
        'dataProvider' => $dataProviderCsl,
        //'filterModel' => $searchConsultation,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					
					return '<a href="'.Url::to(['/erpd/consultation/download-file', 'attr' => 'csl', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
				}
				
			],
            'csl_title',
			
			[
				'attribute' => 'csl_level',
				'filter' => Html::activeDropDownList($searchConsultation, 'csl_level', $searchConsultation->listLevel(),['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->levelName;
				}
			]
            ,
            [
				'attribute' => 'duration',
				'filter' => Html::activeDropDownList($searchConsultation, 'duration', $searchConsultation->listYears(),['class'=> 'form-control','prompt' => 'All']),
				'label' => 'Duration',
				'format' => 'html',
				'value' => function($model){
					return date('d/m/Y', strtotime($model->date_start)) . '<br />' . date('d/m/Y', strtotime($model->date_end));
				}
				
			],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['/erpd/admin/view-consultation', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
                        
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>


 <div class="box">
<div class="box-header">
<div class="box-title">Knowledge Transfer Program</div>
</div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProviderKtp,
       // 'filterModel' => $searchKnowledgeTransfer,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					
					return '<a href="'.Url::to(['/erpd/knowledge-transfer/download-file', 'attr' => 'ktp', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
				}
				
			],
            'ktp_title',
			'ktp_community',
			
			
			[
				'attribute' => 'duration',
				'filter' => Html::activeDropDownList($searchKnowledgeTransfer, 'duration', $searchKnowledgeTransfer->listYears(),['class'=> 'form-control','prompt' => 'All']),
				'label' => 'Duration',
				'format' => 'html',
				'value' => function($model){
					return date('d/m/Y', strtotime($model->date_start)) . '<br />' . date('d/m/Y', strtotime($model->date_end));
				}
				
			]

            ,
            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['/erpd/admin/view-knowledge-transfer', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
                        
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
