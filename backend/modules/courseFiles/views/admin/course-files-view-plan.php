
<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>


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
        <th style="width:10%">Files</th>
        <th>Action</th>
      </tr>
    
        
        <tr>
        <?php 
    
       $item = $model->itemPlan;
       $offer =  $modelOffer;
          
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
                <td></td>
                <td></td>';

          echo '<tr><td>'.$item[3]->id.'</td>
                <td>'.$item[3]->item.'<i><br/>'.$item[3]->item_bi.'</i></td>
                <td>'.$offer->countRubricFiles.'</td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[3]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      
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
                <td>'.$offer->countMaterialFiles.'</td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[4]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);
                      
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
                <td></td>
                <td></td>';

          echo '<tr><td>'.$item[6]->id.'</td>
                <td>'.$item[6]->item.'<i><br/>'.$item[6]->item_bi.'</i></td>
                <td></td>
                <td></td>';
              ?>
      </tr>
    </thead>
  </table>

</div>