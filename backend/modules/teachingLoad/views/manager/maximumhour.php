<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Maximum Hour';
$this->params['breadcrumbs'][] = $this->title;
?>
    
<div class="course-offered-session">
<?php $form = ActiveForm::begin(); ?>

<a class="btn btn-success" href="/training/gitf-kpweb/backend/web/teaching-load/manager/add-staff">Add Staff</a>
<br/><br/>
<div class="row">
  <div class="col-md-2">
    General Max Hour <input name="" type="text" style="width:100%"  value="" />
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
      </tr>
        <td></td>
        <td></td>
        <td></td>
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

</div>

<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save Maximum Hour', ['class' => 'btn btn-primary']) ?>


</div>
<?php ActiveForm::end(); ?>


</div>
