<?php 
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');

?>
	
	<!-- Breadcrumb section -->
	<div class="site-breadcrumb">
		<div class="container">
			<a href="index.php"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-right"></i>
			<span>Postgraduate</span>
		</div>
	</div>
	<!-- Breadcrumb section end -->



	
	<section class="pg-section">
		<div class="container">
			<div class="section-title text-center">
				<h3>POSTGRADUATE PROGRAMMES</h3>
				<br />
				<p>The Faculty of Entrepreneurship and Business offers the following Research Mode for Master and Phd level :</p>
			</div>
			
		<div class="row">
				
				<div class="col-lg-3 col-sm-6 service-item offset-lg-3">
					<div class="service-icon">
						<img src="<?=$directoryAsset ?>/img/services-icons/2.png" alt="1">
					</div>
					<div class="service-content">
						<h4>Management</h4>
		
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 service-item">
					<div class="service-icon">
						<img src="<?=$directoryAsset ?>/img/services-icons/3.png" alt="1">
					</div>
					<div class="service-content">
						<h4>Finance</h4>
					</div>
				</div>
				</div>
				<div class="row">
				<div class="col-lg-3 col-sm-6 service-item offset-lg-2">
					<div class="service-icon">
						<img src="<?=$directoryAsset ?>/img/services-icons/4.png" alt="1">
					</div>
					<div class="service-content">
						<h4>Commerce</h4>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 service-item">
					<div class="service-icon">
						<img src="<?=$directoryAsset ?>/img/services-icons/accounting.png" alt="1">
					</div>
					<div class="service-content">
						<h4>Accounting</h4>
					
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 service-item">
					<div class="service-icon">
						<img src="<?=$directoryAsset ?>/img/services-icons/6.png" alt="1">
					</div>
					<div class="service-content">
						<h4>Retailing</h4>
					</div>
				</div>
			</div>
			
			
			
		</div>
	</section>
	