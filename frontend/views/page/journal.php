<?php

use yii\helpers\Url;
use yii\grid\GridView;
 
$this->title = $journal-> journalName . ' ' . $journal->journal_name ;
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
?>
<img src="<?=$directoryAsset?>/img/background-simple.jpg" width="100%" />
<div class="block-content">
		<div class="container">
		
		<div class="row">
				<div class="col">
					<h2 class="section_title text-center"><?=$this->title?></h2>
				</div>
		</div>
		
			<div class="row">
			
			<div class="col-lg-12">
			
			 <?=$this->render('../site/_list_articles', [
				'journal' => $journal
			 ])?>
			
			
			</div>
				
				
			
			</div>
			<br />

	
			
			
		</div>
	</div>