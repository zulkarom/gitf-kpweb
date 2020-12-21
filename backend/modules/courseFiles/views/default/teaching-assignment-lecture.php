<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Course Files';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Assignment', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(); ?>


<div class="box">
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
        <th>Action</th>
      </tr>
    
        
        <tr>
        <?php 
    
        if($model->itemDo){
        $i = 1;
          foreach($model->itemDo as $item){
            if($item->lec_upload == 1){
              echo '<tr><td>'.$i.'</td>
                <td>'.$item->item.'<i><br/>'.$item->item_bi.'</i></td>
                <td><a href="' . Url::to(['lecture-'.$item->upload_url.'/page','id' => $lecture_id]) . '" class="btn btn-warning btn-sm" ><span class="glyphicon glyphicon-th-list"></span> Upload</a></td>';
       
                $i++;
            }
          }
        }
              ?>
      </tr>
    </thead>
   
  </table>
</div>
</div>

<?php ActiveForm::end(); ?>

