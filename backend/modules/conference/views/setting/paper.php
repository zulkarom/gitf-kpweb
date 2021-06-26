<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\Conference */

$this->title = 'RESET PAPER';
$this->params['breadcrumbs'][] = ['label' => 'Conferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="conference-update">


<?php $form = ActiveForm::begin(); ?>

<?=$form->field($model, 'updated_at')->hiddenInput(['value' => 1])->label(false)?>
<div class="form-group">
        
<?= Html::submitButton('RESET PAPER ID', ['class' => 'btn btn-danger', 'data' => [
    'confirm' => 'This will change the current paper ids, with oldest be the earliest paper?'
],
]) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
