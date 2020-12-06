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

  <div class="row">
    <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header">
        </div>
          <div class="box-body">
            <table id="course">
                <thead>
                  <tr>
                    <th style="width:20%">Item Name</th>
                    <td>Example</td>
                  </tr>
                  <tr>
                    <th>Course Name</th>
                    <td>Example</td>
                  </tr>
                  <tr>
                    <th>Lecture Name</th>
                    <td>Example</td>
                  </tr>
                </thead>
              </table>
          </div>
        </div>
      </div>
    </div>

    <h1>SIJIL</h1>
      <div class="box">
        <div class="box-header"></div>
        <div class="box-body">


        <table class="table table-striped table-hover">

        <tbody>
          <?php 
          if($model->fasiFiles){
            foreach($model->fasiFiles as $file){
              $file->file_controller = 'certificate';
              ?>
              <tr>
                <td><?=Upload::fileInput($file, 'path', false, true)?></td>
              </tr>
              <?php
            }
          }
          
          ?>
        </tbody>
        </table>
        <br />
        <a href="<?=Url::to(['certificate/add'])?>" class="btn btn-default" ><span class="glyphicon glyphicon-plus"></span> Tambah Sijil</a>
        </div>
      </div>


<?php ActiveForm::end(); ?>
