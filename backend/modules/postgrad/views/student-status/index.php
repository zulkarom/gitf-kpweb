<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentRegister;
use backend\models\Semester;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

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

            <div class="alert alert-default">
                <strong>Panduan Muat Naik (CSV)</strong><br />
                1) Pilih <strong>Semester</strong>.<br />
                2) Sediakan fail <strong>.csv</strong> (maksimum 10MB) dan baris pertama mestilah <strong>header</strong>.<br />
                3) Kolum wajib: <strong>student_id</strong> (atau <strong>student id</strong>), <strong>status_daftar</strong>.<br />
                3a) Kolum <strong>student_name</strong> (jika ada) akan <strong>diabaikan</strong> semasa muat naik.<br />
                4) <strong>Status Aktif</strong> akan ditetapkan secara automatik: <strong>Daftar / NOS</strong> = Aktif, selain itu = Tidak Aktif.<br />
                5) Pastikan tiada <strong>student_id</strong> berulang dalam CSV.<br />
                6) Pilih fail CSV. Sistem akan <strong>muat naik secara automatik</strong> dan papar <strong>preview</strong>.
                7) Semak keputusan preview (contoh: READY / NOT_FOUND / INVALID_STATUS / NO_CHANGES).<br />
                8) Jika betul, klik <strong>Apply Updates</strong> untuk kemaskini.
            </div>

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?php
                $semesterOptions = ArrayHelper::map(
                    Semester::find()->orderBy(['id' => SORT_DESC])->all(),
                    'id',
                    function($s){ return $s->longFormat(); }
                );
            ?>

            <?= $form->field($model, 'semester_id')->dropDownList($semesterOptions, ['prompt' => 'Choose']) ?>

            <?= $form->field($model, 'file')->fileInput(['accept' => '.csv', 'id' => 'pg-status-csv-file']) ?>

            <div class="form-group">
                <?= Html::button('Download Current CSV', ['class' => 'btn btn-primary', 'id' => 'pg-status-download-btn']) ?>
                <span id="pg-status-download-msg" style="margin-left:10px"></span>
            </div>

            <?= Html::hiddenInput('csv_token', Yii::$app->request->post('csv_token', ''), ['id' => 'pg-status-csv-token']) ?>

            <div class="form-group">
                <?= Html::button('Upload CSV', ['class' => 'btn btn-default', 'id' => 'pg-status-upload-btn', 'style' => 'display:none']) ?>
                <span id="pg-status-upload-msg" style="margin-left:10px"></span>
            </div>

            <div class="form-group">
                <?php if (is_array($summary) && !isset($summary['error']) && (int)($summary['applied'] ?? 0) === 0): ?>
                    <?= Html::submitButton('Apply Updates', ['class' => 'btn btn-danger', 'name' => 'apply', 'value' => '1', 'data-confirm' => 'Apply updates from this CSV?']) ?>
                <?php endif; ?>
            </div>

            <?php ActiveForm::end(); ?>

            <?php
                $uploadUrl = Url::to(['/firewall/index']);
                $uploadUrlJson = Json::encode($uploadUrl);
                $csrfParamJson = Json::encode(Yii::$app->request->csrfParam);
                $csrfTokenJson = Json::encode(Yii::$app->request->getCsrfToken());
                $downloadUrlBase = Url::to(['/postgrad/student-status/download-csv']);
                $downloadUrlBaseJson = Json::encode($downloadUrlBase);
                $this->registerJs(<<<JS
                (function(){
                    var uploadBtn = $('#pg-status-upload-btn');
                    var fileInput = $('#pg-status-csv-file');
                    var tokenInput = $('#pg-status-csv-token');
                    var msg = $('#pg-status-upload-msg');
                    var form = fileInput.closest('form');
                    var applyBtn = form.find('button[name="apply"], input[name="apply"]');

                    var downloadBtn = $('#pg-status-download-btn');
                    var downloadMsg = $('#pg-status-download-msg');
                    var semesterSelect = $('#studentstatusuploadform-semester_id');

                    var isUploading = false;

                    function setMsg(text, isError){
                        msg.text(text);
                        msg.css('color', isError ? '#a94442' : '#3c763d');
                    }

                    function setDownloadMsg(text, isError){
                        downloadMsg.text(text);
                        downloadMsg.css('color', isError ? '#a94442' : '#3c763d');
                    }

                    function uploadCsv(done){
                        if(isUploading){
                            return;
                        }

                        var file = fileInput[0] && fileInput[0].files ? fileInput[0].files[0] : null;
                        if(!file){
                            setMsg('Please choose a CSV file first', true);
                            return;
                        }

                        var fd = new FormData();
                        fd.append({$csrfParamJson}, {$csrfTokenJson});
                        fd.append('request_type', 'postgrad_status_csv');
                        fd.append('file', file);

                        isUploading = true;
                        if(uploadBtn.length){ uploadBtn.prop('disabled', true); }
                        if(applyBtn.length){ applyBtn.prop('disabled', true); }
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
                                if(typeof done === 'function'){
                                    done(res);
                                }
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
                            isUploading = false;
                            if(uploadBtn.length){ uploadBtn.prop('disabled', false); }
                            if(applyBtn.length){ applyBtn.prop('disabled', false); }
                        });
                    }

                    uploadBtn.on('click', function(e){
                        e.preventDefault();

                        uploadCsv();
                    });

                    fileInput.on('change', function(){
                        tokenInput.val('');
                        uploadCsv(function(){
                            form.find('input[name="preview"]').remove();
                            form.append('<input type="hidden" name="preview" value="1" />');
                            form.trigger('submit');
                        });
                    });

                    applyBtn.on('click', function(e){
                        if($.trim(tokenInput.val() || '') !== ''){
                            return;
                        }

                        var file = fileInput[0] && fileInput[0].files ? fileInput[0].files[0] : null;
                        if(!file){
                            return;
                        }

                        e.preventDefault();
                        uploadCsv(function(){
                            form.trigger('submit');
                        });
                    });

                    downloadBtn.on('click', function(e){
                        e.preventDefault();
                        setDownloadMsg('', false);

                        var semesterId = $.trim(semesterSelect.val() || '');
                        if(semesterId === ''){
                            setDownloadMsg('Sila pilih Semester dahulu', true);
                            return;
                        }

                        var base = {$downloadUrlBaseJson};
                        var url = base + (base.indexOf('?') >= 0 ? '&' : '?') + 'semester_id=' + encodeURIComponent(semesterId);
                        window.location.href = url;
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
                            <th>Status Aktif (AUTO)</th>
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
                                        $list = StudentRegister::statusDaftarList();
                                        $txt = array_key_exists((int)$mappedDaftarInt, $list) ? $list[(int)$mappedDaftarInt] : '';
                                        $mappedDaftarDisp = trim($txt) !== '' ? ($txt . ' (' . (int)$mappedDaftarInt . ')') : (string)$mappedDaftarInt;
                                    }
                                }

                                $mappedAktifDisp = is_bool($mappedAktifInt) ? 'INVALID' : (string)$mappedAktifInt;
                                if (!is_bool($mappedAktifInt)) {
                                    if ($mappedAktifInt === null || $mappedAktifInt === '') {
                                        $mappedAktifDisp = 'N/A';
                                    } else {
                                        $list2 = StudentRegister::statusAktifList();
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
