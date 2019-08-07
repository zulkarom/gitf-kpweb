<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$this->title= 'FKP';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
?>

	<div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:1300px;height:500px;overflow:hidden;visibility:hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
            <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="../svg/loading/static-svg/spin.svg" />
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1300px;height:500px;overflow:hidden;">
		
		<?php 
		if($slides){
			foreach($slides as $slide){
				echo '<div>
                <a href="'.$slide->slide_url .'" target="_blank"><img data-u="image" src="' . Url::to(['front-slider/download', 'attr' => 'image','id'=> $slide->id]) . '" /></a>
				
            </div>';
			}
		}
		
		?>
		
		
			
		
            
		
          
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb032" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
            <div data-u="prototype" class="i" style="width:16px;height:16px;">
                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                </svg>
            </div>
        </div>
        <!-- Arrow Navigator -->
        <div data-u="arrowleft" class="jssora051" style="width:65px;height:65px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
            <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
            </svg>
        </div>
        <div data-u="arrowright" class="jssora051" style="width:65px;height:65px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
            <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
            </svg>
        </div>
    </div>



	
	<?php 
			
			if($upcoming){
			
			?>
	
	<section class="event-section spad">
		<div class="container">
			<div class="section-title text-center">
				<h3>UPCOMING EVENTS</h3>
				<p>Our department  initiated a series of events</p>
			</div>
			<div class="row">
			<?php 
			$i = 1;
			$number = count($upcoming);
				if ($number % 2 == 0) {
				  $even = true;
				}else{
					$even = false;
				}
			foreach($upcoming as $upevent){
				
				if($i == $number and $even == false){
					echo '<div class="col-md-3"></div>';
				}
				
				?>
				
				<div class="col-md-6 event-item">
					<div class="event-thumb">
						<img src="<?=Url::to(['event/download', 'attr' => 'promoimg', 'id' => $upevent->id]) ?>" alt="">
						<div class="event-date">
							<span><?=  Yii::$app->formatter->asDate($upevent->date_start, 'medium') ?></span>
							
						</div>
					</div>
					<div class="event-info">
						<h4><?=$upevent->name?></h4>
						<p><i class="fa fa-calendar-o"></i><?= Yii::$app->formatter->asTime($upevent->time_start, 'php:h:i A');?> - <?= Yii::$app->formatter->asTime($upevent->time_end, 'php:h:i A');?><i class="fa fa-map-marker"></i> <?=$upevent->venue?></p>
						<a href="<?=Url::to(['event/view', 'id' => $upevent->id])?>" class="event-readmore">MORE INFO <i class="fa fa-angle-double-right"></i></a>
					</div>
				</div>
				<?php
			$i++;
			}
			?>
			
			
			</div>
			
			<p align="center"><a href="<?=Url::to(['event/upcoming'])?>" class="btn btn-outline-info">More Upcoming Events</a></p>
		</div>
	</section>
	
	<?php 
			}
	?>



	<section class="fact-section spad set-bg" data-setbg="<?=$directoryAsset ?>/img/fact-bg.jpg">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-3 fact">
					<div class="fact-icon">
						<i class="ti-time"></i>
					</div>
					<div class="fact-text">
						<h2>10+</h2>
						<p>YEARS</p>
					</div>
				</div>
				<div class="col-sm-6 col-lg-3 fact">
					<div class="fact-icon">
						<i class="ti-briefcase"></i>
					</div>
					<div class="fact-text">
						<h2>100+</h2>
						<p>LECTURERS</p>
					</div>
				</div>
				<div class="col-sm-6 col-lg-3 fact">
					<div class="fact-icon">
						<i class="ti-user"></i>
					</div>
					<div class="fact-text">
						<h2>1500+</h2>
						<p>STUDENTS</p>
					</div>
				</div>
				<div class="col-sm-6 col-lg-3 fact">
					<div class="fact-icon">
						<i class="ti-pencil-alt"></i>
					</div>
					<div class="fact-text">
						<h2>100+</h2>
						<p>COURSES</p>
					</div>
				</div>
			</div>
		</div>
	</section>



	<?php 
		
			if($news){
			
			?>
	<section class="blog-section spad">
		<div class="container">
			<div class="section-title text-center">
		<h3>LATEST NEWS</h3>
				<p>Get latest news & events of the faculty</p>
			</div>
			<div class="row">
			
			<?php 
			
			function limit_text($text, $limit=20) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
    }
			
			foreach($news as $new){
				
				?>
				
				<div class="col-xl-6">
					<div class="blog-item">
						<div class="blog-thumb set-bg" data-setbg="<?=Url::to(['event/download', 'attr' => 'newsimg', 'id' => $new->id]) ?>"></div>
						<div class="blog-content">
							<h4><a href="<?=Url::to(['event/news', 'id' => $new->id])?>" style="color:#000"><?=$new->name?></a></h4>
							<div class="blog-meta">
								<span><i class="fa fa-calendar-o"></i> <?=  Yii::$app->formatter->asDate($new->date_start, 'medium') ?></span>
								<span><i class="fa fa-user"></i> Admin</span>
							</div>
							<p><?=limit_text($new->report_1)?></p>
						</div>
					</div>
				</div>
				
				<?php
			}
			
			
			?>
			
			
			
		
				
				
			</div>
			
			<p align="center"><a href="<?=Url::to(['event/news-list'])?>" class="btn btn-outline-info">More News</a></p>
			
		</div>
	</section>
<?php 

			}
?>