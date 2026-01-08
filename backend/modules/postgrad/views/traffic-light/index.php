<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $models backend\modules\postgrad\models\PgSetting[] */

$this->title = 'Traffic Light';
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Admin', 'url' => ['//postgrad/student/stats']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="traffic-light-setting">

    <div class="box box-default">
        <div class="box-header with-border"><h3 class="box-title">Traffic Light Thresholds</h3></div>
        <div class="box-body">

            <?php $form = ActiveForm::begin(); ?>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width:220px;">Module</th>
                        <th style="width:120px;">Color</th>
                        <th style="width:160px;">From</th>
                        <th style="width:160px;">To</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($models as $i => $m) : ?>
                        <tr>
                            <td><?= Html::encode($m->module) ?></td>
                            <td><?= Html::encode($m->color) ?></td>
                            <td><?= $form->field($m, "[$i]min_value")->textInput()->label(false) ?></td>
                            <td><?= $form->field($m, "[$i]max_value")->textInput()->label(false) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
