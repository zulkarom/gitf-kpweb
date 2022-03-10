<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\manual\models\Section;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Modules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="module-index">


    <p>
        <?= Html::a('Create Module', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'module_name',
            [
			'label' => 'Section',
                'format' => 'raw',
                'value' => function($model){

                    $section = $model->sections;
                    $html = '';
                    if($section){
                        echo '<ul>';
                            foreach($section as $s){
                                $html .= '<li>' . Html::a($s->section_name, ['/manual/title/index', 'section' => $s->id]) . '</li>';
                            }
                        echo '</ul>';
                    }
                    return $html;
                    
                }
                
            ],

 

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
