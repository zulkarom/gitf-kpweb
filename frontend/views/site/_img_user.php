<?php 

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
?>

<img src="<?=$directoryAsset?>/img/background_small_login.jpg" width="100%" />
