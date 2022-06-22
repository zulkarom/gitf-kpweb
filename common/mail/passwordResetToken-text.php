<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>

Hello,

We have received a request to reset the password for your account on <?=Yii::$app->name?>.
Please click the link below to complete your password reset.

<?= $resetLink ?>

If you cannot click the link, please try pasting the text into your browser.

If you did not make this request you can ignore this email.