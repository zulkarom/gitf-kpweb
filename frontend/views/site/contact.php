<?php 
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');

?>
	<!-- Breadcrumb section -->
	<div class="site-breadcrumb">
		<div class="container">
			<a href="#"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-right"></i>
			<span>Contact</span>
		</div>
	</div>
	<!-- Breadcrumb section end -->


	<!-- Courses section -->
	<section class="contact-page spad pt-0">
		<div class="container">
			<div class="map-section">
				<div class="contact-info-warp">
					<div class="contact-info">
						<h4>Address</h4>

						<p>Kampus Kota, Karung Berkunci 36, <br />Pengkalan Chepa, 16100 Kota Bharu, <br />Kelantan, Malaysia</p>
					</div>
					<div class="contact-info">
						<h4>Phone</h4>
						<p>609 771 7131</p>
						<p>609 771 7126</p>
					</div>
					<div class="contact-info">
						<h4>Fax</h4>
						<p>609 7717252</p>
					</div>
					<div class="contact-info">
						<h4>Working time</h4>
						<p>Sun - Thu: 08 AM - 05 PM</p>
					</div>
				</div>
				<!-- Google map -->
				<div class="map" style="background-image: url('<?=$directoryAsset?>/img/map.jpg')"></div>
			</div>
			
		</div>
	</section>
