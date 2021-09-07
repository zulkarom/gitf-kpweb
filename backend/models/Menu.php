<?php

namespace backend\models;

use Yii;
use common\models\Todo;
use backend\modules\esiap\models\Course;
use backend\modules\esiap\models\Menu as EsiapMenu;
use backend\modules\erpd\models\Stats as ErpdStats;
use backend\modules\conference\models\Conference;

class Menu
{
	public static function courseFocus(){
		return EsiapMenu::courseFocus();
	}
	
	public static function adminErpd(){
		$erpd_admin = [
                        'label' => 'e-RPD Admin',
						'visible' => Yii::$app->user->can('erpd-manager'),
                        'icon' => 'list-ul',
                        'url' => '#',
                        'items' => [
				['label' => 'Summary', 'icon' => 'pie-chart', 'url' => ['/erpd/admin']],
				
				['label' => 'Lecturers', 'icon' => 'user', 'url' => ['/erpd/admin/lecturer']],
				
				['label' => 'Research', 'icon' => 'book', 'url' => ['/erpd/admin/research'],'badge' => ErpdStats::countTotalResearch(), 
			'badgeOptions' => ['class' => 'label pull-right bg-blue']],
				
				['label' => 'Publication', 'icon' => 'send', 'url' => ['/erpd/admin/publication'], 'badge' => ErpdStats::countTotalPublication(), 
			'badgeOptions' => ['class' => 'label pull-right bg-blue']],
				
				
				
				['label' => 'Membership', 'icon' => 'users', 'url' => ['/erpd/admin/membership'], 'badge' => ErpdStats::countTotalMembership(), 
			'badgeOptions' => ['class' => 'label pull-right bg-blue']],
				
				['label' => 'Award', 'icon' => 'trophy', 'url' => ['/erpd/admin/award'], 'badge' => ErpdStats::countTotalAward(), 
			'badgeOptions' => ['class' => 'label pull-right bg-blue']],
				
				['label' => 'Consultation', 'icon' => 'microphone', 'url' => ['/erpd/admin/consultation'], 'badge' => ErpdStats::countTotalConsultation(), 
			'badgeOptions' => ['class' => 'label pull-right bg-blue']],
				
				['label' => 'Knowledge Transfer', 'icon' => 'truck', 'url' => ['/erpd/admin/knowledge-transfer'], 'badge' => ErpdStats::countTotalKtp(), 
			'badgeOptions' => ['class' => 'label pull-right bg-blue']],


                 ]
                    ]
		
		;
		
		return $erpd_admin;
	}
	
	public static function erpd(){
		return [
                        'label' => 'e-RPD Menu',
                        'icon' => 'list-ul',
                        'url' => '#',
                        'items' => [
						
				['label' => 'Summary', 'icon' => 'pie-chart', 'url' => ['/erpd']],
				
				['label' => 'Research', 'icon' => 'book', 'url' => ['/erpd/research'], 'badge' => ErpdStats::countMyResearch(), 
			'badgeOptions' => ['class' => 'label pull-right bg-blue']],
				
				['label' => 'Publication', 'icon' => 'send', 'url' => ['/erpd/publication'], 'badge' => ErpdStats::countMyPublication(), 
			'badgeOptions' => ['class' => 'label pull-right bg-blue']],
				
				
				
				['label' => 'Membership', 'icon' => 'users', 'url' => ['/erpd/membership'], 'badge' => ErpdStats::countMyMembership(), 
			'badgeOptions' => ['class' => 'label pull-right bg-blue']],
				
				['label' => 'Award', 'icon' => 'trophy', 'url' => ['/erpd/award'], 'badge' => ErpdStats::countMyAward(), 
			'badgeOptions' => ['class' => 'label pull-right bg-blue']],
				
				['label' => 'Consultation', 'icon' => 'microphone', 'url' => ['/erpd/consultation'], 'badge' => ErpdStats::countMyConsultation(), 
			'badgeOptions' => ['class' => 'label pull-right bg-blue']],
				
				['label' => 'Knowledge Transfer', 'icon' => 'truck', 'url' => ['/erpd/knowledge-transfer'], 'badge' => ErpdStats::countMyKtp(), 
			'badgeOptions' => ['class' => 'label pull-right bg-blue']],


                 ]
                    ]
		
		;
	}
	
	public static function adminEsiap(){
		return EsiapMenu::adminEsiap();
		
	}
	
