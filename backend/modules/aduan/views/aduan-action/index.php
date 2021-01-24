<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\aduan\models\AduanActionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aduan Actions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aduan-action-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Aduan Action', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'aduan_id',
            'created_at',
            'updated_at',
            'created_by',
            //'title',
            //'action_text:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
