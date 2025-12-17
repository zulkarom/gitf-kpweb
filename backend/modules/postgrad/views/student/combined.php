<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\StudentPostGradSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $tab string */

$this->title = isset($title) ? $title : 'Postgraduate Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-post-grad-combined">
    <p>
        <?= Html::a('Go to Student List', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
