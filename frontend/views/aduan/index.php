<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
//use yii\captcha\Captcha;
use backend\modules\aduan\models\AduanTopic;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'E-Aduan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aduan-index">
     <section class="contact-page spad pt-0">
        <div class="container">

    <h3><?= Html::encode($this->title) ?> Fakulti Keusahawanan dan Perniagaan</h3>  

	<br />
	
	

	
	<div class="row">
<div class="col-md-8">

<h4>Garis Panduan Pengaduan</h4>
	<br />
	
	
<ol style="font-size:17px; text-align:justify">
	<li>Pihak Fakulti Keusahawanan dan Perniagaan (FKP) amat mengalu-alukan sebarang cadangan, maklumbalas, pertanyaan atau aduan anda untuk meningkatkan kualiti dan mutu penyampaian FKP terutama dari segi perkhidmatan, pentadbiran dan pengurusan.</li>
	<li>
	Semua aduan yang ingin dihantar mestilah di bawah bidang kuasa Fakulti Keusahawanan dan Perniagaan.
	</li>
<li>Semua aduan adalah dianggap SULIT. Segala maklumat peribadi berkenaan anda adalah dijamin kerahsiannya daripada pengetahuan pihak lain selain daripada Pegawai Penyelia Aduan.</li>
<li>Semua pengadu diminta menggunakan perkataan atau ayat yang sopan sesuai dengan budaya Negara Malaysia. Sekiranya anda menggunakan bahasa yang kasar atau tidak bersesuaian dengan budaya Negara Malaysia yang mementingkan kesopanan, pihak FKP berhak untuk tidak melayan pengaduan anda.</li>
<li>Semua pengadu diminta untuk memberikan nama, nombor kad pengenalan, alamat, e-mail dan nombor telefon untuk dihubungi bagi memastikan anda mendapat maklumbalas daripada pihak FKP berkenaan aduan yang anda adukan.</li>
<li>Sila pastikan aduan anda adalah spesifik dan jelas mengenai perkara yanag diadukan serta pihak yang ditujukan aduan tersebut untuk mengelakkan salah faham pihak kami dalam meneliti aduan anda.</li>
<li>Pihak FKP menjamin setiap aduan anda akan diproses dan diambil tindakan yang sebaik-baiknya dalam masa yang telah ditetapkan dan maklumbalas akan diberikan secepat mungkin.</li>
<li>Pihak FKP akan mengemaskini status aduan dari semasa ke semasa. Jika sekiranya tiada maklum balas dari pengadu dalam sistem eAduan FKP lebih dari 7 hari, aduan tersebut dianggap telah selesai.</li>
</ol>
</div>

<div class="col-md-4">

<h4>Kemaskini Status Aduan</h4>
<br />
<?php $form = ActiveForm::begin(['action' => ['check']]); ?>
    <?= $form->field($kemaskini, 'email')->textInput(['maxlength' => true]) ?>

	<?= $form->field($kemaskini, 'id')->textInput(['maxlength' => true]) ?>

<div class="form-group">
        
	<?= Html::submitButton('Kemaskini Status', ['class' => 'btn btn-success']) ?>
</div>
<i>* Untuk aduan baru, sila gunakan borang aduan baru di bawah.</i>
   <?php ActiveForm::end(); ?>


</div>

</div>
	<br />	

<h4>Borang Aduan Baru</h4>
	<br />
	


<?php $form = ActiveForm::begin(); ?>

  <div class="row">
<div class="col-md-10"> <?= $form->field($model, 'topic_id')->dropDownList(
                ArrayHelper::map(AduanTopic::find()->all(),'id','topic_name'), ['prompt' => 'Pilih salah satu' ] ) ?></div>



</div>
           <div class="row">
<div class="col-md-6"> <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-4">
<?= $form->field($model, 'type')->dropDownList([1=>'Pelajar', 2=>'Staff', 3 => 'Lain-lain'], ['prompt' => 'Sila Pilih']) ?>

</div>

</div>

<div class="row">
<div class="col-md-3"><?= $form->field($model, 'nric')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-4">
<?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Emel *') ?>
</div>

<div class="col-md-3">
<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
</div>

</div>
        
    
       

<div class="row">
<div class="col-md-10">  <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
         

    
            <?= $form->field($model, 'aduan')->textarea(['rows' => 6]) ?>
          
    
            <?= $form->field($model, 'upload_url')->fileInput() ?></div>


</div>
    
          
    <div class="row">
        <div class="col-md-10">
            <?= $form->field($model, "declaration")->checkbox(['value' => '1', 'label'=> 'Saya mengaku bahawa saya telah membaca dan memahami <b>Garis Panduan Pengaduan</b> di atas. Segala maklumat diri dan maklumat perkara yang dikemukakan oleh saya adalah benar dan saya bertanggungjawab ke atasnya.']); ?>
			
			
			* Bagi memastikan komunikasi yang berkesan berlaku, satu kod verifikasi akan dihantar ke alamat emel yang diberi. Sila pastikan alamat emel anda adalah tepat.<br /><br />
        </div>
    </div>
  

          
    <div class="form-group">
        <?= Html::submitButton('Hantar Aduan', ['class' => 'btn btn-success', 'data' => [
                'confirm' => 'Adakah anda pasti untuk menghantar aduan ini?'
            ],
]) ?>
		
    </div>

    <?php ActiveForm::end(); ?>





   

     </div>
    </section>
</div>


<?php 

$this->registerJs('

$("#aduan-type").change(function(){
	var val = $(this).val();
	if(val == 1){
		$("label[for=\'aduan-nric\']").text("No. Matrik");
	}else if(val == 2){
		$("label[for=\'aduan-nric\']").text("No. Staff");
	}else if(val == 3){
		$("label[for=\'aduan-nric\']").text("No. Kad Pengenalan");
	}else{
		$("label[for=\'aduan-nric\']").text("No. Matrik/Staff/Ic");
	}
});




');


?>