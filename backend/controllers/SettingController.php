<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\UploadedFile;

class SettingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionUploadTest()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!Yii::$app->request->isPost) {
            return [
                'ok' => false,
                'error' => 'POST a multipart/form-data request with field name "file"',
            ];
        }

        $file = UploadedFile::getInstanceByName('file');
        if (!$file) {
            return [
                'ok' => false,
                'error' => 'No file uploaded (expected field name: file)',
            ];
        }

        $directory = Yii::getAlias('@runtime/setting-upload-test/');
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        $token = bin2hex(random_bytes(8));
        $safeExt = preg_replace('/[^a-zA-Z0-9]/', '', (string)$file->extension);
        $fileName = 'upload-test-' . $token . ($safeExt ? '.' . strtolower($safeExt) : '');
        $path = $directory . $fileName;

        if (!$file->saveAs($path)) {
            return [
                'ok' => false,
                'error' => 'Failed to save file to runtime directory',
            ];
        }

        return [
            'ok' => true,
            'name' => $file->name,
            'size' => $file->size,
            'extension' => $file->extension,
            'saved_as' => $path,
        ];
    }

    public function actionFirewallUpload()
    {
        $uploadUrl = Url::to(['/firewall/index']);
        $csrfParam = Yii::$app->request->csrfParam;
        $csrfToken = Yii::$app->request->getCsrfToken();

        $html = '<div class="box">'
            . '<div class="box-header"><h3 class="box-title">Firewall Upload Test</h3></div>'
            . '<div class="box-body">'
            . '<div class="form-group"><label>Select file</label><input type="file" id="fw-test-file" class="form-control" /></div>'
            . '<div class="form-group"><label>request_type</label><input type="text" id="fw-test-request-type" class="form-control" value="postgrad_status_csv" /></div>'
            . '<div class="form-group"><button type="button" class="btn btn-primary" id="fw-test-upload-btn">Upload to /firewall/index</button></div>'
            . '<pre id="fw-test-result" style="white-space:pre-wrap; word-break:break-word; background:#f7f7f7; padding:10px;"></pre>'
            . '</div></div>';

        $js = <<<JS
(function(){
  var btn = $('#fw-test-upload-btn');
  var fileInput = $('#fw-test-file');
  var requestTypeInput = $('#fw-test-request-type');
  var out = $('#fw-test-result');

  function setOut(text){
    out.text(text);
  }

  btn.on('click', function(e){
    e.preventDefault();
    var file = fileInput[0] && fileInput[0].files ? fileInput[0].files[0] : null;
    if(!file){
      setOut('No file selected');
      return;
    }

    var fd = new FormData();
    fd.append('{$csrfParam}', '{$csrfToken}');
    fd.append('request_type', requestTypeInput.val() || 'postgrad_status_csv');
    fd.append('file', file);

    btn.prop('disabled', true);
    setOut('Uploading...');

    $.ajax({
      url: '{$uploadUrl}',
      type: 'POST',
      data: fd,
      processData: false,
      contentType: false,
      dataType: 'text'
    }).done(function(res){
      setOut(res);
    }).fail(function(xhr, textStatus, errorThrown){
      var detail = '';
      try { detail = (xhr && xhr.responseText) ? String(xhr.responseText) : ''; } catch(e) { detail = ''; }
      setOut('FAILED (' + (xhr ? xhr.status : '') + ') ' + textStatus + '\n' + detail);
    }).always(function(){
      btn.prop('disabled', false);
    });
  });
})();
JS;

        $this->view->registerJs($js);
        return $this->renderContent($html);
    }
}
