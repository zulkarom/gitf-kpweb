<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $activeCount integer */
/* @var $studyMode array */
/* @var $programLevel array */
/* @var $years array */
/* @var $byCountryRows array */
/* @var $countries array */
/* @var $byFieldRows array */
/* @var $fields array */

$this->title = 'Postgrad Statistics';
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="postgrad-stats">

    <p>
        <?= Html::a('Back to List', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?= (int)$activeCount ?></h3>
                    <p>Bilangan Aktif</p>
                </div>
                <div class="icon"><i class="fa fa-user"></i></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border"><h3 class="box-title">Taraf Pengajian</h3></div>
                <div class="box-body">
                    <p><strong>Sepenuh Masa:</strong> <?= (int)($studyMode[1] ?? 0) ?></p>
                    <p><strong>Separuh Masa:</strong> <?= (int)($studyMode[2] ?? 0) ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-info">
                <div class="box-header with-border"><h3 class="box-title">Program</h3></div>
                <div class="box-body">
                    <p><strong>Sarjana (Master):</strong> <?= (int)($programLevel['master'] ?? 0) ?></p>
                    <p><strong>Doktor Falsafah (PhD):</strong> <?= (int)($programLevel['phd'] ?? 0) ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-warning">
                <div class="box-header with-border"><h3 class="box-title">5 Tahun Kemasukan Terkini</h3></div>
                <div class="box-body">
                    <?php if ($years) { foreach ($years as $y) { ?>
                        <p><strong><?= Html::encode($y['admission_year']) ?>:</strong> <?= (int)$y['cnt'] ?></p>
                    <?php } } else { ?>
                        <p>Tiada data</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Senarai Pelajar Mengikut Negara</h3></div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Negara</th>
                                <th>Bilangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($byCountryRows as $r) {
                            $id = (int)($r['nationality'] ?? 0);
                            if (!$id) { continue; }
                            $name = isset($countries[$id]) ? $countries[$id]->country_name : ('ID ' . $id);
                        ?>
                            <tr>
                                <td><?= Html::encode($name) ?></td>
                                <td><?= (int)$r['cnt'] ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Senarai Pelajar Mengikut Bidang Pengajian</h3></div>
                <div class="box-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Bidang Pengajian</th>
                                <th>Bilangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($byFieldRows as $r) {
                            $id = (int)($r['field_id'] ?? 0);
                            if (!$id) { continue; }
                            $name = isset($fields[$id]) ? $fields[$id]->field_name : ('ID ' . $id);
                        ?>
                            <tr>
                                <td><?= Html::encode($name) ?></td>
                                <td><?= (int)$r['cnt'] ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
