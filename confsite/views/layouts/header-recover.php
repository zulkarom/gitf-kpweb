<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;

$dirAsset = Yii::$app->assetManager->getPublishedUrl('@confsite/views/myasset');

?>
	<header class="header1" style="height:80px">
		<!-- Header desktop -->
		<div class="container-menu-header">


			<div class="wrap_header">

				<!-- Menu -->
				<div class="wrap_menu">
					<nav class="menu">
						<ul class="main_menu">
						<?php 
						
					if($conf){
					echo '<li>
                            <a href="'.Url::to(['/site/home', 'confurl' => $conf->conf_url]).'">
                                Go Back to '.$conf->conf_abbr .'</a>
                        </li>';
					
					}
					?>
							
						</ul>
					</nav>
				</div>

				<!-- Header Icon -->
				<div class="header-icons">
					

					
					

				
				</div>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap_header_mobile">
			<a href="index.html" class="logo-mobile">
				
			</a>

			<!-- Button show menu -->
			<div class="btn-show-menu">
				<!-- Header Icon mobile -->
				


				<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</div>
			</div>
		</div>

		<!-- Menu Mobile -->
		<div class="wrap-side-menu" >
			<nav class="side-menu">
				<ul class="main-menu">
				
				<?php 
							
					if($conf){
					echo '<li class="item-menu-mobile">
                            <a href="'.Url::to(['/site/home', 'confurl' => $conf->conf_url]).'">
                                Go Back to '.$conf->conf_abbr .'</a>
                        </li>';
					
					}
					
					
					
					?>

					
				</ul>
			</nav>
		</div>
	</header>