<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $summary array */
/* @var $byCategory array */
/* @var $byType array */

$this->title = 'Grant Stats';
$this->params['breadcrumbs'][] = ['label' => 'Grants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$grantCount = isset($summary['grant_count']) ? (int) $summary['grant_count'] : 0;
$sumAmount = isset($summary['sum_amount']) ? (float) $summary['sum_amount'] : 0;
$extendedCount = isset($summary['extended_count']) ? (int) $summary['extended_count'] : 0;
?>

<div class="grant-stats">

    <p>
        <?= Html::a('Back to Grants', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <div class="box-header"><b>Total Grants</b></div>
                <div class="box-body">
                    <h3 style="margin:0"><?= $grantCount ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header"><b>Total Amount</b></div>
                <div class="box-body">
                    <h3 style="margin:0"><?= Yii::$app->formatter->asDecimal($sumAmount, 2) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header"><b>Extended Grants</b></div>
                <div class="box-body">
                    <h3 style="margin:0"><?= $extendedCount ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header"><b>By Category</b></div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th style="width:120px">Count</th>
                                    <th style="width:180px">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($byCategory as $row) { ?>
                                <tr>
                                    <td><?= Html::encode($row['category']) ?></td>
                                    <td><?= (int) $row['grant_count'] ?></td>
                                    <td><?= Yii::$app->formatter->asDecimal((float) $row['sum_amount'], 2) ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-header"><b>By Type</b></div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th style="width:120px">Count</th>
                                    <th style="width:180px">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($byType as $row) { ?>
                                <tr>
                                    <td><?= Html::encode($row['type']) ?></td>
                                    <td><?= (int) $row['grant_count'] ?></td>
                                    <td><?= Yii::$app->formatter->asDecimal((float) $row['sum_amount'], 2) ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
