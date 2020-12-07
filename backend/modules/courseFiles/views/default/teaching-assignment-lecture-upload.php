<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Upload File';
$this->params['breadcrumbs'][] = $this->title;
?>

 <style>
#course {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#course td, #course th {
  border: 1px solid #ddd;
  padding: 8px;
}

#course tr:nth-child(even){background-color: #f2f2f2;}

#course tr:hover {background-color: #ddd;}

#course th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
}
</style>


<?php $form = ActiveForm::begin(); ?>

  <div class="box box-primary">
<div class="box-header">
  <div class="box-title"><b>Item Name</b>
  </div>
</div>
<div class="box-body">
  <table id="course">
    <thead>
      <tr>
        <th style="width:8%">Course Name</th>
        <td></td>
      </tr>
      <tr>
        <th style="width:8%">Lecture Name</th>
        <td></td>
      </tr>
      <tr>
        
        <tr>
        
      </tr>
    </thead>
   
  </table>
</div>




<?php ActiveForm::end(); ?>
