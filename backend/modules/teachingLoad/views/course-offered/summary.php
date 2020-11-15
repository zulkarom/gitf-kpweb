<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Teaching Summary';
$this->params['breadcrumbs'][] = $this->title;



$columns = [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                //'contentOptions' => ['style' => 'width: 45%'],
                //'format' => 'html',
                'label' => 'Staff No.',
                'value' => function($model){
                    return $model->staff_no ;
                }
                
            ],
            
            [
                //'contentOptions' => ['style' => 'width: 45%'],
                //'format' => 'html',
                'label' => 'Lecturers',
                'value' => function($model){
                    return $model->staff_title . ' ' . $model->user->fullname ;
                }
                
            ],
            
            [
                'label' => 'Lecture',
                'format' => 'html',
                'value' => function($model){
            
                    return $model->teaching_submit == 1 ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>';
                    
                }
            ],
           
            
            [
                'label' => 'Tutorial',
                'format' => 'html',
                'value' => function($model){
                    return $model->taughtCoursesStr;
                }
            ],
            
            
            [
                'label' => 'Total',
                'format' => 'html',
                'value' => function($model){
                    return $model->teachCoursesStr;
                }
            ],
            //PastExperiencesStr
            

            /* ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 9%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/course-admin/update/', 'course' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },

                ],
            
            ], */
        ];
?>
<div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
 
<br />

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            
            [
                //'contentOptions' => ['style' => 'width: 45%'],
                //'format' => 'html',
                'label' => 'Lecturers',
                'value' => function($model){
                    return $model->staff_title . ' ' . $model->user->fullname ;
                }
                
            ],
            [
                'label' => 'Lecture',
                'format' => 'html',
                'value' => function($model){
            
                    return $model->teaching_submit == 1 ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>';
                    
                }
            ],
            
            
            [
                'label' => 'Tutorial',
                'format' => 'html',
                'value' => function($model){
                    return $model->getTaughtCoursesStr("<br />");
                }
            ],
            
            [
                'label' => 'Total',
                'format' => 'html',
                'value' => function($model){
                    return $model->getTeachCoursesStr("<br />");
                }
            ],
            //PastExperiencesStr
            

            /* ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 9%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/course-admin/update/', 'course' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },

                ],
            
            ], */
        ],
    ]); ?></div>
</div>

</div>
