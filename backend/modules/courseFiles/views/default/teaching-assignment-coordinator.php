<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;



/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
$course = $offer->course;
$offered_id = $offer->id;
$this->title = 'Coordinator';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Load', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = $this->title;


?>


<div class="row">
<div class="col-md-6"><h4><?=$course->course_code . ' ' . $course->course_name?> - <?=$offer->semester->longFormat()?></h4></div>


</div>





<h4>Course Information & Teaching Material</h4>
<div class="box">


<div class="box-body">
<?php $form = ActiveForm::begin(); ?>

<table class="table">
<thead>

<tr>
<th width="5%">No.</th>
<th width="20%">Items</th>
<th>Select Version/Group</th>
<th>View</th>
<th>Update</th></tr>

</thead>

<tr>
<td>1. </td>
<td><b>Course Information Version</b></td>
<td><?= $form->field($offer, 'course_version')->dropDownList(ArrayHelper::map($offer->course->versions, 'id', 'version_name'), ['prompt' => 'Please Select'])->label(false) ?></td>
<td></td>
<td><a href="<?=Url::to(['/esiap/course/view-course', 'course' => $course->id])?>" class="btn btn-warning btn-sm" ><span class="fa fa-pencil"></span> Update</a></td>
</tr>

<tr>
<td>2. </td>
<td><b>Teaching Material Group</b></td>
<td><?= $form->field($offer, 'material_version')->dropDownList(ArrayHelper::map($offer->course->materials, 'id', 'material_name'),['prompt' => 'Please Select'])->label(false) ?></td>
<td></td>
<td><a href="<?=Url::to(['material/index', 'course' => $course->id])?>" class="btn btn-warning btn-sm" ><span class="fa fa-pencil"></span> Update</a></td></tr>

</table>

    
	
<div class="form-group">
        
<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span>  Save Course Information & Teaching Material', ['class' => 'btn btn-success btn-sm']) ?>
    </div>
	
	
	

    <?php ActiveForm::end(); ?>


</div>
</div>

<h4>Assessment Materials & Rubrics</h4>
<div class="box">

<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:75%">Item</th>
        <th style="width:10%">Files</th>
        <th>Action</th>
      </tr>
	  
	  </thead>
    
      <?php 
    
        if($model->assessMaterials){
        $i = 1;
          
            // foreach($model->assessMaterials as $item){
            $item = $model->assessMaterials;
              if($item[0]->coor_upload == 1){
                
                echo '<tr><td>'.$i.'. </td>
                  <td>'.$item[0]->item_bi.'</td>

                  <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[0]->item_bi.'</h5>',
                      'toggleButton' => ['label' => 'View Files ('.$offer->countRubricFiles.')', 'class'=>'btn btn-sm btn-info'],
                  ]);
                      echo '<table class="table">
                                <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Action</th>
                                </tr>';
                      if($offer->coordinatorRubricsFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorRubricsFiles as $files) {

                          
                          echo'<tr>
                          <td>'.$i.'.</td>
                          <td>';
                          echo $files->file_name;
                          echo'</td>
                                <td>';
                            
                                echo'<a href="'.Url::to(['coordinator-rubrics-file/download-file', 'attr' => 'path','id'=> $files->id]).'" target="_blank" class="btn btn-success btn-sm"><span class="fa fa-download"> Download</span></a>';
                                $i++;
                        }
                      }
                                echo'</td>
                                </tr>
                                </table>';
                       
                  Modal::end();
            echo'</td>';

                  echo'<td><a href="' . Url::to([$item[0]->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-warning btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>';

                  echo '<tr><td>'.$i.'. </td>
                  <td>'.$item[1]->item_bi.'</td>

                  <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[1]->item_bi.'</h5>',
                      'toggleButton' => ['label' => 'View Files ('.$offer->countAssessmentMaterialFiles.')', 'class'=>'btn btn-sm btn-info'],
                  ]);
                      
                      echo '<table class="table">
                                <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Action</th>
                                </tr>';
                      if($offer->coordinatorAssessmentMaterialFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorAssessmentMaterialFiles as $files) {

                          
                          echo'<tr>
                          <td>'.$i.'.</td>
                          <td>';
                          echo $files->file_name;
                          echo'</td>
                                <td>';

                                echo'<a href="'.Url::to(['coordinator-assessment-material-file/download-file', 'attr' => 'path','id'=> $files->id]).'" target="_blank" class="btn btn-success btn-sm"><span class="fa fa-download"> Download</span></a>';

                                $i++;
                        }
                      }
                                echo'</td>
                                </tr>
                                </table>';
                  Modal::end();
            echo'</td>';

                  echo'<td><a href="' . Url::to([$item[1]->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-warning btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>';

                  echo '<tr><td>'.$i.'. </td>
                  <td>'.$item[2]->item_bi.'</td>

                  <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[2]->item_bi.'</h5>',
                      'toggleButton' => ['label' => 'View Files ('.$offer->countSummativeAssessmentFiles.')', 'class'=>'btn btn-sm btn-info'],
                  ]);
                      
                      echo '<table class="table">
                                <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Action</th>
                                </tr>';
                      if($offer->coordinatorSummativeAssessmentFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorSummativeAssessmentFiles as $files) {

                          
                          echo'<tr>
                          <td>'.$i.'.</td>
                          <td>';
                          echo $files->file_name;
                          echo'</td>
                                <td>';
                                
                                echo'<a href="'.Url::to(['coordinator-summative-assessment-file/download-file', 'attr' => 'path','id'=> $files->id]).'" target="_blank" class="btn btn-success btn-sm"><span class="fa fa-download"> Download</span></a>';

                                $i++;
                        }
                      }
                                echo'</td>
                                </tr>
                                </table>';
                       
                  Modal::end();
            echo'</td>';

                  echo'<td><a href="' . Url::to([$item[2]->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-warning btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>';
         
                  $i++;
              }
            
            // }
          
        }
              ?>
   
   
  </table>
