<?php

namespace backend\modules\apprentice\controllers;

use yii\web\Controller;

/**
 * Default controller for the `apprentice` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(['/apprentice/apprentice/index']);
    }
}
