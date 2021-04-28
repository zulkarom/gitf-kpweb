<?php 

use yii\helpers\Url;


$this->title= 'Article';
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@confsite/views/myasset');
?>



<div class="block-content">

		<div class="container">
			
			<br />
			<div class="row">
			<div class="col-lg-1"></div>
			<div class="col-lg-8">
			<p>
			<b><?=$model->journal->journalName?></b><br />
			
			<div class="row">
<div class="col-md-6"><i style="font-size:10pt"><?=$model->journalIssue->journalIssueName3?></i></div>

<div class="col-md-6" align="right"><i style="font-size:10pt">Page <?=$model->page_from?> - <?=$model->page_to?></i>
</div>

</div>
			
			
			</p>
			<hr />
			
			<div class="row">
				<div class="col">
					<h2 class="section_title" style="margin-bottom:25px;"><?=$model->title?></h2>
				</div>

			</div>
			
			<p><?=$model->authorString(', ')?></p>
			
			<p><i style="font-size:10pt"><?=$model->doi_ref?></i></p>
			
			
			
			<hr />
			<h4 style="margin-bottom:25px;">Abstract</h4>
			
			<p style="text-align:justify">
			<?=$model->abstract?>
			</p>
			
			<h4 style="margin-bottom:25px;margin-top:20px;">Keywords</h4>
			
			<p>
			<?=$model->keyword?>
			</p>
			
			
			
			</div>
			
			<div class="col-lg-3" style="text-align:center">
			
			<h4 style="margin-bottom:25px;margin-top:20px;">Download</h4>
			
			<div class="form-group"><a href="<?=Url::to($model->linkArticle())?>" class="btn btn-outline-danger" target="_blank"><i class="fa fa-download"></i> Full Paper</a></div> 
			
			<h4 style="margin-bottom:25px;margin-top:20px;">Cite</h4>
			
			<div class="form-group"><a href="<?=Url::to(['page/bibtext', 'id' => $model->id])?>" class="btn btn-outline-success" target="_blank"><i class="fa fa-download"></i> BibTex</a></div>
			
			</div>
				
				<br />
				
				
				
			
			</div>
			

		</div>
	</div>
	
<br /><br /><br />