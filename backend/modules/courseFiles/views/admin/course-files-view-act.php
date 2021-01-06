<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>


<div class="box-header">
  <div class="box-title"><b>Peringkat Tindakan/ Review Level
    <br/><div class="box-title">(ACT)</b></div>
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
    
        $item = $model->itemAct;
        $offer =  $modelOffer;
        
        echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td>'.$offer->countImproveFiles.'</td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[0]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      
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