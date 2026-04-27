<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\postgrad\models\StudentRegister;
use backend\modules\postgrad\models\StudentStage;

/* @var $student backend\modules\postgrad\models\Student */

$params = ['/postgrad/student/view', 'id' => $student->id];
if (!empty($semesterId)) {
    $params['semester_id'] = $semesterId;
}

?>

<div>
    <div style="margin-bottom:10px;">
        <?= Html::a('Go To Student Page', $params, ['class' => 'btn btn-primary', 'target' => '_blank', 'rel' => 'noopener noreferrer']) ?>
    </div>

    <div class="row">
        <div class="col-md-12">
            <strong>Title (Active)</strong><br />
            <?= Html::encode($activeTitle ? (string)$activeTitle->thesis_title : '') ?>
        </div>
    </div>

    <hr />

    <div class="row">
        <div class="col-md-12">
            <strong>Research Stage</strong>
            <table class="table table-bordered table-condensed" style="margin-top:8px;">
                <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Stage</th>
                    <th>Status</th>
                    <th>Semester</th>
                    <th>Result</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($stages)): $i = 1; foreach ($stages as $st): ?>
                    <tr>
                        <td><?= (int)$i ?></td>
                        <td><?= Html::encode($st->stage ? (string)$st->stage->stage_abbr : '') ?></td>
                        <td><?= Html::encode($st->status === null ? '' : (string)$st->status) ?></td>
                        <td><?= Html::encode($st->semester ? (string)$st->semester->shortFormat() : '') ?></td>
                        <td><?= Html::encode((string)StudentStage::statusText($st->status)) ?></td>
                    </tr>
                <?php $i++; endforeach; else: ?>
                    <tr><td colspan="5"></td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <hr />

    <div class="row">
        <div class="col-md-12">
            <strong>Active Supervisor</strong>
            <table class="table table-bordered table-condensed" style="margin-top:8px;">
                <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Name</th>
                    <th>Role</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($activeSupervisors)): $i = 1; foreach ($activeSupervisors as $sv): ?>
                    <tr>
                        <td><?= (int)$i ?></td>
                        <td><?= Html::encode($sv->supervisor ? (string)$sv->supervisor->svName : '') ?></td>
                        <td><?= Html::encode((string)$sv->roleName()) ?></td>
                    </tr>
                <?php $i++; endforeach; else: ?>
                    <tr><td colspan="3"></td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <hr />

    <div class="row">
        <div class="col-md-12">
            <strong>Semester Registration</strong>
            <table class="table table-bordered table-condensed" style="margin-top:8px;">
                <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Semester</th>
                    <th>Status Daftar</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($registrations)): $i = 1; foreach ($registrations as $reg): ?>
                    <tr>
                        <td><?= (int)$i ?></td>
                        <td><?= Html::encode($reg->semester ? (string)$reg->semester->shortFormat() : '') ?></td>
                        <td><?= StudentRegister::statusDaftarLabel($reg->status_daftar) ?></td>
                    </tr>
                <?php $i++; endforeach; else: ?>
                    <tr><td colspan="3"></td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
