<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use backend\modules\website\models\Event;
use backend\modules\website\models\FrontSlider;
use common\models\Upload;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
           
        ];
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		$upcoming = Event::upcomingEvent();
		$news = Event::latestNews();
		$slides = FrontSlider::find()->where(['is_publish' => 1])->orderBy('slide_order DESC')->all();
		
		return $this->render('index', [
			'upcoming' => $upcoming,
			'news' => $news,
			'slides' => $slides
		]);
        
    }
	
	public function actionContact()
    {
		return $this->render('contact');
        
    }
	
	public function actionDisclaimer()
    {
		return $this->render('disclaimer');
        
    }
	
	public function actionPrivacy()
    {
		return $this->render('privacy');
        
    }
	

	
	
}