	public static function adminStudents(){
		return [
			'label' => 'Students',
			'icon' => 'users',
			'url' => '#',
			'items' => [

				['label' => 'Active Students', 'icon' => 'user', 'url' => ['/students/student'], 'visible' => Yii::$app->user->can('students-manager')],
				
				['label' => 'Downloads', 'icon' => 'download', 'url' => ['/students/download'], 'visible' => Yii::$app->user->can('students-manager')],

				
				['label' => 'Internship', 'icon' => 'book', 'url' => ['/students/internship'], 'visible' => Yii::$app->user->can('internship-manager')],
				
				['label' => 'Dean\'s List Cert', 'icon' => 'trophy', 'url' => ['/students/deanlist'], 'visible' => Yii::$app->user->can('students-manager')],
				
				['label' => 'Matric Cards', 'icon' => 'credit-card', 'url' => ['/students/deanlist'], 'visible' => Yii::$app->user->can('students-manager')],
			],
		];	
	}
	
	public static function adminCourseFiles(){
		//kena allow auditors jgk
		//UJAKA?
		$esiap_admin = [
                        'label' => 'Course Files Admin',
                        'icon' => 'cog',
						'visible' => Yii::$app->user->can('course-files'),
                        'url' => '#',
                        'items' => [
				
				['label' => 'Summary', 'icon' => 'bar-chart', 'url' => ['/course-files/admin/summary']],
				
				['label' => 'All Courses', 'icon' => 'book', 'url' => ['/course-files/admin/index']],
				
				
				['label' => 'Teaching Materials', 'icon' => 'book', 'url' => ['/course-files/material-admin/index']],
				['label' => 'Dates Setting', 'icon' => 'cog', 'url' => ['/course-files/admin/dates']],
                 ],
				
        ];	
		return $esiap_admin;
	}
	
	public static function adminTeachingLoad(){
		$teaching_load = false;
		if(Yii::$app->user->can('teaching-load-manager') or Yii::$app->user->can('teaching-load-program-coor')){
			$teaching_load = true;
		}

		$esiap_admin = [
                        'label' => 'Teaching Loads Admin',
                        'icon' => 'book',
						'visible' => $teaching_load,
                        'url' => '#',
                        'items' => [
				
				//['label' => 'My Course Selection', 'icon' => 'user', 'url' => ['/teaching-load/default/teaching-view']],
				
				['label' => 'Assign Teaching Load', 'icon' => 'book', 'visible' => Yii::$app->user->can('teaching-load-manager'), 'url' => ['/teaching-load/course-offered/index']],
				['label' => 'Program Coordinator', 'icon' => 'user', 'url' => ['/teaching-load/course-offered/program-coor']],
				
				[
					'label' => 'Teaching Load Report',
					'icon' => 'cube',
					'url' => '#',
					'items' => [
						['label' => 'Loading By Course', 'icon' => 'book', 'url' => ['/teaching-load/manager/summary-by-course']],
						
						['label' => 'Loading By Staff', 'icon' => 'user', 'url' => ['/teaching-load/manager/summary-by-staff']],
						

					]
                ],
				
				[
					'label' => 'Appointment Letter',
					'icon' => 'envelope',
					'visible' => Yii::$app->user->can('teaching-load-manager'),
					'url' => '#',
					'items' => [
						['label' => 'Run Staff Involved', 'icon' => 'user', 'url' => ['/teaching-load/staff-inv/index']],
						
						['label' => 'Generate Reference', 'icon' => 'user', 'url' => ['/teaching-load/staff-inv/generate-reference']],
						
						['label' => 'Dean\'s Approval', 'icon' => 'check-square', 'url' => ['/teaching-load/staff-inv/approve-letter']],
						

					]
                ],
				
				[
					'label' => 'Teaching Load Setting',
					'visible' => Yii::$app->user->can('teaching-load-manager'),
					'icon' => 'cog',
					'url' => '#',
					'items' => [
						['label' => 'Staff Loading Hour', 'icon' => 'clock-o', 'url' => ['/teaching-load/manager/maximum-hour']],
	
						
						['label' => 'Course Contact Hour', 'icon' => 'clock-o', 'url' => ['/teaching-load/manager/contact-hour']],
						
						['label' => 'Letter Template', 'icon' => 'cog', 'url' => ['/teaching-load/tmpl-appointment']],
						

					]
                ],

								
				
				
				

				
				
				
				[
					'label' => 'Staff Course Selection',
					'visible' => Yii::$app->user->can('teaching-load-manager'),
					'icon' => 'hand-pointer-o',
					'url' => '#',
					'items' => [
						['label' => 'Selection By Staff', 'icon' => 'user', 'url' => ['/teaching-load/manager/by-staff']],
						['label' => 'Selection By Course', 'icon' => 'book', 'url' => ['/teaching-load/manager/by-course']],
						['label' => 'Selection Due Date', 'icon' => 'cog', 'url' => ['/teaching-load/manager/setting']],
						

					]
                ]

                 ]
                    ];	
		return $esiap_admin;
	}
	
