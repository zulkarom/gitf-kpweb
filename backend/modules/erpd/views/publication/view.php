<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Publication */

$this->title = 'View Publication';
$this->params['breadcrumbs'][] = ['label' => 'Publications', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upload';

$model->file_controller = 'publication';

?>



<?=$this->render('_view_all', ['model' => $model])?>




<?=Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Back to Publication List', ['/erpd/publication'],['class'=>'btn btn-default'])?>




