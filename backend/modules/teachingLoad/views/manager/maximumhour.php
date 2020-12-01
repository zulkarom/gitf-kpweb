<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Maximum Hour';
$this->params['breadcrumbs'][] = $this->title;
?>
    
<div class="maximum_hour">

<a class="btn btn-success" href="<?=Url::to(['add-staff'])?>">Add Staff</a>

<?php $form = ActiveForm::begin(); ?>


<br/>
<div class="row">
  <div class="col-md-2">
    <?php
    echo'General Max Hour<input name="Max[max_general_hour]" type="text" style="width:100%" value="'.$setting->max_hour.'" />';
    ?>
  </div>
</div>
<br/>

<div class="box">
<div class="box-body">



<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>Staff Name</th>
        <th>Maximum Hour</th>
        <th></th>
      </tr>
        <?php
         if($model){
         $i = 1;
         foreach($model as $staff){
            echo'<tr>
            <td>'.$i.'</td>
            <td>'.$staff->staff->staff_title .' '.$staff->staff->user->fullname.'</td>
            <td><input name="Max['.$staff->id.'][max_hour]" type="text" style="width:50%" value="'.$staff->max_hour.'" /></td>
            <td><a class="btn btn-danger btn-sm" href="' . Url::to(['manager/delete-maximum-hour', 'id' => $staff->id]) . '" data-confirm="Are you sure you want to delete this staff?" ><span class="fa fa-trash"></span></a></td>';
            $i++;
          }
        }
        ?>
      </tr>
    </thead>
    <tbody>
      <tr>
      </tr>
    </tbody>
  </table>
</div>
</div>

</div>


<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save Maximum Hour', ['class' => 'btn btn-primary']) ?>


<?php ActiveForm::end(); ?>


</div>
