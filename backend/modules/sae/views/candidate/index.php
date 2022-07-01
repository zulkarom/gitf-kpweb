<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use backend\modules\sae\models\Common;
use yii\helpers\ArrayHelper;
use backend\modules\sae\models\Batch;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CandidateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Candidates';
$this->params['breadcrumbs'][] = $this->title;

$dirAssests = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
?>

<div class="row">
    <div class="col-2">
        <p>
            <?php echo Html::button('<span class="fa fa-plus"></span> NEW CANDIDATE', ['value' => Url::to(['/candidate/create']), 'class' => 'btn btn-success', 'id' => 'modalBttnCandidate']);

            

            $this->registerJs('
                $(function(){
                  $("#modalBttnCandidate").click(function(){
                      $("#candidate").modal("show")
                        .find("#formCandidate")
                        .load($(this).attr("value"));
                  });
                });

               
            ');

            Modal::begin([
                    'title' => '<h4>New Candidate</h4>',
                    'id' =>'candidate',
                    'size' => 'modal-lg'
                ]);

            echo '<div id="formCandidate"></div>';

            Modal::end();

            

            ?>
        </p>
    </div>
    <div class="col-4">
        <a href="file/offline.xls" target="_blank">Download Offline Excel Question</a>
    </div>
</div>





<div class="candidate-index">

    <div class="card card-primary card-outline">
        <div class="card-body">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'raw',
                'attribute' => 'can_name',
                'value' => function($model){
                    return Html::a($model->can_name.'<span class="glyphicon glyphicon-pencil"></span>', ['/candidate/update', 'id' => $model->id], ['class' => 'modalBttnUptCandidate']);
                }
            ],
            'username',
            [
                'format' => 'html',
                'attribute' => 'can_batch',
                'filter' => Html::activeDropDownList($searchModel, 'can_batch', ArrayHelper::map(Batch::find()->all(),'id', 'batch_text'), ['class'=> 'form-control','prompt' => 'Select Batch']),
                'value' => function($model){
                    if($model->batch){
                       return $model->batch->bat_text; 
                    }
                }
            ], 
            [
                'format' => 'html',
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'answer_status', Common::status() ,['class'=> 'form-control','prompt' => 'Select Status']),
                'value' => function($model){
                    return $model->statusText;
                }
            ],
            [
                'attribute' => 'finished_at',
                // 'label' => 'finished_at',
                'value' => function($model){
                    if($model->finished_at){
                        return date('d M Y h:i:s', $model->finished_at);
                    }
                    else{
                        return "-";
                    }
                }
            ],
            [
                'format' => 'raw',
                'label' => 'Excel Psychometric',
                'value' => function($model){
                    return Html::button('Upload Answer', ['value' => Url::to(['/candidate/upload-answer']), 'class' => 'btn btn-success btn-sm', 'id' => 'modalBttnAnswer']);
                }
            ],
            
            

            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{delete}',
                //'visible' => false,
                'buttons'=>[
                    'delete'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-trash"></span>',['individual-result', 'id' => $model->id],['class'=>'btn btn-danger btn-sm']);
                    },
                ],
            
            ],
        ],
    ]); ?>

</div>
</div>


</div>


<?php 
$this->registerJs('
    $(function(){
      $("#modalBttnAnswer").click(function(){
          $("#answer").modal("show")
            .find("#formAnswer")
            .load($(this).attr("value"));
      });
    });

    $("#modalBttnUptCandidate").click(function(){
      $("#uptCandidate").modal("show")
        .find("#formUptCandidate")
        .load($(this).attr("value"));
    });
');

Modal::begin([
        'title' => '<h4>UPLOAD ANSWERS</h4>',
        'id' =>'answer',
        'size' => 'modal-lg'
    ]);

echo '<div id="formAnswer"></div>';

Modal::end();

Modal::begin([
        'title' => '<h4>Edit Candidate</h4>',
        'id' =>'uptCandidate',
        'size' => 'modal-md'
    ]);

echo '<div id="formUptCandidate"></div>';

Modal::end();

?>