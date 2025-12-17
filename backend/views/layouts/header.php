<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a(
        Html::img(Url::to('@web/images/logo-fkp-portal-horizontal.png'), ['alt' => 'FKP PORTAL', 'style' => 'max-height:35px;width:auto;']),
        Yii::$app->homeUrl,
        ['class' => 'logo']
    ) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
		
		
		<li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

			
			<img src="<?= Url::to(['/staff/profile/image']) ?>" width="20" height="20" class="img-circle" alt="..." />  &nbsp;
			
			<?php 
			$user = Yii::$app->user->identity;
			$title = $user->staff->staff_title;
			$name = $title .' '. $user->fullname;
			
			?>
             
              <span class="hidden-xs"><?=$name?></span>
			      &nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-down"></i>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
			  
          
				
				<img src="<?= Url::to(['/staff/profile/image']) ?>" width="160" class="img-circle" alt="...">

                <p>
                  <?=$name?>                 
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
				<?php 
				$session = Yii::$app->session;
				$col = $session->has('or-usr') ? 6 : 12;
				?>
                  <div class="col-xs-<?=$col?> text-center">
                    <a href="<?=Url::to(['/staff/profile'])?>" class="btn btn-default"><span class="glyphicon glyphicon-user"></span> View Profile</a>
                  </div>
				  <?php 
				  if ($session->has('or-usr')){ ?>
					<div class="col-xs-6 text-center">
                    <a href="<?=Url::to(['/user-setting/return-role'])?>" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span> Return Role</a>
                  </div>
				  <?php } ?>
				
             
             
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
