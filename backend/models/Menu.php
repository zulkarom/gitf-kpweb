<?php

namespace backend\models;

use Yii;
use common\models\Todo;
use backend\modules\esiap\models\Course;

class Menu
{
	public static function coursePicXX(){
		$esiap_pic = [];
		
		$coor = Course::find()->where(['course_pic' => Yii::$app->user->identity->id])->all();
		
		if($coor){
			foreach($coor as $c){
				$ver = $c->defaultVersion->status;
				if($ver == 0){
					$rt = '/esiap/course/update';
				}else{
					$rt = '/esiap/course/report';
				}
				$arr[] = ['label' => $c->course_name, 'icon' => 'book', 'url' => [$rt, 'course' => $c->id]];
			}
			
			$menu_coor = [
                        'label' => 'My Course',
                        'icon' => 'book',
                        'url' => '#',
                        'items' => $arr,
                    ]
				;
				
			$esiap_pic  = $menu_coor;	
		}
		
		return $esiap_pic;
	}
	
	public static function courseFocus(){
		$course_focus = '';
		if(Yii::$app->controller->id == 'course' and Yii::$app->controller->module->id == 'esiap'){
			switch(Yii::$app->controller->action->id){
				case 'update': case 'profile':case 'course-clo':
				case 'course-syllabus':case 'course-assessment':
				case 'clo-assessment':case 'course-slt': case 'clo-plo':
				case 'clo-taxonomy':case 'clo-softskill': case 'course-reference':
				case 'clo-delivery':case 'report':
				$course_id = Yii::$app->getRequest()->getQueryParam('course');
				$course = Course::findOne($course_id);
				$course_focus  = [
                        'label' => $course->course_name,
                        'icon' => 'book',
						'format' => 'html',
                        'url' => '#',
                        'items' => [
						
				['label' => 'Course Information', 'icon' => 'pencil', 'url' => ['/esiap/course/update', 'course' => $course_id]],
				
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
				
				['label' => 'Report', 'icon' => 'book', 'url' => ['/esiap/course/report', 'course' => $course_id]],

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
                        'icon' => 'list-ul',
                        'url' => '#',
                        'items' => [
						
				//['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/erpd'],],
				
				['label' => 'Research', 'icon' => 'book', 'url' => ['/erpd/admin/research'],],
				
				['label' => 'Publication', 'icon' => 'send', 'url' => ['/erpd/admin/publication'],],
				
				
				
				['label' => 'Membership', 'icon' => 'users', 'url' => ['/erpd/admin/membership'],],
				
				['label' => 'Award', 'icon' => 'trophy', 'url' => ['/erpd/admin/award'],],
				
				['label' => 'Consultation', 'icon' => 'microphone', 'url' => ['/erpd/admin/consultation'],],
				
				['label' => 'Knowledge Transfer', 'icon' => 'truck', 'url' => ['/erpd/admin/knowledge-transfer'],],


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
						
				['label' => 'Summary', 'icon' => 'pie-chart', 'url' => ['/erpd'],],
				
				['label' => 'Research', 'icon' => 'book', 'url' => ['/erpd/research'],],
				
				['label' => 'Publication', 'icon' => 'send', 'url' => ['/erpd/publication'],],
				
				
				
				['label' => 'Membership', 'icon' => 'users', 'url' => ['/erpd/membership'],],
				
				['label' => 'Award', 'icon' => 'trophy', 'url' => ['/erpd/award'],],
				
				['label' => 'Consultation', 'icon' => 'microphone', 'url' => ['/erpd/consultation'],],
				
				['label' => 'Knowledge Transfer', 'icon' => 'truck', 'url' => ['/erpd/knowledge-transfer'],],


                 ]
                    ]
		
		;
	}
	
	public static function adminEsiap(){
		$esiap_admin = [
                        'label' => 'eSIAP Admin',
                        'icon' => 'list-ul',
						'visible' => Yii::$app->user->can('esiap-management'),
                        'url' => '#',
                        'items' => [
						
				//['label' => 'eSiap Dashboard', 'icon' => 'dashboard', 'url' => ['/esiap']],
				
				['label' => 'Program List', 'icon' => 'book', 'url' => ['/esiap/program']],
				
				['label' => 'Course List', 'icon' => 'book', 'url' => ['/esiap/course-admin']],
				

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
				
				['label' => 'Front Slider', 'icon' => 'pencil', 'url' => ['/website/front-slider']],
				
				['label' => 'Event List', 'icon' => 'list', 'url' => ['/website/event']],
				

                 ]
                    ];
		return $website;
	}
	
	public static function staff(){
		$staff = [
                        'label' => 'Staff Menu',
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
			
				['label' => 'Change Password', 'icon' => 'lock', 'url' => ['/user-setting/change-password'],],
				
			
				['label' => 'My Education', 'icon' => 'mortar-board', 'url' => ['/staff/profile/education'],],
				
				
				['label' => 'Log Out', 'icon' => 'arrow-left', 'url' => ['/site/logout'], 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>']


			],
		];
	}

}
