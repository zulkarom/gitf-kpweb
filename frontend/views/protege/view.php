<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\proceedings\models\Proceeding */

$this->title = $model->company->company_name;
$this->params['breadcrumbs'][] = ['label' => 'Protege', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="proceeding-index">

   
<section class="contact-page spad pt-0">
        <div class="container">
		<?=Html::a('<i class="fa fa-arrow-left"></i> BACK',['/protege'])?>
		<p>
 <h3 style="font-size: 30px;margin-bottom: 0px;"><?= Html::encode($model->company->company_name) ?></h3>


 
<i><?=$model->company->address?></i> 
<?php
 if($model->company->description){
    echo '<p><i>'. $model->company->description .'</i></p>';
 }
 ?>
 </p>
   <br />
 <div class="row">
 <div class="col-md-6">
 <h5>Registered Students</h5>
<br />

<table class="table">
    <tbody>
        <tr><th>No.</th><th>Name of Students</th></tr>
        <?php 
        $reg = $model->studentRegistrations;
        if($reg){
            $i=1;
            foreach ($reg as $r) {
                echo '<tr><td>'.$i.'. </td><td>'.$r->student_name.'</td></tr>';
                $i++;
            }
        }else{
            echo '<tr><td></td><td>--No Registration yet--</td></tr>';
        }
        ?>
        
    </tbody>
</table>

 </div>
     <div class="col-md-6">

<h5>Registeration Form (<?=$model->getBalance()?> available)</h5>
<br />
     <?php 
     if($model->getBalance() > 0){
     
     $form = ActiveForm::begin(); ?>

<?= $form->field($register, 'student_name')->textInput(['style' => 'text-transform: uppercase;']) ?>
<?= $form->field($register, 'student_matric')->textInput(['style' => 'text-transform: uppercase;']) ?>
<?= $form->field($register, 'email')->textInput(['style' => 'text-transform: lowercase;']) ?>
<?= $form->field($register, 'phone')->textInput() ?>
<?= $form->field($register, 'program_abbr')->dropdownList($register->listPrograms()) ?>

<div class="form-group">
    
<?= Html::submitButton('Register', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); 
     }else{
        echo '--NOT AVAILABLE--';
     }
?>



     </div>
    
 </div>


	        </div>
    </section>

</div>

