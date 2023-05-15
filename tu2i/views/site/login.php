<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */
use tu2i\assets\tu2iAsset;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

Tu2iAsset::register($this);

$dirAssets = Yii::$app->assetManager->getPublishedUrl('@tu2i/assets/tu2iAssets');

$this->title = 'UJIAN PSIKOMETRIK / PSYCHOMETRIC TEST';
?>
<div class="site-login">


        <div class="container">

    <div>
        <div style="margin: 0 auto; width:90%">

            <!-- login box on left side -->
            <div>


<img src="<?=$dirAssets?>/images/umk.jpg" />
<h3>SARJANA MUDA KEUSAHAWANAN</h3>
<p>UNIVERSITI MALAYSIA KELANTAN</p>


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




                <div class="row">

                <div class="col-md-6">


                <h4> MULA MENJAWAB / <i>START ANSWERING</i>  </h4><br />


                <div class="form-group">

                <?=$form->field($model, 'username')->label('NRIC/PASSPORT NO.:')->textInput(['class' => 'form-control input-lg'])?>
                </div>
                <?=Html::submitButton('LOG IN', ['class' => 'btn btn-primary','name' => 'submit','value' => '1'])?>
                <br /><br />

                </div>



                <div class="col-md-6">

                    <?php

                    if ($batch->allow_register == 1) {
                        ?>
                    <h4> DAFTAR / <i>REGISTER</i>  </h4><br />

                <div class="form-group">
                <?=$form->field($model2, 'fullname')->label('NAMA / NAME.:')->textInput(['class' => 'form-control input-lg'])?>
                </div>


                <div class="form-group">
                <?=$form->field($model2, 'username')->label('NRIC/PASSPORT NO.:')->textInput(['class' => 'form-control input-lg'])?>
                </div>
                    <?=Html::submitButton('REGISTER', ['class' => 'btn btn-primary','name' => 'submit','value' => '2'])?>
                <?php
                    }
                    ?>





                </div>
                </div>

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

<br /><br />
          



            </div>



        </div>
    </div>
</div>

</div>
