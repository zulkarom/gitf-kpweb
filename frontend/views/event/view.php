<?php
use yii\helpers\Url;
?>
	<div class="site-breadcrumb">
		<div class="container">
			<a href="<?=Url::to(['/site'])?>"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-right"></i>
			
			<a href="<?=Url::to(['event/upcoming'])?>">Upcoming Events</a>
			<i class="fa fa-angle-right"></i>
			<span>View Events</span>
		</div>
	</div>

	<section class="about-section spad pt-0">
		<div class="container">
			
			<div class="row">
			<div class="col-lg-2"></div>
				<div class="col-lg-8 about-text">
				
				<img src="<?=Url::to(['event/download', 'attr' => 'promoimg', 'id' => $event->id]) ?>" alt="">
				<br /><br />
				
					<h5><i class="fa fa-info-circle"></i> Introduction</h5>
					<p><?=$event->intro_promo?></p>
					
					<h5><i class="fa fa-calendar-o"></i> Date/Time</h5>
					<p><?=Yii::$app->formatter->asDate($event->date_start, 'medium') ?></p>
					
					<h5><i class="fa fa-map-marker"></i> Location</h5>
					<p><?=$event->venue?></p>
					
					<h5><i class="fa fa-mobile-phone"></i> Contact Person</h5>
					<p><?=$event->contact_pic?></p>

			
				</div>
			
			</div>
		</div>
	</section>
