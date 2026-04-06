<?php

use yii\helpers\Html;
use backend\modules\postgrad\models\StudentRegister;

/* @var $this yii\web\View */
/* @var $student backend\modules\postgrad\models\Student */
/* @var $registrations backend\modules\postgrad\models\StudentRegister[] */
/* @var $latestRegistration backend\modules\postgrad\models\StudentRegister|null */

$this->title = 'Semester Registration';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Pendaftaran Semester</h3>
    </div>
    <div class="box-body" style="padding:0;">
        <table class="table table-bordered" style="margin-bottom:20px;">
            <tr>
                <th style="width:260px;">Tarikh Kemasukan</th>
                <td><?= $student->admission_date ? Html::encode(date('d F Y', strtotime($student->admission_date))) : '-' ?></td>
            </tr>
            <tr>
                <th>Sesi Masuk</th>
                <td><?= $student->admission_semester && $latestRegistration && $latestRegistration->semester ? Html::encode($latestRegistration->semester->longFormat()) : ($latestRegistration && $latestRegistration->semester ? Html::encode($latestRegistration->semester->longFormat()) : '-') ?></td>
            </tr>
            <tr>
                <th>Semester Semasa Pelajar</th>
                <td><?= Html::encode((string)($student->current_sem ?: '-')) ?></td>
            </tr>
        </table>

        <div style="padding: 0 15px 15px 15px;">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Senarai Rekod Pendaftaran Semester</th>
                        <th style="width:180px;">Status Daftar</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($registrations) { ?>
                    <?php $i = 1; foreach ($registrations as $registration) { ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td>
                            <?= $registration->semester ? Html::encode($registration->semester->longFormat()) : '-' ?>
                        </td>
                        <td><?= StudentRegister::statusDaftarLabel($registration->status_daftar) ?></td>
                    </tr>
                    <?php $i++; } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="3">No semester registration records found.</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
