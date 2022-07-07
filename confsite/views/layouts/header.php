<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use backend\modules\conference\models\Conference;

$dirAsset = Yii::$app->assetManager->getPublishedUrl('@confsite/views/myasset');
$confurl = $conf->conf_url;



if (Yii::$app->user->isGuest) {
    $menu = [
	['Home', ['/site/home', 'confurl' => $confurl], 'home', 0],
	['Submit Paper', ['/page/submission', 'confurl' => $confurl], 'tachometer-alt', 0],
	['Login / Register', ['/site/login', 'confurl' => $confurl], 'files-o', 0],
//	['Register', ['/page/register', 'confurl' => $confurl], 'table', 0],
	['Contact Us', ['/page/contact', 'confurl' => $confurl], 'dollar-sign', 0],
];
}else{
	$menu[] = ['<i class="fa fa-files-o"></i> Paper Submission', ['/member/paper', 'confurl' => $confurl], 'files-o', $conf->myPaperCount];
	
	$menu[] = ['<i class="fa fa-book"></i> My Review', ['/member/review', 'confurl' => $confurl], 'files-o', $conf->myReviewCount];
	
	if($conf->commercial){
		$menu[] = ['<i class="fa fa-dollar"></i> Fee Payment', ['/payment/index', 'confurl' => $confurl], 'table', 0];
	}
	
	
	$menu[] = ['<i class="fa fa-user"></i> Profile', ['/member/profile', 'confurl' => $confurl], 'table', 0];
	
	$menu[] = ['<i class="fa fa-arrow-left"></i>  Log Out', ['/site/logout', 'confurl' => $confurl, 
	], 'table', 0];
	
	//['My Review', ['/member/review', 'confurl' => $confurl], 'files-o'],

}

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
						$num = $m[3];
						$badge = '';
						if($num > 0){
							$badge = ' <span class="badge badge-danger">'.$num.'</span>';
						}
						echo '<li>
                            <a href="'.Url::to($m[1]).'">
                                '.$m[0]. $badge . '</a>
                        </li>';
					}
					
					
					?>
							
						</ul>
					</nav>
				</div>

				<!-- Header Icon -->
				<div class="header-icons">
					
					<?php if (!Yii::$app->user->isGuest) {?>
					<div class="header-wrapicon2">
						<a href="#" class="header-icon1 js-show-header-dropdown">
						<img src="<?=$dirAsset?>/images/icons/icon-header-01.png"  alt="ICON">
						 <?=Yii::$app->user->identity->fullname?> </a>

						<!-- Header cart noti -->
				
					</div>
					<?php }?>
					
					

				
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
				
				<?php if (!Yii::$app->user->isGuest) {?>
				<div class="header-icons-mobile">
					<a href="#" class="header-wrapicon1 dis-block">
						<img src="<?=$dirAsset?>/images/icons/icon-header-01.png" class="header-icon1" alt="ICON">
					</a>

					
				</div>
				<?php }?>

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
                                '.strtoupper($m[0]).'</a>
                        </li>';
					}
					if (Yii::$app->user->isGuest) {
						
					}

					if($conf->system_only == 0){
						$list = json_decode($conf->page_menu);
						if($list){
							foreach($list as $item){
								$page = $conf->pages[$item];
								echo '<li class="item-menu-mobile">
								<a href="'. Url::to(['page/' . $page[1],'confurl' => $conf->conf_url]) . '">
									'.strtoupper($page[0]).'
									</a>
								</li>';
							}
						}
						
						$downloads = $conf->confDownloads;
						if($downloads){
							foreach($downloads as $d){
								echo '<li class="item-menu-mobile">
								<a href="'.Url::to(['download/download-file', 'id' => $d->id]).'" target="_blank">
									'.strtoupper($d->download_name) .'
								</a>
							</li>';
							}
						}
					}
					
					
					
					?>

					
				</ul>
			</nav>
		</div>
	</header>