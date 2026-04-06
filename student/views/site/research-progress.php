<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\postgrad\models\StudentStage;

/* @var $this yii\web\View */
/* @var $student backend\modules\postgrad\models\Student */
/* @var $stages backend\modules\postgrad\models\StudentStage[] */

$this->title = 'Research Progress';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Research Stage</h3>
    </div>
    <div class="box-body" style="padding:0;">
        <table class="table table-striped" style="margin-bottom:0;">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Stage</th>
                    <th>Status</th>
                    <th>Semester</th>
                    <th style="width:90px;"></th>
                </tr>
            </thead>
            <tbody>
            <?php if ($stages) { ?>
                <?php $i = 1; foreach ($stages as $stage) { ?>
                <tr>
                    <td><strong><?= $i ?></strong></td>
                    <td><?= Html::encode($stage->stage ? $stage->stage->stage_name : '-') ?></td>
                    <td><?= Html::encode(StudentStage::statusText($stage->status) ?: '-') ?></td>
                    <td><?= Html::encode($stage->semester ? $stage->semester->shortFormat() : '-') ?></td>
                    <td>
                        <a href="<?= Url::to(['/site/research-progress-view', 'id' => $stage->id]) ?>" class="btn btn-warning btn-sm" title="View">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php $i++; } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="5">No research progress records found.</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
