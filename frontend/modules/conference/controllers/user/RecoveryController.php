<?php
namespace frontend\modules\conference\controllers\user;

use dektrium\user\controllers\RecoveryController as BaseRecoveryController;

class RecoveryController extends BaseRecoveryController
{
    
    public function actionRequest($url='')
    {
		$this->layout = "//main-register";
        return parent::actionRequest();
    }

    public function actionReset($id, $code)
    {
		$this->layout = "//main-recover";
        return parent::actionReset($id, $code);
    }
}
