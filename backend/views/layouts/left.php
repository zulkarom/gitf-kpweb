<?php 
use common\models\Todo;
use yii\helpers\Url;
use backend\models\Menu;

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Url::to(['/staff/profile/image']) ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>
				<?php 
		
		
		
		
		  $str = Yii::$app->user->identity->staff->user->fullname;
		  if (strlen($str) > 10)
		$str = substr($str, 0, 17) . '...';
		  echo $str;
		  ?>
				
				</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
		
		<?php 
					
		$my = [];
		$focus = [];
		$admin_focus = [];
		
		switch(Yii::$app->controller->module->id){
			
			case 'erpd':
			$focus = Menu::erpd();
			$admin_focus = Menu::adminErpd();
			break;
			
			case 'staff':
			$focus = Menu::staff();
			break;
			
			case 'website':
			$focus = Menu::website();
			break;
			
			case 'esiap':
			//$focus = Menu::coursePic();
			$admin_focus = Menu::adminEsiap();
			break;
			

		}
		
		
		?>

        <?=common\models\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'MAIN MENU', 'options' => ['class' => 'header']],
					['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/site']],
					Menu::courseFocus(),
					$focus,
					$admin_focus,
					Menu::profile(),
					//$modules,
					
					['label' => 'MODULES', 'options' => ['class' => 'header']],
					['label' => 'STAFF', 'icon' => 'user', 'url' => ['/staff']],
					
					['label' => 'e-SIAP', 'icon' => 'mortar-board', 'url' => ['/esiap'],],
					
					['label' => 'e-RPD', 'icon' => 'flask', 'url' => ['/erpd'],],	
					
					['label' => 'JEB JOURNAL', 'icon' => 'book', 'url' => ['/site/jeb-web'], 'template'=>'<a href="{url}" target="_blank">{icon} {label}</a>'],
					
					['label' => 'WEBSITE', 'icon' => 'tv', 'url' => ['/website'],],
					
					
					[
                        'label' => 'User Management',
                        'icon' => 'lock',
						'visible' => Todo::can('sysadmin'),
                        'url' => '#',
                        'items' => [
						
							['label' => 'User Assignment', 'icon' => 'user', 'url' => ['/admin'],],
						
                            ['label' => 'Role List', 'icon' => 'user', 'url' => ['/admin/role'],],
							
							['label' => 'Route List', 'icon' => 'user', 'url' => ['/admin/route'],],
							
							['label' => 'Login As', 'icon' => 'lock', 'url' => ['/user-admin/login-as'],],
							
	
							

                        ],
                    ],
					
					
					['label' => 'Log Out', 'icon' => 'arrow-left', 'url' => ['/site/logout'], 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>']
					



					


                ],
            ]
        ) ?>

    </section>

</aside>