	public static function teachingLoad(){
		//$is_auditor
		return [
                        'label' => 'Course File',
                        'icon' => 'book',
                        'url' => '#',
                        'items' => [
				
				['label' => 'My Course File', 'icon' => 'book', 'url' => ['/course-files/default/teaching-assignment']],
				
				['label' => 'Internal Auditors', 'icon' => 'check-square-o', 'url' => ['/course-files/auditor/index']],
                            
                ['label' => 'Program Coordinator', 'icon' => 'user', 'url' => ['/course-files/admin/program-coordinator']],
				
				['label' => 'My Teaching Selection', 'icon' => 'hand-pointer-o', 'url' => ['/teaching-load/default/teaching-view']],
				
				

                 ]
                    ];	
	}

	public static function website(){
		$website = [
                        'label' => 'Website Menu',
                        'icon' => 'list-ul',
						'visible' => Yii::$app->user->can('website-manager'),
                        'url' => '#',
                        'items' => [
						
				['label' => 'Summary', 'icon' => 'pie-chart', 'url' => ['/website']],
				
				['label' => 'Programs', 'icon' => 'cubes', 'url' => ['/website/program']],
				
				
				['label' => 'Front Slider', 'icon' => 'pencil', 'url' => ['/website/front-slider']],
				
				['label' => 'Event List', 'icon' => 'list', 'url' => ['/website/event']],
				

                 ]
                    ];
		return $website;
	}
	
	public static function adminAduan(){
		$website = [
                        'label' => 'Aduan Admin',
                        'icon' => 'list-ul',
						'visible' => Yii::$app->user->can('manage-aduan'),
                        'url' => '#',
                        'items' => [
						
				['label' => 'Intro', 'icon' => 'code', 'url' => ['/aduan']],
				
				['label' => 'Stats', 'icon' => 'pie-chart', 'url' => ['/aduan/aduan/stats']],
				
				
				['label' => 'Senarai Aduan', 'icon' => 'list', 'url' => ['/aduan/aduan/index']],
				
				['label' => 'Daftar Aduan', 'icon' => 'plus', 'url' => ['/aduan/aduan/create']],
				
				['label' => 'Panduan', 'icon' => 'book', 'url' => ['/aduan/guideline/index']],
				
				['label' => 'Setting', 'icon' => 'gear', 'url' => ['/aduan/aduan/setting']],
				

                 ]
                    ];
		return $website;
	}
	
	public static function staff(){
		$staff = [];
		if(Yii::$app->user->can('staff-management')){
			$staff = [
                        'label' => 'Staff Menu',
						'visible' => Yii::$app->user->can('staff-management'),
                        'icon' => 'list-ul',
                        'url' => '#',
                        'items' => [
						
				['label' => 'Summary', 'icon' => 'pie-chart', 'url' => ['/staff']],
				
				//['label' => 'New Staff', 'icon' => 'plus', 'url' => ['/staff/staff/create']],
				
				['label' => 'Staff List', 'icon' => 'user', 'url' => ['/staff/staff']],
				
				['label' => 'Related External', 'icon' => 'user', 'url' => ['/staff/staff/external']],
				
				['label' => 'Main Position', 'icon' => 'cubes', 'url' => ['/staff/default/main-position']],

				['label' => 'Transfered/Quit', 'icon' => 'remove', 'url' => ['/staff/staff/inactive']],
				

                 ]
                    ];
		}
		
		return $staff;
	}
	
