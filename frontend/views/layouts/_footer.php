<?php 
use yii\helpers\Url;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
?>
<footer class="footer-section">
	
		<div class="container footer-top">
			<div class="row">
				<div class="col-sm-6 col-lg-3 footer-widget">
					<div class="about-widget">
						<img src="<?=$directoryAsset?>/img/logo-light.png" alt="">
						
						<p>Faculty of Entrepreneurship and Business, Universiti Malaysia Kelantan is located at UMK City Campus, Pengkalan Chepa, Kelantan Malaysia</p>
						
						<div class="social pt-1">
							
							
							<a href="http://fkp.umk.edu.my/organization-chart.cfm" target="_blank"><i class="fa fa-twitter"></i></a>
							<a href="http://fkp.umk.edu.my/organization-chart.cfm" target="_blank"><i class="fa fa-facebook"></i></a>
							<a href="http://fkp.umk.edu.my/organization-chart.cfm" target="_blank"><i class="fa fa-instagram"></i></a>
							<a href="http://fkp.umk.edu.my/organization-chart.cfm" target="_blank"><i class="fa fa-linkedin"></i></a>
							
						</div>
						
						
							<br>
						
						
					</div>
				</div>
				<div class="col-sm-4 col-lg-4 footer-widget">

					<div class="dobule-link">
						<ul>
							<li><a href="http://fkp.umk.edu.my/policy.cfm">Website Policy &amp; Security</a></li>
							<li><a href="http://fkp.umk.edu.my/disclaimer.cfm">Disclaimer</a></li>
							<li><a href="http://fkp.umk.edu.my/help.cfm">Helpdesk</a></li>
							<li><a href="http://fkp.umk.edu.my/faq.cfm">FAQs</a></li>
							<li><a href="http://fkp.umk.edu.my/sitemap.cfm">Site map</a></li>
							
							
							
							
							
						
						</ul>
					</div>
				</div>
				
				<div class="col-sm-6 col-lg-3 footer-widget">
					
					<ul class="contact">
						
						<li><p><i class="fa fa-map-marker"></i> Kampus Kota, Pengkalan Chepa</p></li>
						<li><p><i class="fa fa-phone"></i> +6097717131</p></li>
						<li><p><i class="fa fa-envelope"></i> </p></li>
						<li><p><i class="fa fa-clock-o"></i> Sun - Thu, 08:00AM - 05:00 PM</p></li>
						<li><p><i class="fa fa-envelope"></i> <a href="http://fkp.umk.edu.my/contact.cfm" title="Contact Us" style="color:white;">Contact Us</a></p></li>
						
					</ul>

				</div>
				<div class="col-sm-6 col-lg-2 footer-widget">
					<div style="padding:10px;">
					
					<img src="<?=$directoryAsset?>/img/qrFKP.png" alt="FKP" width="150px">
					
				</div>
				</div>
			</div>
		</div>
<div class="copyright">
			<div class="container">
				<p>Copyright ©<script>document.write(new Date().getFullYear());</script> All rights reserved. Universiti Malaysia Kelantan</p>
			</div>		
</div>
</footer>