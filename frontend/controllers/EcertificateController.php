<?php
namespace frontend\controllers;

use backend\modules\downloads\models\UploadFile;
use backend\modules\ecert\models\Document;
use frontend\models\DownloadFormExternal;
use frontend\models\EcertificateForm;
use Yii;
use yii\web\Controller;

/**
 * ProceedingController implements the CRUD actions for Proceeding model.
 */
class EcertificateController extends Controller
{

    public function actionIndex()
    {
        $model = new EcertificateForm();

        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionResult()
    {
        $model = new EcertificateForm();
        if ($model->load(Yii::$app->request->post())) {

            $docs = Document::find()->alias('a')
                ->select('a.*, t.type_name')
                ->joinWith([
                'eventType t'
            ])
                ->where([
                'a.identifier' => $model->identifier,
                't.event_id' => $model->event,
                't.published' => 1
            ])
                ->all();

            return $this->render('result', [
                'docs' => $docs,
                'model' => $model
            ]);
        }
    }

    public function actionExternal()
    {
        $model = new DownloadFormExternal();
        if ($model->load(Yii::$app->request->post())) {

            $student = $this->findDownload($model->category, $model->nric);
            if ($student) {
                if (! UploadFile::downloadCategory($student)) {
                    Yii::$app->session->addFlash('error', "File not found!");
                    // return $this->refresh();
                }
            } else {
                Yii::$app->session->addFlash('error', "No document found for this NRIC under the selected category!");
                // return $this->refresh();
            }
        }

        return $this->render('external', [
            'model' => $model
        ]);
    }

    protected function findEcertificate($type, $identifier)
    {
        $model = Document::find()->where([
            'type_id' => $type,
            'identifier' => $identifier
        ])->one();

        if ($model !== null) {
            return $model;
        }

        return false;
    }
}
