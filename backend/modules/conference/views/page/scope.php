<?php 
$this->title = 'EDITORIAL COMMITTEES';
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@confsite/views/myasset');
?>


<div class="block-content">
		<div class="container">
		
		<div class="row">
				<div class="col">
					<h3 class="section_title text-center">AIMS AND SCOPE</h3>
					<br />
				</div>
		</div>
		
		<div class="col-12 container">
		<p>The scope of the journal is broad and it includes but not limited to the following topics:</p>
		<br />
  <ul class="list-unstyled row">
			<?php 
			
			$scopes = $journal->journalScopes;
			foreach($scopes as $scope){
				echo  '<li class="list-item col-4 py-2">' . $scope->scope->scope_name . '</li>';
			}
			
			
			
			?>
  </ul>
</div>
	
			
			
		</div>
	</div>