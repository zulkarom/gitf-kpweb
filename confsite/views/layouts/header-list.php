<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;

$dirAsset = Yii::$app->assetManager->getPublishedUrl('@confsite/views/myasset');
$confurl = Yii::$app->getRequest()->getQueryParam('confurl');

$menu = [
	['Go Back to Main Page', ['site/home', 'confurl' => $confurl], 'home'],
	['Register as Manager Now', ['site/login', 'confurl' => $confurl], 'files-o'],
	
];

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
					
					foreach($menu as $m){
						echo '<li>
                            <a href="'.Url::to($m[1]).'">
                                '.$m[0].'</a>
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
					
					foreach($menu as $m){
						echo '<li class="item-menu-mobile">
                            <a href="'.Url::to($m[1]).'">
                                '.$m[0].'</a>
                        </li>';
					}
					
					
					?>

					
				</ul>
			</nav>
		</div>
	</header>