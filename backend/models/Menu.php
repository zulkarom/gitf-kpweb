<?php

namespace backend\models;

use Yii;
use common\models\Todo;
use backend\modules\esiap\models\Course;
use backend\modules\erpd\models\Stats as ErpdStats;

class Menu
{
	
	
	public static function courseFocus(){
		$course_focus = [];
		if(Yii::$app->controller->id == 'course' and Yii::$app->controller->module->id == 'esiap'){
			switch(Yii::$app->controller->action->id){
				case 'update': case 'profile':case 'course-clo':
				case 'course-syllabus':case 'course-assessment':
				case 'clo-assessment':case 'course-slt': case 'clo-plo':
				case 'clo-taxonomy':case 'clo-softskill': case 'course-reference':
				case 'clo-delivery':case 'report':
				$course_id = Yii::$app->getRequest()->getQueryParam('course');
				$course = Course::findOne($course_id);
				$version = $course->developmentVersion;
				$status = $version->status;
				$show = false;
				if($status == 0 and $course->IAmCoursePic()){
					$show = true;
				}
				$course_focus  = [
					'label' => $course->course_name,
					'icon' => 'book',
					'format' => 'html',
					'url' => '#',
					'items' => [
						
				['label' => 'Course Information', 'visible' => $show, 'icon' => 'pencil', 'url' => ['/esiap/course/update', 'course' => $course_id]],
				
				['label' => 'Course Profile', 'visible' => $show, 'icon' => 'book', 'url' => ['/esiap/course/profile', 'course' => $course_id]],
				
				['label' => 'Course Learning Outcome', 'visible' => $show, 'icon' => 'book', 'url' => ['/esiap/course/course-clo', 'course' => $course_id]],
				
				['label' => 'CLO PLO', 'icon' => 'book', 'visible' => $show, 'url' => ['/esiap/course/clo-plo', 'course' => $course_id]],
				
				['label' => 'CLO Taxonomy', 'visible' => $show, 'icon' => 'book', 'url' => ['/esiap/course/clo-taxonomy', 'course' => $course_id]],
				
				['label' => 'CLO Softskill', 'visible' => $show, 'icon' => 'book', 'url' => ['/esiap/course/clo-softskill', 'course' => $course_id]],
				
				['label' => 'CLO Delivery', 'visible' => $show, 'icon' => 'book', 'url' => ['/esiap/course/clo-delivery', 'course' => $course_id]],
				
				['label' => 'Syllabus', 'visible' => $show, 'icon' => 'book', 'url' => ['/esiap/course/course-syllabus', 'course' => $course_id]],
				
				['label' => 'Assessment', 'visible' => $show, 'icon' => 'book', 'url' => ['/esiap/course/course-assessment', 'course' => $course_id]],
				
				['label' => 'CLO Assessment', 'visible' => $show, 'icon' => 'book', 'url' => ['/esiap/course/clo-assessment', 'course' => $course_id]],
				
				['label' => 'Student Learning Time', 'visible' => $show, 'icon' => 'book', 'url' => ['/esiap/course/course-slt', 'course' => $course_id]],
				
				
				['label' => 'References', 'visible' => $show, 'icon' => 'book', 'url' => ['/esiap/course/course-reference', 'course' => $course_id]],
				
				['label' => 'Preview & Submit', 'icon' => 'book', 'url' => ['/esiap/course/report', 'course' => $course_id]],

                 ]
                    ];
				break;
			}
		}
		
		return $course_focus;
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
				
				['label' => 'Program List', 'icon' => 'book', 'url' => ['/esiap/program-admin']],
				
				['label' => 'Course List', 'icon' => 'book', 'url' => ['/esiap/course-admin']],
				
				['label' => 'Inactive Courses', 'icon' => 'remove', 'url' => ['/esiap/course-admin/inactive']],
				

                 ]
                    ];	
		return $esiap_admin;
	}
	
	public static function adminTeachingLoad(){
		$esiap_admin = [
                        'label' => 'Teaching Admin',
                        'icon' => 'gears',
						'visible' => Yii::$app->user->can('teaching-load-manager'),
                        'url' => '#',
                        'items' => [
				
				['label' => 'Teaching By Staff', 'icon' => 'user', 'url' => ['/teaching-load/manager/by-staff']],
				
				['label' => 'Teaching By Course', 'icon' => 'book', 'url' => ['/teaching-load/manager/by-course']],
				
				['label' => 'Setting', 'icon' => 'cog', 'url' => ['/teaching-load/manager/setting']],

                 ]
                    ];	
		return $esiap_admin;
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
