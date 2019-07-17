<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use backend\modules\website\models\Event;


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
		
		return $this->render('index', [
			'upcoming' => $upcoming,
			'news' => $news
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
