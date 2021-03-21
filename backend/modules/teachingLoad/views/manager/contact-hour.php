<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\CourseOfferedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courses Contact Hour';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-offered-index">


    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'search_course', 
				'label' => 'Course',
				'format' => 'html',
				'value' => function($model){
				return $model->codeCourseString;

				}
				
			],
            [
				'attribute' => 'lec_hour', 
				'label' => 'Lecture Contact Hour',
				'value' => function($model){
					return $model->lec_hour;
				}
				
			],
			  [
				'attribute' => 'tut_hour', 
				'label' => 'Tutorial Contact Hour',
				'value' => function($model){
					return $model->tut_hour;
				}
				
			],

            [
                'label' => '',
                'format' => 'raw',
                'value' => function($model) use ($page, $perpage){
                    return ' <a href="javascript:void(0)" class ="btn btn-warning btn-sm modal-form" value="'.Url::to(['/teaching-load/manager/contact-hour-form', 'course' => $model->id, 'page' => $page, 'perpage' => $perpage]).'">
   Update
  </a>';
                }
            ]


        ],
    ]); ?></div>
</div>

</div>


<?php 

Modal::begin([
    'header' => '<h4>Update Contact Hour</h4>',
    'id' =>'modal-box',
    'size' => 'modal-sm'
]);

echo '<div id="modalContent"></div>';

Modal::end();

$this->registerJs('

$(function(){
  $(".modal-form").click(function(){
      $("#modal-box").modal("show")
        .find("#modalContent")
        .load($(this).attr("value"));
  });
});

');
        
        
        ?>

