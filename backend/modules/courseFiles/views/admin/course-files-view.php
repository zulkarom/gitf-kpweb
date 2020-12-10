<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Course Files';
$this->params['breadcrumbs'][] = $this->title;
$course = $modelOffer->course; 
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
  background-color: #3c8dbc;
  color: white;
}

</style>
<?php                 
    Modal::begin([
      'header' => $course->course_code.' '.$course->course_name,
      'id' => 'your-modal',
      'size' => 'modal-md',
    ]);
      echo "";
      Modal::end();
?>

<div class="teaching-assignment-course-file">
<?php $form = ActiveForm::begin(); ?>


<div class="box box-primary">
<div class="box-header">
  <div class="box-title"><b>Peringkat Perancangan/Planning Level
    <br/><div class="box-title">(PLAN)</b></div>
</div>
</div>
<div class="box-body">
<table id="course">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:85%">Item</th>
        <th>Action</th>
      </tr>
    
        
        <tr>
        <?php 
    
       $item = $model->itemPlan;
          
          echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td></td>';
       
          echo '<tr><td>'.$item[1]->id.'</td>
                <td>'.$item[1]->item.'<i><br/>'.$item[1]->item_bi.'</i></td>
                <td></td>';

          echo '<tr><td>'.$item[2]->id.'</td>
                <td>'.$item[2]->item.'<i><br/>'.$item[2]->item_bi.'</i></td>
                <td></td>';

          echo '<tr><td>'.$item[3]->id.'</td>
                <td>'.$item[3]->item.'<i><br/>'.$item[3]->item_bi.'</i></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[3]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      $offer =  $modelOffer;
                      if($offer->coordinatorRubricsFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorRubricsFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-rubrics-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
                  Modal::end();
          echo'</td>';

          echo '<tr><td>'.$item[4]->id.'</td>
                <td>'.$item[4]->item.'<i><br/>'.$item[4]->item_bi.'</i></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[4]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      $offer =  $modelOffer;
                      if($offer->coordinatorMaterialFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorMaterialFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-material-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
                  Modal::end();
          echo '</td>';

          echo '<tr><td>'.$item[5]->id.'</td>
                <td>'.$item[5]->item.'<i><br/>'.$item[5]->item_bi.'</i></td>
                <td></td>';

          echo '<tr><td>'.$item[6]->id.'</td>
                <td>'.$item[6]->item.'<i><br/>'.$item[6]->item_bi.'</i></td>
                <td></td>';
              ?>
      </tr>
    </thead>
  </table>

</div>
<div class="box-header">
  <div class="box-title"><b>Peringkat Pelaksanaan/ Implementation Level
    <br/><div class="box-title">(DO)</b></div>
</div>
</div>
<div class="box-body">

  <table id="course">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:85%">Item</th>
        <th>Action</th>
      </tr>
    
        
        <tr>
        <?php 
    
        $item = $model->itemDo;
        
          echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td></td>';


          echo '<tr><td>'.$item[1]->id.'</td>
                <td>'.$item[1]->item.'<i><br/>'.$item[1]->item_bi.'</i></td>
                <td></td>';

          echo '<tr><td>'.$item[2]->id.'</td>
                <td>'.$item[2]->item.'<i><br/>'.$item[2]->item_bi.'</i></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[2]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);

                 
                  echo '<table>
                        <tr>
                        <th style="width:15%">Lectures</th>
                        <th style="width:85%">Files</th>
                        </tr>
                        ';
                            $offer =  $modelOffer;
                            if($offer->lectures)
                            {
                              $i=1;
                              foreach ($offer->lectures as $lectures) {
                        echo '<tr>
                        <td>';
                                echo $lectures->lec_name;                           
                        echo'</td>
                        <td>';
                                $j=1;
                                if($lectures->lectureCancelFiles){
                                  foreach ($lectures->lectureCancelFiles as $files) {
                                  
                                    echo Html::a("File ".$j, ['lecture-cancel-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                                    echo '<br/>';
                                    $j++;
                                  }
                                } 
                                $i++;
                              }
                            }
                        echo'</td></tr></table><br/>';

                        echo '<table>
                        <tr>
                        <th style="width:15%">Tutorials</th>
                        <th style="width:85%">Files</th>
                        </tr>';
                            $offer =  $modelOffer;
                            if($offer->lectures)
                            {
                              $i=1;
                              foreach ($offer->lectures as $lectures) {
                                if($lectures->tutorials){
                                  foreach ($lectures->tutorials as $tutorial) {
                        echo '<tr>
                        <td>';
                                echo $lectures->lec_name.''.$tutorial->tutorial_name;                           
                        echo'</td>
                        <td>';
                                $j=1;
                                    if($tutorial->tutorialCancelFiles){
                                      foreach ($tutorial->tutorialCancelFiles as $files) {
                                        echo Html::a("File ".$j, ['tutorial-cancel-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                                        echo '<br/>';
                                        $j++;
                                      }
                                    }
                                    $i++;
                                  }
                                } 
                              }
                            }
                            echo'</td></tr></table>';
                  Modal::end();

                        
          echo '</td>';

          echo '<tr><td>'.$item[3]->id.'</td>
                <td>'.$item[3]->item.'<i><br/>'.$item[3]->item_bi.'</i></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[3]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);

                 
                  echo '<table>
                        <tr>
                        <th style="width:15%">Lectures</th>
                        <th style="width:85%">Files</th>
                        </tr>
                        ';
                            $offer =  $modelOffer;
                            if($offer->lectures)
                            {
                              $i=1;
                              foreach ($offer->lectures as $lectures) {
                        echo '<tr>
                        <td>';
                                echo $lectures->lec_name;                           
                        echo'</td>
                        <td>';
                                $j=1;
                                if($lectures->lectureReceiptFiles){
                                  foreach ($lectures->lectureReceiptFiles as $files) {
                                  
                                    echo Html::a("File ".$j, ['lecture-receipt-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                                    echo '<br/>';
                                    $j++;
                                  }
                                } 
                                $i++;
                              }
                            }
                        echo'</td></tr></table><br/>';

                        echo '<table>
                        <tr>
                        <th style="width:15%">Tutorials</th>
                        <th style="width:85%">Files</th>
                        </tr>';
                            $offer =  $modelOffer;
                            if($offer->lectures)
                            {
                              $i=1;
                              foreach ($offer->lectures as $lectures) {
                                if($lectures->tutorials){
                                  foreach ($lectures->tutorials as $tutorial) {
                        echo '<tr>
                        <td>';
                                echo $lectures->lec_name.''.$tutorial->tutorial_name;                           
                        echo'</td>
                        <td>';
                                $j=1;
                                    if($tutorial->tutorialReceiptFiles){
                                      foreach ($tutorial->tutorialReceiptFiles as $files) {
                                        echo Html::a("File ".$j, ['tutorial-receipt-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                                        echo '<br/>';
                                        $j++;
                                      }
                                    }
                                    $i++;
                                  }
                                } 
                              }
                            }
                            echo'</td></tr></table>';
                  Modal::end();

                        
          echo '</td>';

          echo '<tr><td>'.$item[4]->id.'</td>
                <td>'.$item[4]->item.'<i><br/>'.$item[4]->item_bi.'</i></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[4]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      $offer =  $modelOffer;
                      if($offer->coordinatorAssessmentMaterialFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorAssessmentMaterialFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-assessment-material-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
                  Modal::end();
          echo '</td>';

          echo '<tr><td>'.$item[5]->id.'</td>
                <td>'.$item[5]->item.'<i><br/>'.$item[5]->item_bi.'</i></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[5]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      $offer =  $modelOffer;
                      if($offer->coordinatorAssessmentScriptFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorAssessmentScriptFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-assessment-script-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
                  Modal::end();
          echo '</td>';

          echo '<tr><td>'.$item[6]->id.'</td>
                <td>'.$item[6]->item.'<i><br/>'.$item[6]->item_bi.'</i></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[6]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      $offer =  $modelOffer;
                      if($offer->coordinatorSummativeAssessmentFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorSummativeAssessmentFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-summative-assessment-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
                  Modal::end();
          echo '</td>';

          echo '<tr><td>'.$item[7]->id.'</td>
                <td>'.$item[7]->item.'<i><br/>'.$item[7]->item_bi.'</i></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[7]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      $offer =  $modelOffer;
                      if($offer->coordinatorAnswerScriptFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorAnswerScriptFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-answer-script-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
                  Modal::end();
          echo '</td>';

          echo '<tr><td>'.$item[8]->id.'</td>
                <td>'.$item[8]->item.'<i><br/>'.$item[8]->item_bi.'</i></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[8]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);

                 
                  echo '<table>
                        <tr>
                        <th style="width:15%">Lectures</th>
                        <th style="width:85%">Files</th>
                        </tr>
                        ';
                            $offer =  $modelOffer;
                            if($offer->lectures)
                            {
                              $i=1;
                              foreach ($offer->lectures as $lectures) {
                        echo '<tr>
                        <td>';
                                echo $lectures->lec_name;                           
                        echo'</td>
                        <td>';
                                $j=1;
                                if($lectures->lectureExemptFiles){
                                  foreach ($lectures->lectureExemptFiles as $files) {
                                  
                                    echo Html::a("File ".$j, ['lecture-exempt-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                                    echo '<br/>';
                                    $j++;
                                  }
                                } 
                                $i++;
                              }
                            }
                        echo'</td></tr></table><br/>';

                        echo '<table>
                        <tr>
                        <th style="width:15%">Tutorials</th>
                        <th style="width:85%">Files</th>
                        </tr>';
                            $offer =  $modelOffer;
                            if($offer->lectures)
                            {
                              $i=1;
                              foreach ($offer->lectures as $lectures) {
                                if($lectures->tutorials){
                                  foreach ($lectures->tutorials as $tutorial) {
                        echo '<tr>
                        <td>';
                                echo $lectures->lec_name.''.$tutorial->tutorial_name;                           
                        echo'</td>
                        <td>';
                                $j=1;
                                    if($tutorial->tutorialExemptFiles){
                                      foreach ($tutorial->tutorialExemptFiles as $files) {
                                        echo Html::a("File ".$j, ['tutorial-exempt-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                                        echo '<br/>';
                                        $j++;
                                      }
                                    }
                                    $i++;
                                  }
                                } 
                              }
                            }
                            echo'</td></tr></table>';
                  Modal::end();

                        
          echo '</td>';
        ?>
    
      </tr>
    </thead>
   
  </table>
</div>

<div class="box-header">
  <div class="box-title"><b>Peringkat Semak/ Evaluation Level
     <br/><div class="box-title">(CHECK)</b></div>
</div>
</div>
<div class="box-body">
  <table id="course">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:85%">Item</th>
        <th>Action</th>
      </tr>
    
        
        <tr>
        <?php 
    
        $item = $model->itemCheck;

        echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[0]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      $offer =  $modelOffer;
                      if($offer->coordinatorAssessResultFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorAssessResultFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-assess-result-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
                  Modal::end();
          echo '</td>';

        echo '<tr><td>'.$item[1]->id.'</td>
                <td>'.$item[1]->item.'<i><br/>'.$item[1]->item_bi.'</i></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[1]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      $offer =  $modelOffer;
                      if($offer->coordinatorEvaluationFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorEvaluationFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-evaluation-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
                  Modal::end();
          echo '</td>';
        
        
        echo '<tr><td>'.$item[2]->id.'</td>
                <td>'.$item[2]->item.'<i><br/>'.$item[2]->item_bi.'</i></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[2]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      $offer =  $modelOffer;
                      if($offer->coordinatorResultCloFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorResultCloFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-result-clo-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
                  Modal::end();
          echo '</td>';


        echo '<tr><td>'.$item[3]->id.'</td>
                <td>'.$item[3]->item.'<i><br/>'.$item[3]->item_bi.'</i></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[3]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      $offer =  $modelOffer;
                      if($offer->coordinatorAnalysisCloFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorAnalysisCloFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-analysis-clo-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
                  Modal::end();
          echo '</td>';
        
        ?>
      </tr>
    </thead>
   
  </table>
</div>

<div class="box-header">
  <div class="box-title"><b>Peringkat Tindakan/ Review Level
    <br/><div class="box-title">(ACT)</b></div>
</div>
</div>
<div class="box-body">
  <table id="course">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:85%">Item</th>
        <th>Action</th>
      </tr>
    
        
        <tr>
        <?php 
    
        $item = $model->itemAct;
        
        echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[0]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      $offer =  $modelOffer;
                      if($offer->coordinatorImproveFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorImproveFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-improve-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
                  Modal::end();
          echo '</td>';

        ?>
      </tr>
    </thead>
   
  </table>
</div>

</div>

</div>




</div>
<?php ActiveForm::end(); ?>


</div>

<?php
$js = "

$('#BtnModalId').click(function(e){    

    e.preventDefault();

    $('#your-modal').modal('show')

        .find('#modalContent')

        .load($(this).attr('value'));

   return false;

});



";

$this->registerJs($js);


?>

