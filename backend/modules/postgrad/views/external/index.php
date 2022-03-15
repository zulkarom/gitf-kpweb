<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\ExternalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Externals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="external-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create External', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
     <div class="box">
<div class="box-header"></div>
<div class="box-body">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ex_name',
            'inst_name',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>


</div>
