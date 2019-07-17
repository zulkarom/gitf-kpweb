<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\ProductSearch;
use common\models\ProductJakimForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\JakimCrawl;
use yii\filters\AccessControl;
use yii\db\Expression;


/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
			'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	/**
	* Search product from JAKIM directory
	*/
	public function actionSearchJakim(){
		 
		$model = new ProductJakimForm;
		$crawl = new JakimCrawl;
		$cat = array();
		$details = array();
		$page = array();
		$hasil = false;
		$conn = -1;
		 
		if(Yii::$app->request->get('ty')){
			$page = Yii::$app->request->get('page');
			$counter = Yii::$app->request->get('hdnCounter');
			$hasil = true;
			$crawl->ty = Yii::$app->request->get('ty');
			$cari = Yii::$app->request->get('cari');
			$crawl->cari = $cari;$model->cari = $cari;
			$crawl->page = $page;
			$crawl->counter = $counter;
			//$model->test = $crawl->test;
			$result = $crawl->getJakimResult();
			$model->cat_title = $crawl->cat_title;
			$cat = $result[0];
			$details = $result[1];
			$page = $result[2];
			$conn = $result[3];
		}
		
		if($model->load(Yii::$app->request->post())){
			$hasil = true;
			$crawl->cari = $model->cari;
			//$model->test = $crawl->test;
			$result = $crawl->getJakimResult();
			$model->cat_title = $crawl->cat_title;
			$cat = $result[0];
			$details = $result[1];
			$page = $result[2];
			$conn = $result[3];
        }
		
		return $this->render('search_form', 
			[
			'model' => $model, 
			'cat' => $cat,
			'details' => $details,
			'page' => $page,
			'hasil' => $hasil,
			'conn' => $conn
			]
		);
		
	}
	
    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

	
	/**
	* Update product using JAKIM information 
	*/
	public function actionUpdateJakim($id)
    {
		Product::updateExpiredDate($id, true);
		$model = $this->findModel($id);

		return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
	
	/** 
	* Add new product to database
	* using JAKIM information 
	*/
	public function actionAddProductJakim(){
		
		if(Yii::$app->request->get('product_name')){
			$get =  Yii::$app->request->get();
			
			$product = Product::find()
			->where([
			'product_name' => $get['product_name'], 
			'company' => $get['company']
			])
			->one();
			
			if(!$product){
				$product = new Product();
				$product->product_name = $get['product_name'];
				$product->company = $get['company'];
				$product->company_id = $get['company_id'];
				$product->product_type = $get['ty'];
			}
			
			$product->expired_date = $get['expired_date'];
			$product->last_update = new Expression('NOW()');
			
			if($product->save()){
				return $this->redirect(['view', 'id' => $product->id]);
			}else{
				$product->setFlashErrors();
			}
		}else{
			Yii::$app->session->addFlash('error', 'No Data Supplied!');
		}
		


		return $this->render('add_product_jakim', [
        ]);
	}
	
	
}
