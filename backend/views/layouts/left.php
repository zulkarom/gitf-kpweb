<?php 
use common\models\Todo;
use yii\helpers\Url;
use backend\modules\jeb\models\Menu as JebMenu;

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Url::to(['/staff/staff/image']) ?>" class="img-circle" alt="User Image"/>
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
		
		$course_focus = '';
		if(Yii::$app->controller->id == 'course' and Yii::$app->controller->module->id == 'esiap'){
			switch(Yii::$app->controller->action->id){
				case 'course-version':
				case 'update': case 'profile':case 'course-clo':
				case 'course-syllabus':case 'course-assessment':
				case 'clo-assessment':case 'course-slt': case 'clo-plo':
				case 'clo-taxonomy':case 'clo-softskill': case 'course-reference':
				case 'clo-delivery':
				$course_id = Yii::$app->getRequest()->getQueryParam('course');
				$course = backend\modules\esiap\Models\Course::findOne($course_id);
				$course_focus  = [
                        'label' => $course->crs_name,
                        'icon' => 'book',
						'format' => 'html',
                        'url' => '#',
                        'items' => [
						
				['label' => 'Course Nomenclature', 'icon' => 'pencil', 'url' => ['/esiap/course/update', 'course' => $course_id]],
				
				['label' => 'Course Version', 'icon' => 'pencil', 'url' => ['/esiap/course/course-version', 'course' => $course_id]],
				
				['label' => 'Course Pro Forma', 'icon' => 'book', 'url' => ['/esiap/course/profile', 'course' => $course_id]],
				
				['label' => 'Course Learning Outcome', 'icon' => 'book', 'url' => ['/esiap/course/course-clo', 'course' => $course_id]],
				
				['label' => 'CLO PLO', 'icon' => 'book', 'url' => ['/esiap/course/clo-plo', 'course' => $course_id]],
				
				['label' => 'CLO Taxonomy', 'icon' => 'book', 'url' => ['/esiap/course/clo-taxonomy', 'course' => $course_id]],
				
				['label' => 'CLO Softskill', 'icon' => 'book', 'url' => ['/esiap/course/clo-softskill', 'course' => $course_id]],
				
				['label' => 'CLO Delivery', 'icon' => 'book', 'url' => ['/esiap/course/clo-delivery', 'course' => $course_id]],
				
				
				
				
				
				['label' => 'Syllabus', 'icon' => 'book', 'url' => ['/esiap/course/course-syllabus', 'course' => $course_id]],
				
				['label' => 'Assessment', 'icon' => 'book', 'url' => ['/esiap/course/course-assessment', 'course' => $course_id]],
				
				['label' => 'CLO Assessment', 'icon' => 'book', 'url' => ['/esiap/course/clo-assessment', 'course' => $course_id]],
				['label' => 'Student Learning Time', 'icon' => 'book', 'url' => ['/esiap/course/course-slt', 'course' => $course_id]],
				
				
				['label' => 'References', 'icon' => 'book', 'url' => ['/esiap/course/course-reference', 'course' => $course_id]],
				
				['label' => 'Report', 'icon' => 'book', 'url' => ['/esiap/course']],

                 ]
                    ];
				break;
			}
		}
		
		
		$admin_jeb = [
                        'label' => 'JEB Admin',
						'visible' => Todo::can('jeb-administrator'),
                        'icon' => 'list-ul',
                        'url' => '#',
                        'items' => [
						
				//['label' => 'Admin Stats', 'icon' => 'dashboard', 'url' => ['/jeb'],],
				
				
				
				['label' => 'User Management', 'icon' => 'user', 'url' => ['/jeb/user']],
				
				['label' => 'General Setting', 'icon' => 'cog', 'url' => ['/jeb/setting']],
				
				['label' => 'Email Template', 'icon' => 'envelope', 'url' => ['/jeb/email-template']],


                 ]
                    ]
		
		;
		
		$erpd = [
                        'label' => 'e-RPD Menu',
                        'icon' => 'list-ul',
                        'url' => '#',
                        'items' => [
						
				//['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/erpd'],],
				
				['label' => 'Research', 'icon' => 'book', 'url' => ['/erpd/research'],],
				
				['label' => 'Publication', 'icon' => 'send', 'url' => ['/erpd/publication'],],
				
				
				
				['label' => 'Membership', 'icon' => 'pencil', 'url' => ['/erpd/membership'],],
				
				['label' => 'Award', 'icon' => 'book', 'url' => ['/erpd/award'],],
				
				['label' => 'Consultation', 'icon' => 'book', 'url' => ['/erpd/consultation'],],
				
				['label' => 'Knowledge Transfer', 'icon' => 'book', 'url' => ['/erpd/knowledge-transfer'],],


                 ]
                    ]
		
		;
		
		$erpd_admin = [
                        'label' => 'e-RPD Admin',
                        'icon' => 'list-ul',
                        'url' => '#',
                        'items' => [
						
				//['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/erpd'],],
				
				['label' => 'Research', 'icon' => 'book', 'url' => ['/erpd/research/all'],],
				
				['label' => 'Publication', 'icon' => 'send', 'url' => ['/erpd/publication/all'],],
				
				
				
				['label' => 'Membership', 'icon' => 'pencil', 'url' => ['/erpd/membership/all'],],
				
				['label' => 'Award', 'icon' => 'book', 'url' => ['/erpd/award/all'],],
				
				['label' => 'Consultation', 'icon' => 'book', 'url' => ['/erpd/consultation/all'],],
				
				['label' => 'Knowledge Transfer', 'icon' => 'book', 'url' => ['/erpd/knowledge-transfer/all'],],


                 ]
                    ]
		
		;
		
		$staff = [
                        'label' => 'Staff Menu',
                        'icon' => 'list-ul',
                        'url' => '#',
                        'items' => [
						
				//['label' => 'Staff Dashboard', 'icon' => 'dashboard', 'url' => ['/staff']],
				
				['label' => 'New Staff', 'icon' => 'plus', 'url' => ['/staff/staff/create']],
				
				['label' => 'Staff List', 'icon' => 'user', 'url' => ['/staff/staff']],
				
				['label' => 'Inactive', 'icon' => 'user', 'url' => ['/staff/staff/inactive']],
				

                 ]
                    ];
		$website = [
                        'label' => 'Website Menu',
                        'icon' => 'list-ul',
                        'url' => '#',
                        'items' => [
						
				['label' => 'Website Dashboard', 'icon' => 'dashboard', 'url' => ['/website']],
				
				['label' => 'Front Slider', 'icon' => 'pencil', 'url' => ['/website/front-slider']],
				
				['label' => 'Event List', 'icon' => 'list', 'url' => ['/website/event']],
				

                 ]
                    ];
					
		$esiap = [
                        'label' => 'eSIAP Menu',
                        'icon' => 'list-ul',
                        'url' => '#',
                        'items' => [
						
				//['label' => 'eSiap Dashboard', 'icon' => 'dashboard', 'url' => ['/esiap']],
				
				['label' => 'Program List', 'icon' => 'book', 'url' => ['/esiap/program']],
				
				['label' => 'Course List', 'icon' => 'book', 'url' => ['/esiap/course']],
				

                 ]
                    ];	
					
		$my = [];
		$focus = [];
		$admin_focus = [];
		
		switch(Yii::$app->controller->module->id){
			case 'jeb':
			$focus = JebMenu::committee();
			$admin_focus = $admin_jeb;
			break;
			
			case 'erpd':
			$focus = $erpd;
			$admin_focus = $erpd_admin;
			break;
			
			case 'staff':
			$focus = $staff;
			break;
			
			case 'website':
			$focus = $website;
			break;
			
			case 'esiap':
			$focus = $esiap;
			break;
			

		}
		
		
		?>

        <?=common\models\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'MAIN MENU', 'options' => ['class' => 'header']],
					['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/site']],
					$course_focus,
					
					
					
					$focus,
					$admin_focus,
					//$modules,
					
					['label' => 'MODULES', 'options' => ['class' => 'header']],
					['label' => 'STAFF', 'icon' => 'user', 'url' => ['/staff/staff/index'],],
					
					['label' => 'e-SIAP', 'icon' => 'mortar-board', 'url' => ['/esiap/course'],],
					
					['label' => 'e-RPD', 'icon' => 'flask', 'url' => ['/erpd/research'],],	
					
					['label' => 'JEB JOURNAL', 'icon' => 'book', 'url' => ['/jeb'],],
					
					['label' => 'WEBSITE', 'icon' => 'tv', 'url' => ['/website'],],
					
					
					[
                        'label' => 'User Management',
                        'icon' => 'lock',
						'visible' => Todo::can('sysadmin'),
                        'url' => '#',
                        'items' => [
							
							['label' => 'New External User', 'icon' => 'plus', 'url' => ['/user/create'],],
						
							['label' => 'User Role', 'icon' => 'user', 'url' => ['/user/assignment'],],
							
							//['label' => 'User Signup', 'icon' => 'plus', 'url' => ['/admin/user/signup'],],
							
							
							/* ['label' => 'User Assignment', 'icon' => 'user', 'url' => ['/admin'],], */
						
                            ['label' => 'Role List', 'icon' => 'user', 'url' => ['/admin/role'],],
							
							['label' => 'Route List', 'icon' => 'user', 'url' => ['/admin/route'],],
							
	
							

                        ],
                    ],
					
					//['label' => 'Change Password', 'icon' => 'lock', 'url' => ['/user/change-password']],
					
					['label' => 'Log Out', 'icon' => 'arrow-left', 'url' => ['/site/logout'], 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>']
					



					


                ],
            ]
        ) ?>

    </section>

</aside>
