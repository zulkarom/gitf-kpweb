<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel student\models\KursusPesertaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pendaftaran Kursus';
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?php echo Html::button('Daftar Kursus', ['value' => Url::to(['create']), 'class' => 'btn btn-success', 'id' => 'modalBttnKursus']);
    
        Modal::begin([
            'title' => '<h4>Lihat Kursus Kategori</h4>',
            'id' =>'createKursus',
            'size' => 'modal-lg'
        ]);

    echo '<div id="formCreateKursus"></div>';

    Modal::end();

    $this->registerJs('
    $(function(){
      $("#modalBttnKursus").click(function(){
          $("#createKursus").modal("show")
            .find("#formCreateKursus")
            .load($(this).attr("value"));
      });
    });
    ');


    ?>
</p>

<div class="card">
<div class="card-body"> 
<div class="kursus-peserta-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
             'label' => 'Kursus',
             'value' => function($model){
                return $model->kursusAnjur->kursus->kursus_name.' - '.$model->kursusAnjur->kursus_siri;
             }
            ],
            [
             'format' => 'html',
             'label' => 'Status',
             'value' => function($model){
                if($model->status == 10){
                    return '<span class="label label-info">'.$model->statusText.'</span>';
                }else if($model->status == 20){
                    return '<span class="label label-primary">'.$model->statusText.'</span>';
                }else if($model->status == 30){
                    return '<span class="label label-success">'.$model->statusText.'</span>';
                }else{
                    return '<span class="label label-danger">'.$model->statusText.'</span>';
                }
             }
            ],
            'submitted_at:datetime',

            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 18%'],
                'template' => '{view}',
                //'visible' => false,
                'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-eye"></span> View',['view', 'id' => $model->id],['class'=>'btn btn-primary btn-sm']);
                }
                ],
                
                ],
        ],
    ]); ?>
</div>
</div>
</div>