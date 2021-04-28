<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'IMPORTANT DATES';
$this->params['breadcrumbs'][] = $this->title;
?>
<h4 class="m-text23 p-t-56 p-b-34">IMPORTANT DATES</h4>
<div class="item-blog-txt">

<?php 
echo $this->render('_dates', [
        'model' => $model,
    ]) 
	
?>
</div>