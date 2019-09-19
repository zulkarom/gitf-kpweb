<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-lg"><b>FKP</b> PORTAL</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
		
		
		<li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

			
			<img src="<?= Url::to(['/staff/staff/image']) ?>" width="20" height="20" class="img-circle" alt="..." />  &nbsp;
             
              <span class="hidden-xs"><?=Yii::$app->user->identity->fullname?></span>
			      &nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-down"></i>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
			  
          
				
				<img src="<?= Url::to(['/staff/staff/image']) ?>" width="160" class="img-circle" alt="...">

                <p>
                  <?=Yii::$app->user->identity->fullname?>                 
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-12 text-center">
                    <a href="<?=Url::to(['/staff/profile'])?>" class="btn btn-default btn-flat"><span class="glyphicon glyphicon-user"></span> View My Profile</a>
                  </div>
             
             
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?=Url::to(['/user-setting/change-password'])?>" class="btn btn-default btn-flat">Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="<?=Url::to(['/site/logout'])?>" class="btn btn-default btn-flat" data-method="post">Log out</a>
                </div>
              </li>
            </ul>
          </li>
		
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu open">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
              <i class="fa fa-envelope-o"></i>
             
            </a>
            
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-bell-o"></i>
            
            </a>
            
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-flag-o"></i>
             
            </a>
            
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
</header>
