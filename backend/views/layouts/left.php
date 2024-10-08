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
			
			case 'teaching-load':
			$focus = Menu::teachingLoad();
			$admin_focus = Menu::adminTeachingLoad();
			break;
			
			case 'course-files':
			$focus = Menu::teachingLoad();
			$admin_focus = Menu::adminCourseFiles();
			break;
			
			case 'students':
			$admin_focus = Menu::adminStudents();
			break;

			case 'postgrad':
			$admin_focus = Menu::adminPostGradStudents();
			break;

			case 'sae':
				$admin_focus = Menu::adminSae();
				break;

			case 'protege':
				$admin_focus = Menu::protege();
				break;
			
			case 'aduan':
			$admin_focus = Menu::adminAduan();
			break;

			case 'conference':
			$focus = Menu::conference();
			break;
			case 'ecert':
			$admin_focus = Menu::adminEcert();
		    break;

			

		}
		
		
		?>

        <?php

$focus_menu = [];
if(!empty($focus) or !empty($admin_focus)){
	$focus_menu = [
		['label' => 'FOCUS MENU', 'options' => ['class' => 'header']],
		Menu::courseFocus(),
		$focus,
		$admin_focus,
	
	];
}
$teaching_load = false;
if(Yii::$app->user->can('teaching-load-manager') or Yii::$app->user->can('teaching-load-program-coor')){
	$teaching_load = true;
}

$menuItems = [

					['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/site']],
					
					Menu::profile(),
					//$modules,
					
					['label' => 'MODULES', 'options' => ['class' => 'header']],
					
					['label' => 'Teaching Loads', 'icon' => 'book', 'visible' => $teaching_load, 'url' => ['/teaching-load/default/index']],
					
					['label' => 'Course Files', 'icon' => 'files-o', 'url' => ['/course-files/default/teaching-assignment']],
					
					['label' => 'Staff Info', 'icon' => 'user', 'url' => ['/staff']],
					
					['label' => 'Course Management', 'icon' => 'mortar-board', 'url' => ['/esiap'],],
    
    ['label' => 'Postgraduate', 'icon' => 'cube', 'url' => ['/postgrad/student'], 'visible' => Yii::$app->user->can('postgrad-manager')],
    
                   // ['label' => 'Program Management', 'icon' => 'mortar-board', 'url' => ['/esiap/program'],],
					
					['label' => 'e-RPD', 'icon' => 'flask', 'url' => ['/erpd'],],	
    
                    ['label' => 'Workshop', 'icon' => 'cube', 'url' => ['/workshop/kursus-anjur'], 'visible' => Yii::$app->user->can('workshop-manager')],
    
                    ['label' => 'Students', 'icon' => 'users', 'url' => ['/students/student'], 'visible' => Yii::$app->user->can('students-manager')],
					
					['label' => 'eAduan', 'icon' => 'comments', 'url' => ['/aduan'],],
					
					['label' => 'JEB Journal', 'visible' => false, 'icon' => 'book', 'url' => ['/site/jeb-web'], 'template'=>'<a href="{url}" target="_blank">{icon} {label}</a>'],
					
					['label' => 'Conference', 'icon' => 'microphone', 'visible' => Yii::$app->user->can('conference-manager'), 'url' => ['/conference/conference/index']],
					
					['label' => 'Downloads', 'icon' => 'download', 'visible' => Yii::$app->user->can('download-manager'), 'url' => ['/downloads/download/index']],
					
					['label' => 'e-Certificate', 'icon' => 'file', 'url' => ['/ecert']],
					
                ['label' => 'User Manual', 'icon' => 'book', 'visible' => Yii::$app->user->can('manual-manager'), 'url' => ['/manual/module']],

				['label' => 'SAE Interview', 'icon' => 'book', 'visible' => Yii::$app->user->can('manage-sae'), 'url' => ['/sae']],

				['label' => 'Protege', 'icon' => 'book', 'visible' => Yii::$app->user->can('protege'), 'url' => ['/protege/session']],

				[
					'label' => 'Web',
					'icon' => 'tv',
					'visible' => true,
					'url' => '#',
					'items' => [
					
						['label' => 'Proceedings', 'icon' => 'microphone', 'url' => ['/proceedings'], 'visible' => Yii::$app->user->can('proceedings-manager')],
					
					   /*  ['label' => 'Chapter in Book', 'icon' => 'book', 'url' => ['/chapterinbook'], 'visible' => Yii::$app->user->can('chapterinbook-manager')],
						
						['label' => 'Caknawan', 'icon' => 'book', 'url' => ['/website/caknawan'], 'visible' => Yii::$app->user->can('internship-manager')], */

					],
				],

					
					
					[
                        'label' => 'System Management',
                        'icon' => 'lock',
						'visible' => Todo::can('sysadmin'),
                        'url' => '#',
                        'items' => [
						
							['label' => 'Semester', 'icon' => 'cog', 'url' => ['/semester'],],
						
							['label' => 'User Assignment', 'icon' => 'user', 'url' => ['/admin'],],
						
                            ['label' => 'Role List', 'icon' => 'user', 'url' => ['/admin/role'],],
							
							['label' => 'Route List', 'icon' => 'user', 'url' => ['/admin/route'],],
							
							['label' => 'Login As', 'icon' => 'lock', 'url' => ['/user-admin/login-as'],],
                        ],
                    ],
					
					
					['label' => 'Log Out', 'icon' => 'arrow-left', 'url' => ['/site/logout'], 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>']

];

$favouriteMenuItems[] = ['label' => 'MAIN MENU', 'options' => ['class' => 'header']];





// TODO: display menu
echo common\widgets\Menu::widget([
    'items' => \yii\helpers\ArrayHelper::merge($focus_menu, $favouriteMenuItems, $menuItems),
]);
		
		
		?>

    </section>

</aside>
