<?php

namespace backend\models;

use Yii;
use common\models\Todo;
use backend\modules\esiap\models\Course;
use backend\modules\esiap\models\Menu as EsiapMenu;
use backend\modules\erpd\models\Stats as ErpdStats;

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
		$esiap_admin = [
                        'label' => 'eSIAP Admin',
                        'icon' => 'mortar-board',
						'visible' => Yii::$app->user->can('esiap-management'),
                        'url' => '#',
                        'items' => [
				['label' => 'My Course(s)', 'icon' => 'user', 'url' => ['/esiap']],
				
				['label' => 'Summary', 'icon' => 'pie-chart', 'url' => ['/esiap/dashboard']],
				
				['label' => 'Course List', 'icon' => 'book', 'url' => ['/esiap/course-admin']],
				
				//['label' => 'Bulk Course Version', 'icon' => 'book', 'url' => ['/esiap/course-admin/bulk-version']],
				
				['label' => 'Program List', 'icon' => 'book', 'url' => ['/esiap/program-admin']],
				
				
				
				['label' => 'Inactive Courses', 'icon' => 'remove', 'url' => ['/esiap/course-admin/inactive']],
				

                 ]
                    ];	
		return $esiap_admin;
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
		$esiap_admin = [
                        'label' => 'Course Files Admin',
                        'icon' => 'book',
						'visible' => Todo::can('teaching-load-manager'),
                        'url' => '#',
                        'items' => [
				
				['label' => 'Summary', 'icon' => 'user', 'url' => ['/course-files/default/summary']],
				
				['label' => 'All Courses', 'icon' => 'book', 'url' => ['/course-files/default/index']],
				

                 ]
                    ];	
		return $esiap_admin;
	}
	
	public static function adminTeachingLoad(){
		$esiap_admin = [
                        'label' => 'Teaching Loads Admin',
                        'icon' => 'book',
						'visible' => Todo::can('teaching-load-manager'),
                        'url' => '#',
                        'items' => [
				
				//['label' => 'My Course Selection', 'icon' => 'user', 'url' => ['/teaching-load/default/teaching-view']],
				
				['label' => 'Teaching Assignment', 'icon' => 'book', 'url' => ['/teaching-load/course-offered/index']],
				
				['label' => 'Assignment By Course', 'icon' => 'book', 'url' => ['/teaching-load/manager/summary-by-course']],

				['label' => 'Assignment By Staff', 'icon' => 'user', 'url' => ['/teaching-load/manager/summary-by-staff']],

				['label' => 'Appointment Letter', 'icon' => 'file', 'url' => ['/teaching-load/staff-inv/index']],
								
				['label' => 'Letter Approval', 'icon' => 'file', 'url' => ['/teaching-load/staff-inv/approve-letter']],
				
				['label' => 'Maximum Hour', 'icon' => 'cog', 'url' => ['/teaching-load/manager/maximum-hour']],
				['label' => 'Letter Template', 'icon' => 'cog', 'url' => ['/teaching-load/tmpl-appointment']],

				
				
				
				[
					'label' => 'Course Selection',
					'visible' => Yii::$app->user->can('staff-management'),
					'icon' => 'book',
					'url' => '#',
					'items' => [
						['label' => 'Selection By Staff', 'icon' => 'user', 'url' => ['/teaching-load/manager/by-staff']],
						['label' => 'Selection By Course', 'icon' => 'book', 'url' => ['/teaching-load/manager/by-course']],
						['label' => 'Date Setting', 'icon' => 'cog', 'url' => ['/teaching-load/manager/setting']],
						

					]
                ]

                 ]
                    ];	
		return $esiap_admin;
	}
	
	public static function teachingLoad(){
		return [
                        'label' => 'My Teaching',
                        'icon' => 'book',
                        'url' => '#',
                        'items' => [
				
				['label' => 'Teaching Assignment', 'icon' => 'book', 'url' => ['/course-files/default/teaching-assignment']],
				
				['label' => 'Teaching Selection', 'icon' => 'book', 'url' => ['/teaching-load/default/teaching-view']],

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
		$staff = [
                        'label' => 'Staff Menu',
						'visible' => Yii::$app->user->can('staff-management'),
                        'icon' => 'list-ul',
                        'url' => '#',
                        'items' => [
						
				['label' => 'Summary', 'icon' => 'pie-chart', 'url' => ['/staff']],
				
				//['label' => 'New Staff', 'icon' => 'plus', 'url' => ['/staff/staff/create']],
				
				['label' => 'Staff List', 'icon' => 'user', 'url' => ['/staff/staff']],
				
				['label' => 'Main Position', 'icon' => 'plus', 'url' => ['/staff/default/main-position']],

				['label' => 'Transfered/Quit', 'icon' => 'user', 'url' => ['/staff/staff/inactive']],
				

                 ]
                    ];
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

}
