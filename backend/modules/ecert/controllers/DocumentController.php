<?php
namespace backend\modules\ecert\controllers;

use backend\modules\ecert\models\Certificate;
use backend\modules\ecert\models\Document;
use backend\modules\ecert\models\DocumentSearch;
use backend\modules\ecert\models\EventType;
use backend\modules\ecert\models\ExcelData;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DocumentController implements the CRUD actions for Document model.
 */
class DocumentController extends Controller
{

    /**
     *
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            '@'
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Document models.
     *
     * @return mixed
     */
    public function actionIndex($type)
    {
        $certType = $this->findCertType($type);
        $searchModel = new DocumentSearch();
        $searchModel->type_id = $certType->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'certType' => $certType
        ]);
    }

    /**
     * Displays a single Document model.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new Document model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate($type)
    {
        $certType = $this->findCertType($type);
        $model = new Document();
        $model->type_id = $certType->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'id' => $model->id
            ]);
        }

        return $this->render('create', [
            'model' => $model,
            'certType' => $certType
        ]);
    }

    public function actionCert($id)
    {
        $model = $this->findModel($id);
        $pdf = new Certificate();
        $pdf->model = $model;
        $pdf->generatePdf();
        exit();
    }

    /**
     * Updates an existing Document model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'view',
                'id' => $model->id
            ]);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing Document model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $type = $this->findModel($id)->type_id;
        $this->findModel($id)->delete();

        return $this->redirect([
            'index',
            'type' => $type
        ]);
    }

    /**
     * Finds the Document model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Document the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Document::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findCertType($id)
    {
        if (($model = EventType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionExportData($type)
    {
        $certType = $this->findCertType($type);

        $pdf = new ExcelData();
        $pdf->model = $certType;
        $pdf->generateExcel();
    }

    public function actionImportData($type)
    {
        $certType = $this->findCertType($type);

        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post('json_data');

            $data = json_decode($data);

            if ($data) {

                Document::updateAll([
                    'data_check' => 0
                ], [
                    'type_id' => $certType->id
                ]);

                foreach (array_slice($data, 1) as $doc) {

                    if (is_array($doc) and array_key_exists(0, $doc)) {

                        $identifier = trim($doc[0]);

                        $name = $doc[1];
                        $f1 = array_key_exists(2, $doc) ? $doc[2] : '';
                        $f2 = array_key_exists(3, $doc) ? $doc[3] : '';
                        $f3 = array_key_exists(4, $doc) ? $doc[4] : '';
                        $f4 = array_key_exists(5, $doc) ? $doc[5] : '';
                        $f5 = array_key_exists(6, $doc) ? $doc[6] : '';

                        $st = Document::findOne([
                            'identifier' => $identifier,
                            'type_id' => $certType->id
                        ]);
                        if ($st === null) {
                            $new = new Document();
                            $new->identifier = $identifier;
                            $new->participant_name = $name;
                            $new->type_id = $certType->id;
                            $new->field1 = $f1;
                            $new->field2 = $f2;
                            $new->field3 = $f3;
                            $new->field4 = $f4;
                            $new->field5 = $f5;
                            $new->data_check = 1;
                            if (! $new->save()) {}
                        } else {
                            $st->data_check = 1;
                            if (! $st->save()) {}
                        }
                    }
                }

                Document::deleteAll([
                    'data_check' => 0
                ]);
            }

            Yii::$app->session->addFlash('success', "Import success");
            return $this->redirect([
                'index',
                'type' => $certType->id
            ]);
        }
    }
}
