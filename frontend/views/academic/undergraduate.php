<?php 
$this->title = 'UNDERGRADUATE PROGRAMMES';
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');

?>
	
	<!-- Breadcrumb section -->
	<div class="site-breadcrumb">
		<div class="container">
			<a href="index.php"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-right"></i>
			<span>Undergraduate</span>
		</div>
	</div>
	<!-- Breadcrumb section end -->


<section class="courses-section" style="padding-bottom:50px">
		<div class="container">
			<div class="section-title text-center">
				<h3>UNDERGRADUATE PROGRAMMES</h3>
			</div>
			
			
			
			
			<?= $this->render('../student/ug-prog-items', [
        'directoryAsset' => $directoryAsset,
    ]) ?>
				

			
			
			
		</div>
	</section>
	
	
	