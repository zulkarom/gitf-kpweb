<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use common\widgets\Alert;

dmstr\web\AdminLteAsset::register($this);
backend\assets\AppAsset::register($this);
$dirAsset = Yii::getAlias('@web');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
    /* Split login layout (mirrors backend) */
    body.login-page { background: linear-gradient(135deg, #7f1d1d 0%, #b91c1c 60%, #ef4444 100%); }
    .auth-split { display:flex; height:100vh; overflow:hidden; }
    /* Left: form side */
    .auth-left { flex:1 1 45%; display:flex; align-items:center; justify-content:center; padding:24px 16px; }
    /* Right: image side */
    .auth-right { flex:1 1 55%; padding:0; }
    .auth-right .right-bg { height: calc(100vh - 24px); margin:12px; border-radius:12px; background-image:url('<?=$dirAsset?>/images/login.jpg'); background-size:cover; background-position:center center; }
    .login-card { width:100%; max-width:480px; background:#fff; border-radius:16px; box-shadow: 0 20px 40px rgba(0,0,0,.08); padding:32px 28px; border: 1px solid rgba(0,0,0,.04); }
    .login-logo { text-align:center; margin-bottom:12px; }
    .login-card .login-box-msg { margin: 8px 0 18px; color:#495057; font-size:16px; }
    /* Inputs */
    .login-card .form-control { border-radius:10px; border-color:#e3e6ea; box-shadow:none; transition: all .15s ease; }
    .login-card .form-control:focus { border-color:#fda4a4; box-shadow: 0 0 0 0.2rem rgba(239,68,68,.2); }
    /* Primary button */
    .login-card .btn-primary { 
        border:0; border-bottom:0; border-radius:999px; padding:10px 18px; 
        background: linear-gradient(135deg, #7f1d1d 0%, #b91c1c 60%, #ef4444 100%);
        box-shadow: 0 8px 18px rgba(185,28,28,.25);
        transition: transform .05s ease, box-shadow .2s ease, filter .2s ease;
    }
    .login-card .btn-primary:hover { filter: brightness(1.03); box-shadow: 0 10px 22px rgba(239,68,68,.3); }
    .login-card .btn-primary:active { transform: translateY(1px); }
    /* Links */
    .login-card a { text-decoration: none; }
    .login-card a:hover { text-decoration: underline; }
    @media (max-width: 991px) { .auth-split { flex-direction:column; height:auto; }
      .auth-right .right-bg { height:35vh; margin:8px; } }
    </style>
</head>
<body class="login-page">

<?php $this->beginBody() ?>
<div class="auth-split">
  <div class="auth-left">
    <div class="login-card">
      <div class="login-logo" style="font-family:verdana">
        <b>FKP PORTAL</b><br /><span style="font-size:22px">STUDENT LOGIN</span>
      </div>
      <?= Alert::widget() ?>
      <?= $content ?>
    </div>
  </div>
  <div class="auth-right">
    <div class="right-bg"></div>
  </div>
  
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
