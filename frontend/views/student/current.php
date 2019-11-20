<?php 
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');

?>
	<!-- Breadcrumb section -->
	<div class="site-breadcrumb">
		<div class="container">
			<a href="index.php"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-right"></i>
			<span>Current Student</span>
		</div>
	</div>

	<section class="student-section">
		<div class="container">
			<div class="section-title text-center">
				<h3>STUDENTS RESOURCES</h3>

			</div>
			
		<div class="row">
				
				<div class="col-lg-3 col-sm-6 service-item offset-lg-1">
					<a href="http://ecomm.umk.edu.my/" target="_blank"><div class="service-icon">
						<img src="<?=$directoryAsset ?>/img/services-icons/2.png" alt="1">
					</div>
					<div class="service-content">
						<h4>E-COMM PORTAL</h4>
				<p>The official UMK e-community portal</p>
					</div>
					</a>
				</div>
				<div class="col-lg-3 col-sm-6 service-item">
					<a href="http://ecampus.umk.edu.my/" target="_blank"><div class="service-icon">
						<img src="<?=$directoryAsset ?>/img/services-icons/2.png" alt="1">
					</div>
					<div class="service-content">
						<h4>E-CAMPUS</h4>
				<p>The official e-learning for teaching and learning activities</p>
					</div>
					</a>
				</div>
			
				<div class="col-lg-3 col-sm-6 service-item">
					<a href="http://perpustakaan.umk.edu.my" target="_blank"><div class="service-icon">
						<img src="<?=$directoryAsset ?>/img/services-icons/2.png" alt="1">
					</div>
					<div class="service-content">
						<h4>LIBRARY</h4>
				<p>Access OPAC Web, journals and past year exam papers</p>
					</div>
					</a>
				</div>
				
				<div class="col-lg-3 col-sm-6 service-item">
					<a href="https://fkpresearch.wixsite.com/fkp-researchskill" target="_blank"><div class="service-icon">
						<img src="<?=$directoryAsset ?>/img/services-icons/2.png" alt="1">
					</div>
					<div class="service-content">
						<h4>RESEARCH SKILSS DEVELOPMENT PROGRAMME</h4>
				<p>A range of workshops, seminars and short courses to build research knowledge and skills for postgraduate students</p>
					</div>
					</a>
				</div>
			
	
			</div>
			
			
			
		</div>
	</section>
	