	public static function profile(){
		return [
			'label' => 'My Profile',
			'icon' => 'user',
			'url' => '#',
			'items' => [
				
				['label' => 'Update Profile', 'icon' => 'pencil', 'url' => ['/staff/profile'],],
				
				['label' => 'My Education', 'icon' => 'mortar-board', 'url' => ['/staff/profile/education'],],
			
				['label' => 'Change Password', 'icon' => 'lock', 'url' => ['/user-setting/change-password'],],
				
			
				
				
				
				['label' => 'Log Out', 'icon' => 'arrow-left', 'url' => ['/site/logout'], 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>']


			],
		];
	}
	
	public static function conference(){
		
		if(Yii::$app->getRequest()->getQueryParam('conf')){
		$confurl = Yii::$app->getRequest()->getQueryParam('conf');

		$conf = Conference::findOne(Yii::$app->getRequest()->getQueryParam('conf'));

		if($conf){
		    
		    
		    $paper_menu[] = ['label' => 'Abstract', 'icon' => 'file-o', 'url' => ['/conference/paper/abstract', 'conf' => $confurl]];
		    $paper_menu[] = ['label' => 'Full Paper', 'icon' => 'file', 'url' =>  ['/conference/paper/full-paper', 'conf' => $confurl]];
		    
		    $paper_menu[] = ['label' => 'Review', 'icon' => 'search', 'url' =>  ['/conference/paper/review', 'conf' => $confurl]];
		    
		    $paper_menu[] =  ['label' => 'Correction', 'icon' => 'edit', 'url' =>  ['/conference/paper/correction', 'conf' => $confurl]];
		    
		   // $paper_menu[] = ['label' => 'Payment', 'icon' => 'dollar', 'url' =>  ['/conference/paper/payment', 'conf' => $confurl]];
		    
		    $paper_menu[] = ['label' => 'Complete', 'icon' => 'check', 'url' =>  ['/conference/paper/complete', 'conf' => $confurl]];
		    
		   $paper_menu[] =  ['label' => 'Reject', 'icon' => 'remove', 'url' =>  ['/conference/paper/reject', 'conf' => $confurl]];
		    
		    $paper_menu[] = ['label' => 'Overview', 'icon' => 'table', 'url' =>  ['/conference/paper/overview', 'conf' => $confurl]];
		    
		    
		    
		    
			$menus = [
			
					'label' => $conf->conf_abbr,
					'icon' => 'microphone',
					//'visible' => $teaching_load,
					'url' => '#',
					'items' => [
					

					[
						'label' => 'Paper\'s Flow',
						'icon' => 'files-o',
						'url' => '#',
					    'items' =>  $paper_menu,
					],
					
					[
						'label' => 'Website',
						'icon' => 'tv',
						//'visible' => Yii::$app->user->can('teaching-load-manager'),
						'url' => '#',
						'items' => [
							['label' => 'Content', 'icon' => 'file', 'url' =>['/conference/conference/update', 'conf' => $confurl]],
							
							['label' => 'Important Dates', 'icon' => 'calendar', 'url' => ['/conference/conference/dates', 'conf' => $confurl]],
							
							['label' => 'Fees & Payments', 'icon' => 'dollar', 'url' => ['/conference/conference/fees', 'conf' => $confurl]],
							
							['label' => 'Tentatives', 'icon' => 'clock-o', 'url' => ['/conference/conference/tentative', 'conf' => $confurl]],
							
							['label' => 'Downloads', 'icon' => 'download', 'url' => ['/conference/download/index', 'conf' => $confurl]],
							

						]
					],
					
					[
						'label' => 'Setting',
						//'visible' => Yii::$app->user->can('teaching-load-manager'),
						'icon' => 'cog',
						'url' => '#',
						'items' => [
							['label' => 'Conference', 'icon' => 'cog', 'url' => ['/conference/setting/index', 'conf' => $confurl]],
		
							
							['label' => 'Payment & Receipt', 'icon' => 'dollar', 'url' => ['/conference/setting/payment', 'conf' => $confurl]],
							
							['label' => 'Email Template', 'icon' => 'envelope', 'url' => ['/conference/setting/email-template', 'conf' => $confurl]],
						    
						    ['label' => 'Papers', 'icon' => 'file', 'url' => ['/conference/setting/paper', 'conf' => $confurl]],
							//email-template

						]
					],

					['label' => 'Participants', 'icon' => 'users', 'url' => ['/conference/register/index', 'conf' => $confurl]],

					 ]
						];	
			return $menus;
		}
			
	
		

		}
		
		
	}

}
