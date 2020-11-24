<?php

namespace backend\modules\courseFiles\controllers;

use yii\web\Controller;

/**
 * Default controller for the `course-files` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
