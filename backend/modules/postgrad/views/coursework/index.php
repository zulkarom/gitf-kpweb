<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use backend\modules\courseFiles\models\Common;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\CourseOfferedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Coursework';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div class="col-md-10" align="right">
        <?= $this->render('_form_semester', [
                'model' => $semester,
            ]) ?>
    </div>
</div>
<div class="course-files-default-index">


<div class="box">
<div class="box-header"></div>
<div class="box-body">  




</div>
</div>
</div>

    
