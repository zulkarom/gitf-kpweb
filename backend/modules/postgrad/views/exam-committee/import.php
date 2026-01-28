<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Json;
use backend\modules\postgrad\models\StageExaminer;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\ExamCommitteeUploadForm */
/* @var $preview array|null */
/* @var $summary array|null */

$this->title = 'Import Examination Committee';
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Admin', 'url' => ['/postgrad/student/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="exam-committee-import">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">

            <div class="alert alert-default">
                <strong>CSV Format</strong><br />
                Required headers:<br />
                <strong>date</strong>, <strong>time</strong>, <strong>student_id</strong>, <strong>stage_id</strong>, <strong>chairman</strong>, <strong>deputy_chairman</strong>, <strong>panel1</strong>, <strong>panel2</strong>, <strong>thesis_title</strong>
            </div>

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'file')->fileInput(['accept' => '.csv', 'id' => 'pg-exam-committee-csv-file'])->label('Upload CSV File') ?>

            <?= Html::hiddenInput('csv_token', Yii::$app->request->post('csv_token', ''), ['id' => 'pg-exam-committee-csv-token']) ?>

            <?= Html::hiddenInput('apply_intent', '0', ['id' => 'pg-exam-committee-apply-intent']) ?>

            <div class="form-group">
                <?= Html::button('Upload CSV', ['class' => 'btn btn-default', 'id' => 'pg-exam-committee-upload-btn', 'style' => 'display:none']) ?>
                <span id="pg-exam-committee-upload-msg" style="margin-left:10px"></span>
            </div>

            <div class="form-group">
                <?php if (is_array($summary) && !isset($summary['error']) && (int)($summary['applied'] ?? 0) === 0): ?>
                    <?= Html::submitButton('Apply Updates', ['class' => 'btn btn-danger', 'name' => 'apply', 'value' => '1', 'data-confirm' => 'Apply examination committee updates from this CSV?']) ?>
                <?php endif; ?>
            </div>

            <?php ActiveForm::end(); ?>

            <?php
                $uploadUrl = Url::to(['/firewall/index']);
                $uploadUrlJson = Json::encode($uploadUrl);
                $csrfParamJson = Json::encode(Yii::$app->request->csrfParam);
                $csrfTokenJson = Json::encode(Yii::$app->request->getCsrfToken());
                $this->registerJs(<<<JS
                (function(){
                    var uploadBtn = $('#pg-exam-committee-upload-btn');
                    var fileInput = $('#pg-exam-committee-csv-file');
                    var tokenInput = $('#pg-exam-committee-csv-token');
                    var applyIntent = $('#pg-exam-committee-apply-intent');
                    var msg = $('#pg-exam-committee-upload-msg');
                    var form = fileInput.closest('form');
                    var applyBtn = form.find('button[name="apply"], input[name="apply"]');

                    var isUploading = false;

                    function setMsg(text, isError){
                        msg.text(text);
                        msg.css('color', isError ? '#a94442' : '#3c763d');
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
                        fd.append('request_type', 'postgrad_exam_committee_csv');
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
                            try {
                                fileInput.val('');
                            } catch(e) {
                                // ignore
                            }
                        });
                    }

                    uploadBtn.on('click', function(e){
                        e.preventDefault();

                        uploadCsv();
                    });

                    fileInput.on('mousedown', function(){
                        tokenInput.val('');
                        if(applyIntent.length){ applyIntent.val('0'); }
                        try {
                            this.value = '';
                        } catch(e) {}
                    });

                    fileInput.on('click', function(){
                        tokenInput.val('');
                        if(applyIntent.length){ applyIntent.val('0'); }
                        try {
                            this.value = '';
                        } catch(e) {}
                    });

                    fileInput.on('change', function(){
                        tokenInput.val('');
                        if(applyIntent.length){ applyIntent.val('0'); }
                        uploadCsv(function(){
                            form.find('input[name="preview"]').remove();
                            form.append('<input type="hidden" name="preview" value="1" />');
                            form.trigger('submit');
                        });
                    });

                    applyBtn.on('click', function(e){
                        if(applyIntent.length){ applyIntent.val('1'); }
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
                    Created: <?= (int)$summary['created'] ?><br />
                    Updated: <?= (int)$summary['updated'] ?><br />
                    Skipped: <?= (int)$summary['skipped'] ?><br />
                    Not Found: <?= (int)$summary['not_found'] ?><br />
                    Semester Not Found: <?= (int)($summary['semester_not_found'] ?? 0) ?><br />
                    Invalid: <?= (int)$summary['invalid'] ?><br />
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
                    <table class="table table-bordered table-striped" id="pg-exam-committee-preview-table">
                        <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Student</th>
                            <th>Semester</th>
                            <th>Stage</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Thesis Title</th>
                            <th>Chairman</th>
                            <th>Deputy</th>
                            <th>Examiner 1</th>
                            <th>Examiner 2</th>
                            <th>Result</th>
                            <th>Message</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($preview as $row): $i++; ?>
                            <?php
                                $result = (string)($row['result'] ?? '');
                                $resultStyle = '';
                                if ($result === 'READY') {
                                    $resultStyle = 'background:#fff3cd;';
                                } elseif ($result === 'FAILED' || $result === 'INVALID' || $result === 'SEMESTER_NOT_FOUND' || $result === 'STAFF_NOT_FOUND' || $result === 'REG_NOT_FOUND') {
                                    $resultStyle = 'background:#f8d7da;';
                                } elseif ($result === 'UPDATED' || $result === 'CREATED') {
                                    $resultStyle = 'background:#d1e7dd;';
                                }

                                $staffNos = isset($row['staff_no']) && is_array($row['staff_no']) ? $row['staff_no'] : [];
                                $missing = isset($row['missing']) && is_array($row['missing']) ? $row['missing'] : [];
                                $cellStatus = isset($row['cell_status']) && is_array($row['cell_status']) ? $row['cell_status'] : [];

                                $dateDisplay = (string)($row['date'] ?? '');
                                if (!empty($cellStatus['date'])) {
                                    $dateDisplay .= ' [' . (string)$cellStatus['date'] . ']';
                                }

                                $timeDisplay = (string)($row['time'] ?? '');
                                if (!empty($cellStatus['time'])) {
                                    $timeDisplay .= ' [' . (string)$cellStatus['time'] . ']';
                                }

                                $titleDisplay = (string)($row['thesis_title'] ?? '');
                                if (!empty($cellStatus['thesis_title'])) {
                                    $titleDisplay .= ' [' . (string)$cellStatus['thesis_title'] . ']';
                                }

                                $chairmanDisplay = (string)($row['chairman'] ?? '');
                                if (!empty($staffNos[1])) {
                                    $chairmanDisplay = trim((string)$staffNos[1]) . ' ' . $chairmanDisplay;
                                } elseif (isset($missing[1])) {
                                    $chairmanDisplay .= ' [ERROR: ' . (string)$missing[1] . ']';
                                }
                                if (!empty($cellStatus['chairman'])) {
                                    $chairmanDisplay .= ' [' . (string)$cellStatus['chairman'] . ']';
                                }

                                $deputyDisplay = (string)($row['deputy_chairman'] ?? '');
                                if (!empty($staffNos[2])) {
                                    $deputyDisplay = trim((string)$staffNos[2]) . ' ' . $deputyDisplay;
                                } elseif (isset($missing[2])) {
                                    $deputyDisplay .= ' [ERROR: ' . (string)$missing[2] . ']';
                                }
                                if (!empty($cellStatus['deputy'])) {
                                    $deputyDisplay .= ' [' . (string)$cellStatus['deputy'] . ']';
                                }

                                $panel1Display = (string)($row['panel1'] ?? '');
                                if (!empty($staffNos[3])) {
                                    $panel1Display = trim((string)$staffNos[3]) . ' ' . $panel1Display;
                                } elseif (isset($missing[3])) {
                                    $panel1Display .= ' [ERROR: ' . (string)$missing[3] . ']';
                                }
                                if (!empty($cellStatus['examiner1'])) {
                                    $panel1Display .= ' [' . (string)$cellStatus['examiner1'] . ']';
                                }

                                $panel2Display = (string)($row['panel2'] ?? '');
                                if (!empty($staffNos[4])) {
                                    $panel2Display = trim((string)$staffNos[4]) . ' ' . $panel2Display;
                                } elseif (isset($missing[4])) {
                                    $panel2Display .= ' [ERROR: ' . (string)$missing[4] . ']';
                                }
                                if (!empty($cellStatus['examiner2'])) {
                                    $panel2Display .= ' [' . (string)$cellStatus['examiner2'] . ']';
                                }
                            ?>
                            <tr data-result="<?= Html::encode($result) ?>">
                                <td><?= (int)$i ?></td>
                                <td><?= Html::encode((string)($row['student_id'] ?? '')) ?></td>
                                <td><?= Html::encode((string)($row['semester_id'] ?? '')) ?></td>
                                <td><?= Html::encode((string)($row['stage_id'] ?? '')) ?></td>
                                <td><?= Html::encode($dateDisplay) ?></td>
                                <td><?= Html::encode($timeDisplay) ?></td>
                                <td><?= Html::encode($titleDisplay) ?></td>
                                <td><?= Html::encode($chairmanDisplay) ?></td>
                                <td><?= Html::encode($deputyDisplay) ?></td>
                                <td><?= Html::encode($panel1Display) ?></td>
                                <td><?= Html::encode($panel2Display) ?></td>
                                <td style="<?= $resultStyle ?>"><?= Html::encode($result) ?></td>
                                <td><?= Html::encode((string)($row['message'] ?? '')) ?></td>
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
