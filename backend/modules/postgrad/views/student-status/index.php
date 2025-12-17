<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\postgrad\models\Student;
use yii\helpers\Url;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentStatusUploadForm */

$this->title = 'Update Student Status';
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Admin', 'url' => ['/postgrad/student/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="student-status-update">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'file')->fileInput(['accept' => '.csv', 'id' => 'pg-status-csv-file']) ?>

            <?= Html::hiddenInput('csv_token', Yii::$app->request->post('csv_token', ''), ['id' => 'pg-status-csv-token']) ?>

            <div class="form-group">
                <?= Html::button('Upload CSV', ['class' => 'btn btn-default', 'id' => 'pg-status-upload-btn']) ?>
                <span id="pg-status-upload-msg" style="margin-left:10px"></span>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Preview', ['class' => 'btn btn-info', 'name' => 'preview', 'value' => '1']) ?>
                <?= Html::submitButton('Apply Updates', ['class' => 'btn btn-danger', 'name' => 'apply', 'value' => '1', 'data-confirm' => 'Apply updates from this CSV?']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <?php
                $uploadUrl = Url::to(['/firewall/index']);
                $uploadUrlJson = Json::encode($uploadUrl);
                $csrfParamJson = Json::encode(Yii::$app->request->csrfParam);
                $csrfTokenJson = Json::encode(Yii::$app->request->getCsrfToken());
                $this->registerJs(<<<JS
                (function(){
                    var uploadBtn = $('#pg-status-upload-btn');
                    var fileInput = $('#pg-status-csv-file');
                    var tokenInput = $('#pg-status-csv-token');
                    var msg = $('#pg-status-upload-msg');

                    function setMsg(text, isError){
                        msg.text(text);
                        msg.css('color', isError ? '#a94442' : '#3c763d');
                    }

                    uploadBtn.on('click', function(e){
                        e.preventDefault();

                        var file = fileInput[0] && fileInput[0].files ? fileInput[0].files[0] : null;
                        if(!file){
                            setMsg('Please choose a CSV file first', true);
                            return;
                        }

                        var fd = new FormData();
                        fd.append({$csrfParamJson}, {$csrfTokenJson});
                        fd.append('request_type', 'postgrad_status_csv');
                        fd.append('file', file);

                        uploadBtn.prop('disabled', true);
                        setMsg('Uploading...', false);

                        $.ajax({
                            url: {$uploadUrlJson},
                            type: 'POST',
                            data: fd,
                            processData: false,
                            contentType: false,
                            dataType: 'json'
                        }).done(function(res){
                            if(res && res.token){
                                tokenInput.val(res.token);
                                setMsg('Uploaded: ' + (res.name || 'CSV') , false);
                            }else if(res && res.error){
                                setMsg(res.error, true);
                            }else{
                                setMsg('Upload failed', true);
                            }
                        }).fail(function(xhr, textStatus, errorThrown){
                            var detail = '';
                            try {
                                detail = (xhr && xhr.responseText) ? String(xhr.responseText) : '';
                            } catch(e) {
                                detail = '';
                            }
                            console.log('Upload failed', {textStatus: textStatus, errorThrown: errorThrown, status: xhr ? xhr.status : null, responseText: detail});
                            if(detail){
                                setMsg('Upload failed (' + (xhr ? xhr.status : '') + '): ' + detail, true);
                            }else{
                                setMsg('Upload failed (' + (xhr ? xhr.status : '') + ')', true);
                            }
                        }).always(function(){
                            uploadBtn.prop('disabled', false);
                        });
                    });
                })();
JS);
            ?>

            <?php if (is_array($summary) && isset($summary['error'])): ?>
                <div class="alert alert-danger">
                    <?= Html::encode($summary['error']) ?>
                </div>
            <?php endif; ?>

            <?php if (is_array($summary) && !isset($summary['error'])): ?>
                <div class="alert alert-info">
                    <strong>Summary</strong><br />
                    Applied: <?= (int)$summary['applied'] ?><br />
                    Processed: <?= (int)$summary['processed'] ?><br />
                    Updated: <?= (int)$summary['updated'] ?><br />
                    Skipped: <?= (int)$summary['skipped'] ?><br />
                    Not Found: <?= (int)$summary['not_found'] ?><br />
                    Invalid Status: <?= (int)$summary['invalid_status'] ?><br />
                    Errors: <?= (int)$summary['errors'] ?><br />
                </div>

                <?php if (isset($summary['result_counts']) && is_array($summary['result_counts'])): ?>
                    <div class="alert alert-default">
                        <strong>Preview Summary (by Result)</strong><br />
                        <?php
                            $rc = $summary['result_counts'];
                            $keys = array_keys($rc);
                            sort($keys);
                        ?>
                        <div style="margin-top:8px">
                            <a href="#" class="btn btn-primary btn-xs js-filter" data-result="ALL">ALL (<?= (int)array_sum($rc) ?>)</a>
                            <?php foreach ($keys as $k): ?>
                                <a href="#" class="btn btn-warning btn-xs js-filter" data-result="<?= Html::encode($k) ?>"><?= Html::encode($k) ?> (<?= (int)$rc[$k] ?>)</a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (!empty($preview)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Student Id</th>
                            <th>Status Daftar (CURRENT)</th>
                            <th>Status Aktif (CURRENT)</th>
                            <th>Status Daftar (NEW)</th>
                            <th>Status Aktif (NEW)</th>
                            <th>Status Daftar (TO BE MAPPED)</th>
                            <th>Status Aktif (TO BE MAPPED)</th>
                            <th>Result</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($preview as $row): $i++; ?>
                            <?php
                                $mappedDaftarInt = $row['status_daftar'];
                                $mappedAktifInt = $row['status_aktif'];

                                $mappedDaftarDisp = is_bool($mappedDaftarInt) ? 'INVALID' : (string)$mappedDaftarInt;
                                if (!is_bool($mappedDaftarInt)) {
                                    if ($mappedDaftarInt === null || $mappedDaftarInt === '') {
                                        $mappedDaftarDisp = 'N/A';
                                    } else {
                                        $list = (new Student())->statusDaftarList();
                                        $txt = array_key_exists((int)$mappedDaftarInt, $list) ? $list[(int)$mappedDaftarInt] : '';
                                        $mappedDaftarDisp = trim($txt) !== '' ? ($txt . ' (' . (int)$mappedDaftarInt . ')') : (string)$mappedDaftarInt;
                                    }
                                }

                                $mappedAktifDisp = is_bool($mappedAktifInt) ? 'INVALID' : (string)$mappedAktifInt;
                                if (!is_bool($mappedAktifInt)) {
                                    if ($mappedAktifInt === null || $mappedAktifInt === '') {
                                        $mappedAktifDisp = 'N/A';
                                    } else {
                                        $list2 = (new Student())->statusAktifList();
                                        $txt2 = array_key_exists((int)$mappedAktifInt, $list2) ? $list2[(int)$mappedAktifInt] : '';
                                        $mappedAktifDisp = trim($txt2) !== '' ? ($txt2 . ' (' . (int)$mappedAktifInt . ')') : (string)$mappedAktifInt;
                                    }
                                }

                                $result = (string)$row['result'];
                                $resultStyle = '';
                                if ($result === 'READY') {
                                    $resultStyle = 'background:#fff3cd;';
                                } elseif ($result === 'NOT_FOUND') {
                                    $resultStyle = 'background:#f8d7da;';
                                }
                            ?>
                            <tr data-result="<?= Html::encode($result) ?>">
                                <td><?= (int)$i ?></td>
                                <td><?= Html::encode($row['student_id']) ?></td>
                                <td><?= Html::encode((string)($row['current_status_daftar_text'] ?? '')) ?></td>
                                <td><?= Html::encode((string)($row['current_status_aktif_text'] ?? '')) ?></td>
                                <td><?= Html::encode($row['status_daftar_text']) ?></td>
                                <td><?= Html::encode($row['status_aktif_text']) ?></td>
                                <td style="<?= !empty($row['daftar_changed']) ? 'background:#fff3cd;' : '' ?>"><?= Html::encode($mappedDaftarDisp) ?></td>
                                <td style="<?= !empty($row['aktif_changed']) ? 'background:#fff3cd;' : '' ?>"><?= Html::encode($mappedAktifDisp) ?></td>
                                <td style="<?= $resultStyle ?>"><?= Html::encode($result) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <script>
                (function(){
                    var links = document.querySelectorAll('.js-filter');
                    if(!links || !links.length){ return; }
                    var rows = document.querySelectorAll('tr[data-result]');
                    function applyFilter(val){
                        for(var i=0;i<rows.length;i++){
                            var r = rows[i];
                            if(val === 'ALL' || r.getAttribute('data-result') === val){
                                r.style.display = '';
                            } else {
                                r.style.display = 'none';
                            }
                        }
                    }
                    for(var j=0;j<links.length;j++){
                        links[j].addEventListener('click', function(e){
                            e.preventDefault();
                            applyFilter(this.getAttribute('data-result'));
                        });
                    }
                })();
                </script>
            <?php endif; ?>

        </div>
    </div>

</div>
