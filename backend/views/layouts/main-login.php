<?php
use yii\helpers\Html;
use dmstr\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

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
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web/images/favicon.png') ?>">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style>
    /* Split login layout */
    body.login-page { background: linear-gradient(135deg, #24406f 0%, #2a5d9a 60%, #2f73c4 100%); }
    .auth-split { display:flex; height:100vh; overflow:hidden; }
    /* Left: form side */
    .auth-left { flex:1 1 45%; display:flex; align-items:center; justify-content:center; padding:24px 16px; }
    /* Right: image side */
    .auth-right { flex:1 1 55%; padding:0; }
    .auth-right .right-bg { height: calc(100vh - 24px); margin:12px; border-radius:12px; background-image:url('<?=$dirAsset?>/images/fkp_env.jpg'); background-size:cover; background-position:right center; }
    .login-card { width:100%; max-width:480px; background:#fff; border-radius:16px; box-shadow: 0 20px 40px rgba(0,0,0,.08); padding:32px 28px; border: 1px solid rgba(0,0,0,.04); }
    .login-logo { text-align:center; margin-bottom:12px; }
    .login-card .login-box-msg { margin: 8px 0 18px; color:#495057; font-size:16px; }
    /* Inputs */
    .login-card .form-control { border-radius:10px; border-color:#e3e6ea; box-shadow:none; transition: all .15s ease; }
    .login-card .form-control:focus { border-color:#86b7fe; box-shadow: 0 0 0 0.2rem rgba(13,110,253,.15); }
    /* Primary button with default blue gradient */
    .login-card .btn-primary { 
        border:0; border-bottom:0; border-radius:999px; padding:10px 18px; 
        background: linear-gradient(135deg, #24406f 0%, #2a5d9a 60%, #2f73c4 100%);
        box-shadow: 0 8px 18px rgba(47,107,255,.25);
        transition: transform .05s ease, box-shadow .2s ease, filter .2s ease;
    }
    .login-card .btn-primary:hover { filter: brightness(1.03); box-shadow: 0 10px 22px rgba(47,107,255,.3); }
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
        <?= Html::img($dirAsset . '/images/logo-fkp-portal.png', ['alt' => 'FKP Portal', 'style' => 'max-width:160px;height:auto;margin-bottom:6px;']) ?><br />
        <span style="font-size:22px"><b>STAFF LOGIN</b></span>
      </div>
      <?= Alert::widget() ?>
      <?= $content ?>
      <br />
      <div align="center">
        <?= Html::a('Log In Page', ['/user/security/login']) ?>
      </div>
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
