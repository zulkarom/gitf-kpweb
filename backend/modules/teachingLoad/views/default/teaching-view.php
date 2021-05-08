<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Teaching Information';
?>


<div class="box">
<div class="box-header">

</div>
<div class="box-body"><div class="application-view">

<div class="pull-right">
<?=Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['teaching-form'], ['class' => 'btn btn-primary'])?>
</div>


<style>
table.detail-view th {
    width:15%;
}
</style>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		[
				'label' => 'Submission Time',
				'format' => 'datetime',
				'value' => function($model){
					return $model->teaching_submit_at;
				}
				
			],
		[
				'label' => 'Staff Name',
				'value' => function($model){
					return $model->staff_title . ' ' . $model->user->fullname ;
				}
				
			],
          
			
			[
                'label' => 'Taught Courses',
				'format' => 'html',
                'value' => function($model){
					return $model->getTaughtCoursesStr("<br />");
                }
            ],
			
			
			[
                'label' => 'Courses Able to Teach',
				'format' => 'html',
                'value' => function($model){
					return $model->getTeachCoursesStr("<br />");
                }
            ],

        ],
    ]) ?>



</div>
</div>
</div>