</div>
</div>


<h4>Assessment Final Result</h4>
<div class="box">

<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:75%">Item</th>
        <th style="width:10%">Files</th>
        <th>Action</th>
      </tr>
	  </thead>
	  
	  <?php 

         $i = 1;
          
            $item = $model->assessResults;
              if($item[0]->coor_upload == 1){
                
            echo '<tr><td>'.$i.'. </td>
                  <td>'.$item[0]->item_bi.'</td>

                  <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[0]->item_bi.'</h5>',
                      'toggleButton' => ['label' => 'View Files ('.$offer->countResultFinalFiles.')', 'class'=>'btn btn-sm btn-info'],
                  ]);
                      echo '<table class="table">
                                <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Action</th>
                                </tr>';
                      if($offer->coordinatorResultFinalFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorResultFinalFiles as $files) {

                          
                          echo'<tr>
                          <td>'.$i.'.</td>
                          <td>';
                          echo $files->file_name;
                          echo'</td>
                                <td>';
                            
                                echo'<a href="'.Url::to(['coordinator-result-final-file/download-file', 'attr' => 'path','id'=> $files->id]).'" target="_blank" class="btn btn-success btn-sm"><span class="fa fa-download"></span> Download</a>';
                                $i++;
                        }
                      }
                                echo'</td>
                                </tr>
                                </table>';
                       
                  Modal::end();
            echo'</td>';

                  echo'<td><a href="' . Url::to([$item[0]->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-warning btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>';

                 
         
                  $i++;
              }        
    ?>


    
      
   
   
  </table>
</div>
</div>

<h4>Assessment Scripts</h4>
<div class="box">

<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:75%">Item</th>
        <th style="width:10%">Files</th>
        <th>Action</th>
      </tr>
	  </thead>
	  
	  <?php 

         $i = 1;
          
            $item = $model->assessScripts;
              if($item[0]->coor_upload == 1){
                
            echo '<tr><td>'.$i.'. </td>
                  <td>'.$item[0]->item_bi.'</td>

                  <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[0]->item_bi.'</h5>',
                      'toggleButton' => ['label' => 'View Files ('.$offer->countAssessmentScriptFiles.')', 'class'=>'btn btn-sm btn-info'],
                  ]);
                      echo '<table class="table">
                                <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Action</th>
                                </tr>';
                      if($offer->coordinatorAssessmentScriptFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorAssessmentScriptFiles as $files) {

                          
                          echo'<tr>
                          <td>'.$i.'.</td>
                          <td>';
                          echo $files->file_name;
                          echo'</td>
                                <td>';
                            
                                echo'<a href="'.Url::to(['coordinator-assessment-script-file/download-file', 'attr' => 'path','id'=> $files->id]).'" target="_blank" class="btn btn-success btn-sm"><span class="fa fa-download"> Download</span></a>';
                                $i++;
                        }
                      }
                                echo'</td>
                                </tr>
                                </table>';
                       
                  Modal::end();
            echo'</td>';

                  echo'<td><a href="' . Url::to([$item[0]->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-warning btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>';

                  echo '<tr><td>'.$i.'. </td>
                  <td>'.$item[1]->item_bi.'</td>

                  <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[1]->item_bi.'</h5>',
                      'toggleButton' => ['label' => 'View Files ('.$offer->countAnswerScriptFiles.')', 'class'=>'btn btn-sm btn-info'],
                  ]);
                      echo '<table class="table">
                                <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Action</th>
                                </tr>';
                      if($offer->coordinatorAnswerScriptFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorAnswerScriptFiles as $files) {

                          
                          echo'<tr>
                          <td>'.$i.'.</td>
                          <td>';
                          echo $files->file_name;
                          echo'</td>
                                <td>';
                            
                                echo'<a href="'.Url::to(['coordinator-answer-script-file/download-file', 'attr' => 'path','id'=> $files->id]).'" target="_blank" class="btn btn-success btn-sm"><span class="fa fa-download"> Download</span></a>';
                                $i++;
                        }
                      }
                                echo'</td>
                                </tr>
                                </table>';
                       
                  Modal::end();
            echo'</td>';

                  echo'<td><a href="' . Url::to([$item[1]->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-warning btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>';
         
                  $i++;
              }        
    ?>


    
      
   
   
  </table>
</div>
</div>




<h4>Continuous Quality Improvement (CQI)</h4>
<div class="box">


<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:85%">Item</th>
        <th>Action</th>
      </tr>
    
        
        <tr>
        <?php 
                echo '<tr><td>'.$i.'</td>
                  <td>Plan for Course Improvement (if any)</td>
                  <td><a href="' . Url::to(['coordinator/course-cqi','id' => $offered_id]) . '" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-pencil"></span> Update</a></td>';
         
              ?>
      </tr>
    </thead>
   
  </table>
</div>
</div>




