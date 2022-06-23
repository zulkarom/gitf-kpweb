<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token, 'c' => $conf_id]);
?>
Hello,

Your account on <?=Yii::$app->name?> has been created.

In order to complete your registration, please click the link below.

<?= $verifyLink ?>
 
If you cannot click the link, please try pasting the text into your browser.

If you did not make this request you can ignore this email.