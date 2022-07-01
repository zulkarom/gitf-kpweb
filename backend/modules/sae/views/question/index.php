<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Questions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

   <div class="box">
    <div class="box-body">

      <br />
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'que_text',
            'que_text_bi',
            [
                'attribute' => 'grade_cat',
                'value' => function($model){
                return $model->gradeCategory->gcat_text;
                
                }
                
                ],
            
            [
                'attribute' => 'display_cat',
                'value' => function($model){
                    return $model->questionCategory->cat_text;
                
                }
                
                ],
                
            

        ],
    ]); ?>

  </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>




</div>
