<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\KursusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Training List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kursus-index">

    <p>
        <?= Html::a('New Training', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
 <div class="box">
<div class="box-header"></div>
<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kursus_name',
            [
                'attribute' => 'kategori_id',
    			'label' => 'Category',
                'filter' => Html::activeDropDownList($searchModel, 'kategori_id', $searchModel->categoryList,['class'=> 'form-control','prompt' => 'Choose Status']),
                'value' => 'category.kategori_name',
            ],

            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>

</div>
