<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use backend\modules\sae\models\Batch;
use backend\modules\sae\models\Common;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Setting';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(); ?>
<div class="setting-index">
    <div class="card card-primary card-outline">
        <div class="card-body">

          <a href="file/offline.xls" target="_blank">Download Offline Excel Question</a>
          <br/><br/>

            <?= $form->field($model, 'setting_num')->dropDownList( [1 => 'Yes' , 0 => 'No'] )->label('Open Online Interview') ?>
            <div class="form-group">
                <?= Html::submitButton('Save Setting', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

</div>
<?php ActiveForm::end(); ?>

