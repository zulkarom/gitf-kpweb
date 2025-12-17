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
            . '<div class="box-header"><h3 class="box-title">Firewall Upload Test (Simple Form)</h3></div>'
            . '<div class="box-body">'
            . '<form method="post" enctype="multipart/form-data" action="' . htmlspecialchars($uploadUrl, ENT_QUOTES, 'UTF-8') . '">' 
            . '<input type="hidden" name="' . htmlspecialchars($csrfParam, ENT_QUOTES, 'UTF-8') . '" value="' . htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') . '">'
            . '<input type="hidden" name="request_type" value="upload">'
            . '<input type="hidden" name="mode" value="test">'
            . '<div class="form-group"><label>Select file</label><input type="file" name="file" class="form-control" /></div>'
            . '<div class="form-group"><button type="submit" class="btn btn-primary">Upload (via /firewall/index)</button></div>'
            . '</form>'
            . '<div class="help-block">This posts to <code>/firewall/index</code> with <code>request_type=upload</code> and <code>mode=test</code>. The file is saved into <code>@upload/test/&lt;username&gt;/</code>.</div>'
            . '</div></div>';

        return $this->renderContent($html);
    }
}
