<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\ecert\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$str =  $certType->event->event_name;
if(strlen($str) > 40){
    $str = substr($str, 0,37) . '...';
}
$this->title = $str;
$this->params['breadcrumbs'][] = ['label' => 'Event List', 'url' => ['/ecert/event']];
$this->params['breadcrumbs'][] = ['label' => $str, 'url' => ['/ecert/event/view', 'id' => $certType->event_id]];
$this->params['breadcrumbs'][] = ['label' => 'Cert Types', 'url' => ['/ecert/event-type', 'event' => $certType->event_id]];
$this->params['breadcrumbs'][] = 'Certificates';
?>
<div class="document-index">

    <?php
    // echo $this->render('_search', ['model' => $searchModel]); ?>


<h3><?php echo $certType->type_name?></h3>

    <p>
        <?=Html::a('Create Document', ['create'], ['class' => 'btn btn-success'])?>
    </p>
     <div class="box">
<div class="box-header"></div>
<div class="box-body">

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'
            ],
            'identifier',
            'participant_name',
            [
                'class' => 'yii\grid\ActionColumn'
            ]
        ]
    ]);
    ?>
</div>
</div>
</div>
