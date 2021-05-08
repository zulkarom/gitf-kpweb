<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Verification';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<div class="row">


<div class="col-md-7" align="right">

<?=$this->render('_search', ['model' => $searchModel, 'element' => 'courseverificationsearch-search_cat'])?>
</div>

</div>


    <div class="box box-primary">
<div class="box-header"></div>
<div class="box-body">



<?php

if(Yii::$app->params['faculty_id'] == 21 ){
	$cat = [
				'label' => 'Component',
				'value' => function($model){
					return $model->course->component->name;
				}
				
			];
}else{
	$cat = [
				'label' => 'Program',
				'value' => function($model){
					if($model->course->program){
						return $model->course->program->pro_name_short;
					}
					
				}
				
			];
}

echo GridView::widget([
         'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
		
            
			[
				'attribute' => 'course_name',
			//	'contentOptions' => ['style' => 'width: 45%'],
				'format' => 'html',
				'label' => 'Course Code & Name',
				'value' => function($model){
					$course = $model->course;
					return $course->course_code . ' ' . strtoupper($course->course_name) . '<br /><i>' . strtoupper($course->course_name_bi) . '</i>';
					
					
				}
				
			],
			
			[
                'label' => 'Version',
                
                'value' => function($model){
					return $model->version_name;
                }
            ],
			
			$cat ,
			

			[
                'label' => 'Submission By',
                'format' => 'html',
                'value' => function($model){
					if($model->preparedBy){
						return $model->preparedBy->staff->niceName . '<br /><i> at ' . date('d M Y', strtotime($model->prepared_at)) . '</i>';
					}
					
                }
            ],
			
			[
                'label' => 'Status',
                'format' => 'html',
                'value' => function($model){
					return $model->labelStatus;
					
                }
            ],
			
			[
                'label' => 'Verification',
                'format' => 'html',
                'value' => function($model){
					if($model->status == 20 and $model->verifiedBy){
						return $model->verifiedBy->staff->niceName . '<br /><i> at ' . date('d M Y', strtotime($model->verified_at)) . '</i>';
					}
					
                }
            ],
			
			
			
           
	
			
			
			[
                'label' => 'Report',
                'format' => 'raw',
                'value' => function($model){
					return $model->course->reportList('View', $model->id);
                    
                }
            ],
			
			['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-pencil"></span> Update',['verification-page', 'id' => $model->id],['class'=>'btn btn-primary btn-sm']);
                    },
                ],
            ],
			


            
        ],
    ]); ?></div>
</div>













</div>
