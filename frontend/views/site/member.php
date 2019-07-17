<?php 

use yii\helpers\Url;


$this->title= 'MEMBER PAGE';
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
?>


<?=$this->render('_img_user')?>


<div class="block-content">

		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="section_title text-center">WELCOME TO JEB</h2>
				</div>

			</div>
			<br />
			<div class="row">
			
			<div class="col-lg-12"><p>The Journal of Entrepreneurship and Business (eISSN : 2289-8298) or JEB is a double-blind, peer-reviewed and open-access journal, published in June and December annually. JEB addresses the fundamental issues of entrepreneurship and business and publishes original quantitative or qualitative articles on all aspects of entrepreneurship and business in local and international contexts. The primary audiences for this journal are scholars, academicians, policy makers and practitioners whose interest is in entrepreneurship and business discourses, practices and activities.</p></div>
				
				<br />
				
				
				
			
			</div>
			<br />
			
			<div class="form-group" align="center"><a href="<?=Url::to(['submission/create'])?>" class="btn btn-primary">SUBMIT NEW MANUSCRIPT</a> </div>

		</div>
	</div>
	
<br /><br /><br />