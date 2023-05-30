<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */
use tu2i\assets\Tu2iAsset;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

Tu2iAsset::register($this);

$dirAssets = Yii::$app->assetManager->getPublishedUrl('@tu2i/assets/Tu2iAssets');

$this->title = 'UJIAN PSIKOMETRIK / PSYCHOMETRIC TEST';
?>
<div class="site-login">


        <div class="container">

    <div>
        <div style="margin: 0 auto; width:90%">

            <!-- login box on left side -->
            <div>




            <div class="row">
<div class="col-md-3" align="center"><img src="<?=$dirAssets?>/images/umk.jpg" /></div>

<div class="col-md-9">

<div class="row"> 
				<div class="col-md-1"></div>
				<div class="col-md-10" align="center">
                <h4>TEMUDUGA ATAS TALIAN <br />
				IJAZAH SARJANA MUDA KEUSAHAWANAN<br />
				FAKULTI KEUSAHAWANAN DAN PERNIAGAAN</h4>
				<br />
				<i><h4>ONLINE INTERVIEW <br />
				BACHELOR OF ENTREPRENEURSHIP<br />
				FACULTY OF ENTREPRENEURSHIP AND BUSINESS</h4></i>



                <?php

$form = ActiveForm::begin([
    'validateOnSubmit' => false
]);
?>
<div class="row">

                <div class="col-md-12">
                <?php
                /*
                 * echo date("l jS \of F Y h:i:s A");
                 * echo '<br />';
                 * echo strtotime($batch->start_date). '<' . time() .'&&'. time() . '<' . strtotime($batch->end_date . ' 23:59:59');
                 */
                if ($batch->is_open == 1 && strtotime($batch->start_date) < time() && time() < strtotime($batch->end_date . ' 23:59:59')) {
                    ?>




<br /><br />

                <h4>LOG MASUK / <i>LOGIN FORM</i>  </h4><br />


                <div class="form-group">

                <?=$form->field($model, 'username')->label('NRIC/PASSPORT NO.:')->textInput(['class' => 'form-control input-lg', 'style' => 'text-align:center'])?>
                </div>
                <?=Html::submitButton('LOG IN', ['class' => 'btn btn-primary','name' => 'submit','value' => '1'])?>
                <br /><br />

       

				 <?php
                } else {

                    echo '<h3>TUTUP / CLOSED</h3>';
                }
                ?>

                </div>
                <div class="col-md-1"></div>
            </div>

            <?php

            ActiveForm::end();
            ?>



                </div>
</div>
</div>
            </div>





<br /><br />
          



            </div>



        </div>
    </div>
</div>

</div>
