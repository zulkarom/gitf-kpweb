<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title= strtoupper($model->conf_name) . ' ('.$model->conf_abbr .') - by confvalley.com';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/modules/conference/views/myasset');


$list = json_decode($model->page_featured);
//print_r($list);
if($list){
	foreach($list as $item){
		$page = $model->pages[$item];
			if($item == 'conf_background'){
				$title = $model->conf_name;
			}else{
				$title = $page[0];
			}
		if($item == 'dates'){
			$content = $this->render('../page/_dates', [
				'model' => $model
				]);
		}else if($item == 'fees'){
			$content = $this->render('../page/_fees', [
				'model' => $model
				]);
		}else if($item == 'tentative'){
			$content = $this->render('../page/_tentative', [
				'model' => $model
				]);
		}else{
			$content = $model->{$item};
		}
		
		echo '<div class="item-blog-txt p-t-33">
				<h4 class="p-b-11">
					<a href="'.Url::to(['page/' . $page[1], 'confurl' => $model->conf_url]).'" class="m-text24">
						'.$title.'
					</a>
				</h4>
				<p class="p-b-12">
					'.$content.'
				</p>
			</div>';
	}
	
}


?>
