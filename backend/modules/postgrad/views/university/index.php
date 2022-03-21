<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Universities / Institution';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add University / Institution', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
     <div class="box">
<div class="box-header"></div>
<div class="box-body">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'uni_name',
            'uni_name_en',
            'uni_abbr',
            'type',
            //'thrust',
            //'main_location',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>


</div>
