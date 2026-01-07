<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use backend\modules\postgrad\models\StudentImport;

/**
 * StudentImportController provides import utilities for Postgrad students.
 */
class StudentImportController extends Controller
{
    /**
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
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionQuerySupervisorBersama(){
        $svc = new StudentImport();
        $logs = $svc->querySupervisorBersama(50);
        foreach ($logs as $line) {
            echo $line . "<br />";
        }
        exit;
    }

    /**
     * Import from pg_student_data3 (StudentData) into pg_student (Student).
     * - Creates/updates User by username = NO_MATRIK
     * - Creates/updates Student by matric_no (or user_id if present)
     * - Per-record transaction; collects summary
     */
    public function actionImport()
    {
        $svc = new StudentImport();
        $summary = $svc->importFromSource(50);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $summary;
    }

    public function actionUpdateStatusDaftar()
    {
        $svc = new StudentImport();
        $res = $svc->updateStatusDaftarFromStudentData();

        if (isset($res['error']) && $res['error']) {
            Yii::$app->session->setFlash('error', (string)$res['error']);
            return $this->redirect(['index']);
        }

        $updated = (int)($res['updated'] ?? 0);
        Yii::$app->session->setFlash('success', "Updated status_daftar for {$updated} students.");
        if (!empty($res['errors']) && is_array($res['errors'])) {
            Yii::$app->session->setFlash('error', implode('<br>', $res['errors']));
        }
        return $this->redirect(['index']);
    }
}