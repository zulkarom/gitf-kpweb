<?php
namespace  backend\modules\admin\controllers;

use Yii;
use mdm\admin\controllers\AssignmentController as BaseAssignmentController;
use backend\modules\admin\models\AssignmentSearch;

class AssignmentController extends BaseAssignmentController
{
   public function actionIndex()
    {
		$searchModel = new AssignmentSearch;
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
			
		return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
	}
}
