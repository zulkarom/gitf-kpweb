<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\models\JakimCrawl;
use common\models\Product;
use yii\db\Expression;

class SubscriberController extends Controller
{
	
	/**
	* Supply information to merchant webpage for single product
	* @param integer $ets
	*/
    public function actionIndex($ets)
    {
		$this->layout = "main-check-one";
        return $this->render('index');
    }
	
	/**
	* Supply information to merchant webpage for multiple product during checkout
	*/
	public function actionCheckout()
    {
		$this->layout = "main-check-checkout";
        return $this->render('checkout');
    }
	
	/**
	* Ajax process to supply information to merchant webpage for single product
	*/
	public function actionAjaxResultOne(){
		//sleep(1);
		$id = Yii::$app->request->get('ets');
		
		Product::updateExpiredDate($id);
		
		$model = Product::findOne($id);

		$this->layout = 'ajax';
		return $this->render('ajax_result_one', [
            'model' => $model
        ]);
	}
	
	/**
	* Ajax process to supply information to merchant 
	* webpage for multiple product during checkout
	*/
	public function actionAjaxResultCheckout(){
		
		
		//kena check dulu expired date
		
		
		$arr = Yii::$app->request->post('ets');
		
		if($arr){
			foreach($arr as $product){
				if($product){
					$model = Product::findOne($product);
					if($model){
						if(strtotime($model->expired_date) < time() ){
							Product::updateExpiredDate($product);
							
						}
					}
					
				}
			}
		}
		
		
		$query = Product::find()->where(['id' => $arr])->all();
		$this->layout = 'ajax';
		return $this->render('ajax_result_checkout', [
            'query' => $query,
			'arr' => $arr
        ]);
	}
	
	/**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
	protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
