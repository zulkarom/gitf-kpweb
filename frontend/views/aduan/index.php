<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aduan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aduan-index">
     <section class="contact-page spad pt-0">
        <div class="container">

    

    <p>
        <?= Html::a('Create Aduan', ['create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Check Status', ['check'], ['class' => 'btn btn-info']) ?>
    </p>

    <!-- <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'nric',
            'address:ntext',
            'email:email',
            //'phone',
            //'topic_id',
            //'title',
            //'aduan:ntext',
            //'declaration',
            //'upload_url:ntext',
            //'captcha',
            //'progress_id',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?> -->
     </div>
    </section>
</div>


