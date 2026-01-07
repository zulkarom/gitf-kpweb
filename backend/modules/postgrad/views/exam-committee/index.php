<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $semester_id integer|null */
/* @var $semesterList array */
/* @var $data array */
/* @var $tab string */

$this->title = 'Examination Committee';
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Admin', 'url' => ['//postgrad/student/stats']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="exam-committee-index">

    <div class="box">

        <div class="box-header with-border">
            <?php
                $currentTab = $tab ?? 'academic';
                $semesterIdParam = Yii::$app->request->get('semester_id');

                $tabBase = ['index'];
                if (!empty($semesterIdParam)) {
                    $tabBase['semester_id'] = $semesterIdParam;
                }
            ?>
            <ul class="nav nav-tabs">
                <li class="<?= $currentTab === 'academic' ? 'active' : '' ?>">
                    <a href="<?= Url::to(array_merge($tabBase, ['tab' => 'academic'])) ?>">FKP Staff</a>
                </li>
                <li class="<?= $currentTab === 'other' ? 'active' : '' ?>">
                    <a href="<?= Url::to(array_merge($tabBase, ['tab' => 'other'])) ?>">Other Faculty</a>
                </li>
                <li class="<?= $currentTab === 'external' ? 'active' : '' ?>">
                    <a href="<?= Url::to(array_merge($tabBase, ['tab' => 'external'])) ?>">External</a>
                </li>
                <li class="<?= $currentTab === 'transferred' ? 'active' : '' ?>">
                    <a href="<?= Url::to(array_merge($tabBase, ['tab' => 'transferred'])) ?>">Transferred/Quit</a>
                </li>
            </ul>
        </div>

        <div class="box-body">

            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => Url::to(['index']),
            ]); ?>

            <?= Html::hiddenInput('tab', $currentTab) ?>

            <div class="row">
                <div class="col-md-4">
                    <?= Html::dropDownList('semester_id', $semester_id, $semesterList, [
                        'class' => 'form-control',
                        'prompt' => 'Select Semester',
                        'onchange' => 'this.form.submit();',
                    ]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <br />

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Staff</th>
                        <th>Pengerusi</th>
                        <th>Penolong Pengerusi</th>
                        <th>Pemeriksa 1</th>
                        <th>Pemeriksa 2</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($data): $i = 1; foreach ($data as $row): ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $row['supervisor'] ? Html::encode($row['supervisor']->svName) : '-' ?></td>
                        <td><?= (int)$row['pengerusi'] ?></td>
                        <td><?= (int)$row['penolong'] ?></td>
                        <td><?= (int)$row['pemeriksa1'] ?></td>
                        <td><?= (int)$row['pemeriksa2'] ?></td>
                        <td>
                            <?php if ($row['supervisor']): ?>
                                <a href="<?= Url::to(['/postgrad/supervisor/view', 'id' => $row['supervisor']->id]) ?>" class="btn btn-warning btn-sm">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php $i++; endforeach; else: ?>
                    <tr><td colspan="6">No data for selected semester.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
