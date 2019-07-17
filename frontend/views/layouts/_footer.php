<?php 
use yii\helpers\Url;
?>
<footer class="footer-section">
		<div class="container footer-top">
			<div class="row">
				
				<!-- widget -->
				<div class="col-sm-6 col-lg-3 footer-widget offset-lg-3">
					<h6 class="fw-title">USEFUL LINK</h6>
					<div class="dobule-link">
						<ul>
							<li><a href="<?=Url::to(['/site'])?>">Home</a></li>
							<li><a href="<?=Url::to(['/student'])?>">Future Students</a></li>
							<li><a href="<?=Url::to(['/student/current'])?>">Current Students</a></li>
							<li><a href="<?=Url::to(['/academic'])?>">Undergraduate</a></li>
							<li><a href="<?=Url::to(['/academic/post-graduate'])?>">Postgraduate</a></li>
						</ul>
						<ul>
							<li><a href="http://jeb.umk.edu.my">JEB Journal</a></li>
							<li><a href="<?=Url::to(['/research/caknawan'])?>">Caknawan</a></li>
					
						</ul>
					</div>
				</div>
		
				<!-- widget -->
				<div class="col-sm-6 col-lg-3 footer-widget">
					<h6 class="fw-title">CONTACT</h6>
					<ul class="contact">
						<li><p><i class="fa fa-map-marker"></i> Kampus Kota, Karung Berkunci 36, 
Pengkalan Chepa, 16100 Kota Bharu, 
Kelantan, Malaysia</p></li>
						<li><p><i class="fa fa-phone"></i> 609 771 7131
</p></li>

<li><p><i class="fa fa-phone"></i> 609 771 7126
</p></li>
						<li><p><i class="fa fa-fax"></i> 609 7717252</p></li>
						
					</ul>
				</div>
			</div>
		</div>
		<!-- copyright -->
		<div class="copyright">
			<div class="container">
				<p>
Copyright &copy;<script>document.write(new Date().getFullYear());</script> Faculty of Entrepreneurship and Business. All rights reserved  | <a href="<?=Url::to(['site/disclaimer'])?>">Disclaimer</a> - <a href="<?=Url::to(['site/privacy'])?>">Privacy Policy</a> - <a href="<?=Url::to(['site/privacy'])?>">Security Policy</a>

<br /><br />

Template by <a href="https://colorlib.com" target="_blank" >Colorlib</a> | Credited to <a href="http://skyhint.com" target="_blank">Skyhint Design</a>

<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
			</div>		
		</div>
	</footer>