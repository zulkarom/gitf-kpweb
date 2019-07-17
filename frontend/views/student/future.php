<?php 
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');

?>
	<!-- Breadcrumb section -->
	<div class="site-breadcrumb">
		<div class="container">
			<a href="index.php"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-right"></i>
			<span>Future Student</span>
		</div>
	</div>
	<!-- Breadcrumb section end -->


<section class="courses-section" style="padding-bottom:50px">
		<div class="container">
			<div class="section-title text-center">
				<h3>PROGRAMMES OFFERED</h3>
				<h5>UNDERGRADUATE PROGRAMMES</h5>
			</div>
			
			
			 <?= $this->render('ug-prog-items', [
        'directoryAsset' => $directoryAsset,
    ]) ?>
				
			
			
				<div class="text-center" style="padding-bottom:50px">
				<a href="download/admission-requirement.pdf" target="_blank" class="btn btn-primary">Undergraduate Admission Requirement</a>
				</div>
			
			
			
		</div>
	</section>
	
	<section class="testimonial-section spad">
		<div class="container">
			<div class="section-title text-center">
				<h5>POSTGRADUATE PROGRAMMES</h5>
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
			
			<div class="section-title text-center">
				<h5>Post Graduate Entry Requirement</h5>
				<p>&nbsp;</p>
				
				<div class="row">
<div class="col-md-8 offset-md-2 about-text" >

<ul class="about-list">
<li><i class="fa fa-check-square-o"></i> Bachelor's Degree with Honors (CGPA> 2.75) from recognized Public or Overseas Institutions of Higher Learning or qualification equivalent to those accepted by the University Senate.</li>

<li><i class="fa fa-check-square-o"></i> However, an applicant with other qualifications may also be considered if he / she has the appropriate research experience and can demonstrate his / her ability to follow Graduate Studies.</li>

</ul>

</div>



</div>
				
	


				
			</div>
			
			<div class="text-center" style="padding-bottom:50px">
			
			<a href="http://cps.umk.edu.my/index.php" target="_blank" class="btn btn-outline-info">More Infomation at CPS</a>
			  
			
				<a href="http://pams.umk.edu.my:8082/login" target="_blank" class="btn btn-danger">Apply Now</a>
				</div>
			
		</div>
	</section>
	
<section class="finance-section spad">
		<div class="container">
			<div class="section-title text-center">
				<h3>FINANCIAL SUPPORT</h3>
		
				
			</div>
			
			<div class="row">
<div class="col-md-6">


<p class="text-center">UMK has secured sponsorship for 83% of students in the form of loans and scholarships from the following agencies:</p>

<div class="text-center about-text"><ul class="about-list">
<li><i class="fa fa-check-square-o"></i> Perbadanan Tabung Pendidikan Tinggi Nasional (PTPTN)</li>
<li><i class="fa fa-check-square-o"></i> Jabatan Perkhidmatan Awam Malaysia (JPA)</li>
<li><i class="fa fa-check-square-o"></i> Majlis Amanah Rakyat (MARA)</li>
<li><i class="fa fa-check-square-o"></i> Kumpulan Wang Simpanan Pekerja (KWSP)</li>
<li><i class="fa fa-check-square-o"></i> Yayasan Tunku Abdul Rahman </li>
<li><i class="fa fa-check-square-o"></i> Permodalan Nasional Berhad (PNB)</li>
<li><i class="fa fa-check-square-o"></i> Kuok Foudation Berhad</li>
<li><i class="fa fa-check-square-o"></i> Jabatan Kemajuan Orang Asli (JAKOA)</li>
<li><i class="fa fa-check-square-o"></i> JPA Sabah </li>
<li><i class="fa fa-check-square-o"></i> Office of the Secretary (Negeri Selangor) </li>
<li><i class="fa fa-check-square-o"></i> State Foundation (Kelantan, Negeri Sembilan, Pahang, Johor, Selangor)</li>

</ul></div>


</div>

<div class="col-md-6">


<p class="text-center">Find out more financial support for post graduate students at center for post graduate students (CPS) e.g. Graduate Research Assistant (GRA) or Graduate Teaching Assistant (GTA)</p>

<p>

<div class="text-center" style="padding-bottom:50px">
				<a class="btn btn-warning" href="http://cps.umk.edu.my/index.php/en/funding.html" target="_blank" >CPS FUNDING PAGE</a>
				</div>

</p>

</div>

</div>
			
			
			
		
				
			
			
			
		</div>
	</section>

