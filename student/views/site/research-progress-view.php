<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $student backend\modules\postgrad\models\Student */
/* @var $stage backend\modules\postgrad\models\StudentStage */

$this->title = 'Research Stage Detail';
$this->params['breadcrumbs'][] = ['label' => 'Research Progress', 'url' => ['/site/research-progress']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-8">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Research Stage Detail</h3>
            </div>
            <div class="box-body" style="padding:0;">
                <table class="table table-bordered" style="margin-bottom:0;">
                    <tr>
                        <th style="width:240px;">Stage</th>
                        <td><?= Html::encode($stage->stage ? $stage->stage->stage_name : '-') ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?= Html::encode($stage->statusName ?: '-') ?></td>
                    </tr>
                    <tr>
                        <th>Semester</th>
                        <td><?= Html::encode($stage->semester ? $stage->semester->longFormat() : '-') ?></td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td><?= $stage->stage_date ? Html::encode(date('d M Y', strtotime($stage->stage_date))) : '-' ?></td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td><?= Html::encode($stage->stage_time ?: '-') ?></td>
                    </tr>
                    <tr>
                        <th>Thesis Title</th>
                        <td><?= Html::encode($stage->thesis_title ?: '-') ?></td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td><?= Html::encode($stage->location ?: '-') ?></td>
                    </tr>
                    <tr>
                        <th>Meeting Mode</th>
                        <td><?= Html::encode($stage->meeting_mode ?: '-') ?></td>
                    </tr>
                    <tr>
                        <th>Meeting Link</th>
                        <td>
                            <?php if ($stage->meeting_link) { ?>
                                <a href="<?= Html::encode($stage->meeting_link) ?>" target="_blank" rel="noopener noreferrer"><?= Html::encode($stage->meeting_link) ?></a>
                            <?php } else { ?>
                                -
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Remark</th>
                        <td><?= nl2br(Html::encode($stage->remark ?: '-')) ?></td>
                    </tr>
                </table>
            </div>
            <div class="box-footer">
                <a href="<?= Url::to(['/site/research-progress']) ?>" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
</div>
