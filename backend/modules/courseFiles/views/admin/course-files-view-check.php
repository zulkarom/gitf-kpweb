<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>


<div class="box-header">
  <div class="box-title"><b>Peringkat Semak/ Evaluation Level
     <br/><div class="box-title">(CHECK)</b></div>
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
    
        $item = $model->itemCheck;
        $offer =  $modelOffer;

        echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td>'.$offer->countAssessResultFiles.'</td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[0]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      
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
                <td>'.$offer->countEvaluationFiles.'</td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[1]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      
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
                <td>'.$offer->countResultCloFiles.'</td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[2]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      
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
                <td>'.$offer->countAnalysisCloFiles.'</td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[3]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      
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
