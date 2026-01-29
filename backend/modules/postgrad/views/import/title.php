<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\ThesisTitleCsvUploadForm */
/* @var $preview array|null */
/* @var $summary array|null */

$this->title = 'Import Thesis Title (CSV)';
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Admin', 'url' => ['/postgrad/student/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="thesis-title-import">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">

            <div class="alert alert-default">
                <strong>CSV Format</strong><br />
                Required headers: <strong>TAJUK PENYELIDIKAN</strong> (or <strong>title</strong>)
            </div>

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'file')->fileInput(['accept' => '.csv', 'id' => 'pg-thesis-title-csv-file'])->label('Upload CSV File Thesis Title') ?>

            <?= Html::hiddenInput('csv_token', Yii::$app->request->post('csv_token', ''), ['id' => 'pg-thesis-title-csv-token']) ?>

            <?= Html::hiddenInput('apply_intent', '0', ['id' => 'pg-thesis-title-apply-intent']) ?>

            <div class="form-group">
                <?= Html::button('Upload CSV', ['class' => 'btn btn-default', 'id' => 'pg-thesis-title-upload-btn', 'style' => 'display:none']) ?>
                <span id="pg-thesis-title-upload-msg" style="margin-left:10px"></span>
            </div>

            <div class="form-group">
                <?php if (is_array($summary) && !isset($summary['error']) && (int)($summary['applied'] ?? 0) === 0): ?>
                    <?= Html::submitButton('Apply Updates', ['class' => 'btn btn-danger', 'name' => 'apply', 'value' => '1', 'data-confirm' => 'Insert missing thesis titles from this CSV?']) ?>
                <?php endif; ?>
            </div>

            <?php
                $uploadUrl = Url::to(['/firewall/index']);
                $uploadUrlJson = Json::encode($uploadUrl);
                $csrfParamJson = Json::encode(Yii::$app->request->csrfParam);
                $csrfTokenJson = Json::encode(Yii::$app->request->getCsrfToken());
                $this->registerJs(<<<JS
                (function(){
                    var uploadBtn = $('#pg-thesis-title-upload-btn');
                    var fileInput = $('#pg-thesis-title-csv-file');
                    var tokenInput = $('#pg-thesis-title-csv-token');
                    var applyIntent = $('#pg-thesis-title-apply-intent');
                    var msg = $('#pg-thesis-title-upload-msg');
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
                        fd.append('request_type', 'postgrad_thesis_title_csv');
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
                    Inserted: <?= (int)($summary['inserted'] ?? 0) ?><br />
                    Exists: <?= (int)($summary['exists'] ?? 0) ?><br />
                    Invalid: <?= (int)($summary['invalid'] ?? 0) ?><br />
                    Errors: <?= (int)$summary['errors'] ?><br />
                </div>
            <?php endif; ?>

            <?php if (is_array($preview) && !empty($preview)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th style="width:80px">Row</th>
                            <th>Title</th>
                            <th style="width:120px">Result</th>
                            <th>Message</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($preview as $p): ?>
                            <tr>
                                <td><?= Html::encode($p['row'] ?? '') ?></td>
                                <td><?= Html::encode($p['title'] ?? '') ?></td>
                                <td><?= Html::encode($p['result'] ?? '') ?></td>
                                <td><?= Html::encode($p['message'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
