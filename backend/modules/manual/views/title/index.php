<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\manual\models\TitleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Titles: ' . $section->module->module_name . ' - ' . $section->section_name;
$this->params['breadcrumbs'][] = 'Titles';
?>
<div class="title-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Title', ['create', 'section' => $section->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title_text',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
