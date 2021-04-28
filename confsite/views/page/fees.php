<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'FEES';
$this->params['breadcrumbs'][] = $this->title;

?>


<h4 class="m-text23 p-t-56 p-b-34">CONFERENCE FEES</h4>


<?=$this->render('_fees', ['model' => $model])?>