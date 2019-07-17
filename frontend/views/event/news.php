<?php
use yii\helpers\Url;
?>
	<div class="site-breadcrumb">
		<div class="container">
			<a href="<?=Url::to(['/site'])?>"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-right"></i>
			
			<a href="<?=Url::to(['event/news-list'])?>">Latest News</a>
			<i class="fa fa-angle-right"></i>
			<span>View News</span>
		</div>
	</div>

	<section class="about-section spad pt-0">
		<div class="container">
		<div class="row">
			<div class="col-lg-2"></div>
				<div class="col-lg-8 about-text">
		<div class="section-title text-center">
				<h3><?=$event->name?></h3>
				<div class="pull-right" style="text-align:right">
				
				<i class="fa fa-calendar-o"></i> <?=Yii::$app->formatter->asDate($event->date_start, 'medium')?><br />
				
				<i>By: <?=$event->user->fullname?></i>
				<br /><br />
				
				</div>
			</div>
			
			
				
				<img src="<?=Url::to(['event/download', 'attr' => 'imagetop', 'id' => $event->id]) ?>" alt="">
				<br /><br />
				

					<p style=" text-align: justify;"><?= $event->city . ' ' . Yii::$app->formatter->asDate($event->date_start, 'php:d M') . ' | ' . nl2br($event->report_1)?></p>
					
					<img src="<?=Url::to(['event/download', 'attr' => 'imagemiddle', 'id' => $event->id]) ?>" alt="" align="right" width="50%" style="margin:20px">
					
					<p style=" text-align: justify;"><?=nl2br($event->report_2)?></p>
					
				<img src="<?=Url::to(['event/download', 'attr' => 'imagebottom', 'id' => $event->id]) ?>" alt="" >
			
				</div>
			
			</div>
		</div>
	</section>
