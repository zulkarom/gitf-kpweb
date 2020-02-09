<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Teaching Information';
?>


<div class="box">
<div class="box-header">

</div>
<div class="box-body"><div class="application-view">
<style>
table.detail-view th {
    width:15%;
}
</style>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		[
				'label' => 'Submitted Time',
				'format' => 'datetime',
				'value' => function($model){
					return $model->teaching_submit_at;
				}
				
			],
		[
				'label' => 'Staff Name & Designation',
				'value' => function($model){
					return $model->staff_title . ' ' . $model->user->fullname ;
				}
				
			],
            [
                'label' => 'Appointment Status',
                'value' => function($model){
			
					return $model->staffPositionStatus->status_cat;
                    
                }
            ],
			
			[
                'label' => 'Nationality',
                'value' => function($model){
			
					return $model->staffNationality->country_name;
                    
                }
            ],
			
			[
                'label' => 'Courses Taught',
				'format' => 'html',
                'value' => function($model){
					return $model->getTaughtCoursesStr("<br />");
                }
            ],
			
			[
                'label' => 'Courses Taught (Others)',
				'format' => 'html',
                'value' => function($model){
					return $model->getOtherTaughtCoursesStr("<br />");
                }
            ],
			
			[
                'label' => 'Academic Qualification',
				'format' => 'html',
                'value' => function($model){
					return $model->getHighAcademicQualification("<br />");
                }
            ],
			
		
			[
                'label' => 'Research Focus',
                'value' => function($model){
					return $model->research_focus;
                }
            ],
			
			[
                'label' => 'Past Work Experiences',
				'format' => 'html',
                'value' => function($model){
					return $model->getPastExperiencesStr("<br />");
                }
            ],
			
			[
                'label' => 'Four Courses Able to Teach',
				'format' => 'html',
                'value' => function($model){
					return $model->getTeachCoursesStr("<br />");
                }
            ],

        ],
    ]) ?>

<div class="pull-right">
<?=Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['teaching-form'], ['class' => 'btn btn-primary'])?>
</div>

</div>
</div>
</div>



