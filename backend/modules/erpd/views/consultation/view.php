<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Upload;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Publication */

$this->title = 'View Consultation';
$this->params['breadcrumbs'][] = ['label' => 'Research', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View';

?>


<?=$this->render('_view_all', [
			'model' => $model
	])?>


