<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentCsvUploadForm */

$this->title = 'Import Students (CSV)';
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Admin', 'url' => ['/postgrad/student/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="student-csv-import">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'file')->fileInput(['accept' => '.csv', 'id' => 'pg-student-csv-file']) ?>

            <?= Html::hiddenInput('csv_token', Yii::$app->request->post('csv_token', ''), ['id' => 'pg-student-csv-token']) ?>

            <div class="form-group">
                <?= Html::button('Upload CSV', ['class' => 'btn btn-default', 'id' => 'pg-student-upload-btn']) ?>
                <span id="pg-student-upload-msg" style="margin-left:10px"></span>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Preview', ['class' => 'btn btn-info', 'name' => 'preview', 'value' => '1']) ?>
                <?= Html::submitButton('Import New Students', ['class' => 'btn btn-danger', 'name' => 'apply', 'value' => '1', 'data-confirm' => 'Import new students from this CSV? Existing matric numbers will be skipped.']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <?php
                $uploadUrl = Url::to(['/firewall/index']);
                $uploadUrlJson = Json::encode($uploadUrl);
                $csrfParamJson = Json::encode(Yii::$app->request->csrfParam);
                $csrfTokenJson = Json::encode(Yii::$app->request->getCsrfToken());
                $this->registerJs(<<<JS
                (function(){
                    var uploadBtn = $('#pg-student-upload-btn');
                    var fileInput = $('#pg-student-csv-file');
                    var tokenInput = $('#pg-student-csv-token');
                    var msg = $('#pg-student-upload-msg');

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
                        fd.append('request_type', 'postgrad_student_csv');
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
                    Created: <?= (int)$summary['created'] ?><br />
                    Skipped (Exists): <?= (int)$summary['skipped_exists'] ?><br />
                    Skipped (Invalid): <?= (int)$summary['skipped_invalid'] ?><br />
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
                            <th>Matric No</th>
                            <th>Name</th>
                            <th>Email</th>
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
                                } elseif ($result === 'FAILED' || $result === 'INVALID') {
                                    $resultStyle = 'background:#f8d7da;';
                                } elseif ($result === 'CREATED') {
                                    $resultStyle = 'background:#d1e7dd;';
                                }
                            ?>
                            <tr data-result="<?= Html::encode($result) ?>">
                                <td><?= (int)$i ?></td>
                                <td><?= Html::encode((string)($row['matric_no'] ?? '')) ?></td>
                                <td><?= Html::encode((string)($row['name'] ?? '')) ?></td>
                                <td><?= Html::encode((string)($row['email'] ?? '')) ?></td>
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
