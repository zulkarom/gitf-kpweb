<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Url;
use backend\modules\conference\models\Conference;
$conf = null;

$dirAsset = Yii::$app->assetManager->getPublishedUrl('@confmanager/views/myasset');
if(Yii::$app->getRequest()->getQueryParam('conf')){
$confurl = Yii::$app->getRequest()->getQueryParam('conf');

$conf = Conference::findOne(Yii::$app->getRequest()->getQueryParam('conf'));

$menu = [
	['List of Conference', ['site/index'], 'home', null],
];
$sub = [
	['Papers', ['paper/index', 'conf' => $confurl], 'files-o', $conf->paperCount],
	['Website', ['conference/update', 'conf' => $confurl], 'globe', null],
	['Conference Setting', ['setting/index', 'conf' => $confurl], 'cog', null],
	
	['Participants', ['register/index', 'conf' => $confurl], 'users', $conf->userCount],
	//['Organized By', ['site/index'], 'bank', null],
	//['Secretariat', ['site/index'], 'phone', null]
];

}else{
	$menu = [
	['List of Conference', ['site/index'], 'home', null],
];
}

?>
        <div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
					
					
						<li><a href="<?=Url::to(['site/index'])?>" ><i class="lnr lnr-home"></i> <span>List of Conference</span></a></li>
						
						<?php if(Yii::$app->getRequest()->getQueryParam('conf')){?>
						
						
						
						
						
						
						<li><a href="#" class=""> &nbsp;&nbsp; <span><u><b><?=$conf->conf_abbr?></b></u></span></a></li>
						
					
						
						
						<?php
						
						$controller = Yii::$app->controller->id;
						
						
						
					if($controller == 'paper'){
							$collapse = 'collapse in';
							$collapsed = 'active';
							$ariaexpanded = 'aria-expanded="true"';
						}else{
							$collapse = 'collapse';
							$collapsed = 'collapsed';
							$ariaexpanded = 'aria-expanded="false"';
						}
						
					if($controller == 'conference' or $controller == 'download'){
							$wcollapse = 'collapse in';
							$wcollapsed = 'active';
							$wariaexpanded = 'aria-expanded="true"';
						}else{
							$wcollapse = 'collapse';
							$wcollapsed = 'collapsed';
							$wariaexpanded = 'aria-expanded="false"';
						}
					if($controller == 'setting'){
							$scollapse = 'collapse in';
							$scollapsed = 'active';
							$sariaexpanded = 'aria-expanded="true"';
						}else{
							$scollapse = 'collapse';
							$scollapsed = 'collapsed';
							$sariaexpanded = 'aria-expanded="false"';
						}
						
						$paper_menu = [
							['Abstract', 'fa fa-file-o',  ['paper/abstract', 'conf' => $confurl], $conf->paperCountAbstract],
							['Full Paper', 'fa fa-file', ['paper/full-paper', 'conf' => $confurl], $conf->paperCountFullPaper],
							//['Review', 'fa fa-search', ['paper/review', 'conf' => $confurl], 0],
							['Payment', 'fa fa-dollar', ['paper/payment', 'conf' => $confurl], $conf->paperCountPayment],
							['Complete', 'fa fa-check', ['paper/complete', 'conf' => $confurl], $conf->paperCountComplete],
							//['Presenter', 'fa fa-microphone', [''], 0],
							['Overview', 'fa fa-table', ['paper/overview', 'conf' => $confurl], 0],
							];
							
							
						$web_menu = [
							['Content', 'fa fa-file',  ['conference/update', 'conf' => $confurl], 0],
							['Important Dates', 'fa fa-calendar', ['conference/dates', 'conf' => $confurl], 0],
							['Fees & Payment', 'fa fa-dollar', ['conference/fees', 'conf' => $confurl], 0],
							['Tentative', 'fa fa-clock-o', ['conference/tentative', 'conf' => $confurl], 0],
							['Downloads', 'fa fa-download', ['download/index','conf' => $confurl], 0],
							];
						
						$setting_menu = [
							['Conference', 'fa fa-cog',  ['setting/index', 'conf' => $confurl], 0],
							['Payment & Receipt', 'fa fa-dollar', ['setting/payment', 'conf' => $confurl], 0],
							['Email Template', 'fa fa-envelope', ['setting/email-template', 'conf' => $confurl], 0],
							];
						
						
						foreach($sub as $s){
							
							if($s[0] == 'Papers'){
							echo '<li class="has-sub">';
							echo '<a href="#subPagesx" data-toggle="collapse" class="'.$collapsed.'" '.$ariaexpanded.'><i class="fa fa-files-o"></i> <span>Papers\' Flow  <span class="badge badge-primary">'.$s[3].'</span></span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>';
                            echo '
							<div id="subPagesx" class="'.$collapse.'" '.$ariaexpanded.'>
							<ul class="nav">
							';
							foreach($paper_menu as $pm){
								echo '<li><a href="'.Url::to($pm[2]).'"><i class="'.$pm[1].'"></i> '.$pm[0].' '.badge($pm[3]). '</a></li>';
							}
							echo '</ul>
							</div>
							';
							echo '</li>';
							
							
							}else if($s[0] == 'Website'){
								
								
							echo '<li class="has-sub">';
							echo '<a href="#subPagesw" data-toggle="collapse" class="'.$wcollapsed.'" '.$wariaexpanded.'><i class="fa fa-globe"></i> <span>Website </span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>';
                            echo '
							<div id="subPagesw" class="'.$wcollapse.'" '.$wariaexpanded.'>
							<ul class="nav">
							';
							foreach($web_menu as $pm){
								echo '<li><a href="'.Url::to($pm[2]).'"><i class="'.$pm[1].'"></i> '.$pm[0].' '.badge($pm[3]). '</a></li>';
							}
							echo '</ul>
							</div>
							';
							echo '</li>';
							
							
							}else if($s[0] == 'Conference Setting'){
								
								
							echo '<li class="has-sub">';
							echo '<a href="#subPagessetting" data-toggle="collapse" class="'.$scollapsed.'" '.$sariaexpanded.'><i class="fa fa-cog"></i> <span>Setting </span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>';
                            echo '
							<div id="subPagessetting" class="'.$scollapse.'" '.$sariaexpanded.'>
							<ul class="nav">
							';
							foreach($setting_menu as $pm){
								echo '<li><a href="'.Url::to($pm[2]).'"><i class="'.$pm[1].'"></i> '.$pm[0].' '.badge($pm[3]). '</a></li>';
							}
							echo '</ul>
							</div>
							';
							echo '</li>';
							
							
							}else{
								echo '<li>
									<a href="'.Url::to($s[1]).'">
										<i class="fa fa-'.$s[2].'"></i>'.$s[0].' </a>';
										
							
								echo '</li>';
							}
									
										
									
								}
						
						
						?>
						
						<?php } ?>
						
						
						

						
						
					</ul>
				</nav>
			</div>
		</div>

<?php 

function badge($count){
	if($count == 0){
		return '';
	}else{
		return '<span class="badge badge-danger">
		'.$count.'
		</span>';
	}
}

?>  