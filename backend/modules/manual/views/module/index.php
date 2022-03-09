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

    <h1><?= Html::encode($this->title) ?></h1>

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
                'format' => 'html',
                'value' => function($model){
                    $section = $model->sections;
                    $html = '';
                    foreach($section as $s){
                        $html .= Html::a($s->section_name, ['/manual/title/index', 'section' => $s->id], ['class' => 'btn btn-primary btn-sm']) . ' ';
                    }
                    return $html;
                    
                }
                
            ],

 

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
