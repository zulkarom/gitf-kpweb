<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>


<div class="box-header">
  <div class="box-title"><b>Peringkat Pelaksanaan/ Implementation Level
    <br/><div class="box-title">(DO)</b></div>
</div>
</div>
<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:85%">Item</th>
        <th style="width:10%">Files</th>
        <th>Action</th>
      </tr>
    
        
        <tr>
        <?php 
    
        $item = $model->itemDo;
        $offer =  $modelOffer;
        $totalCancelFiles = $offer->countLecCancelFiles+$offer->countTutCancelFiles;
        $totalExemptFiles = $offer->countLecExemptFiles+$offer->countTutExemptFiles;
        $totalReceiptFiles = $offer->countLecReceiptFiles+$offer->countTutReceiptFiles;

        
          echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td></td>
                <td></td>';


          echo '<tr><td>'.$item[1]->id.'</td>
                <td>'.$item[1]->item.'<i><br/>'.$item[1]->item_bi.'</i></td>
                <td></td>
                <td></td>';

          echo '<tr><td>'.$item[2]->id.'</td>
                <td>'.$item[2]->item.'<i><br/>'.$item[2]->item_bi.'</i></td>
                <td>'.$totalCancelFiles.'</td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[2]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);

                 
                  echo '<table>
                        <tr>
                        <th style="width:13%">Lectures</th>
                        <th style="width:75%">Lecturer</th>
                        <th style="width:22%">Files</th>
                        </tr>
                        ';
                            
                            if($offer->lectures)
                            {
                              $i=1;
                              foreach ($offer->lectures as $lectures) {
                        echo '<tr>
                        <td>';   
                                echo $lectures->lec_name;                                                        
                        echo'</td>
                        <td>';

                                if($lectures->lecturers)
                                {
                                  foreach ($lectures->lecturers as $lecturer) {
                                  echo $lecturer->staff->staff_title . ' ' .$lecturer->staff->user->fullname.'<br/>';
                                  }
                                }

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
                        <th style="width:13%">Tutorials</th>
                        <th style="width:75%">Tutor</th>
                        <th style="width:22%">Files</th>
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

                                if($tutorial->tutors)
                                {
                                  foreach ($tutorial->tutors as $tutor) {
                                  echo $tutor->staff->staff_title . ' ' .$tutor->staff->user->fullname.'<br/>';
                                  }
                                }

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
                <td>'.$totalReceiptFiles.'</td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[3]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);

                 
                  echo '<table>
                        <tr>
                        <th style="width:13%">Lectures</th>
                        <th style="width:75%">Lecturer</th>
                        <th style="width:22%">Files</th>
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

                                if($lectures->lecturers)
                                {
                                  foreach ($lectures->lecturers as $lecturer) {
                                  echo $lecturer->staff->staff_title . ' ' .$lecturer->staff->user->fullname.'<br/>';
                                  }
                                }

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
                        <th style="width:13%">Tutorials</th>
                        <th style="width:75%">Tutor</th>
                        <th style="width:22%">Files</th>
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

                                if($tutorial->tutors)
                                {
                                  foreach ($tutorial->tutors as $tutor) {
                                  echo $tutor->staff->staff_title . ' ' .$tutor->staff->user->fullname.'<br/>';
                                  }
                                }

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
                <td>'.$offer->countAssessmentMaterialFiles.'</td>
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
                <td>'.$offer->countAssessmentScriptFiles.'</td>
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
                <td>'.$offer->countSummativeAssessmentFiles.'</td>
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
                <td>'.$offer->countAnswerScriptFiles.'</td>
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
                <td>'.$totalExemptFiles.'</td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[8]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);

                 
                  echo '<table>
                        <tr>
                        <th style="width:13%">Lectures</th>
                        <th style="width:75%">Lecturer</th>
                        <th style="width:22%">Files</th>
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

                                if($lectures->lecturers)
                                {
                                  foreach ($lectures->lecturers as $lecturer) {
                                  echo $lecturer->staff->staff_title . ' ' .$lecturer->staff->user->fullname.'<br/>';
                                  }
                                }

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
                        <th style="width:13%">Lectures</th>
                        <th style="width:75%">Tutor</th>
                        <th style="width:22%">Files</th>
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

                                if($tutorial->tutors)
                                {
                                  foreach ($tutorial->tutors as $tutor) {
                                  echo $tutor->staff->staff_title . ' ' .$tutor->staff->user->fullname.'<br/>';
                                  }
                                }

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