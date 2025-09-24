<?php

namespace backend\modules\postgrad\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use yii\web\Response;
use backend\modules\staff\models\Staff;
use backend\modules\postgrad\models\Supervisor;
use backend\modules\postgrad\models\SupervisorField;

/**
 * Default controller for the `postgrad` module
 * https://drive.google.com/drive/folders/1UEusfaryAjgms_aLlxiTYtt84ztJa0Og
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
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

    /**
     * Read CSV from db/field_data.csv and upsert supervisor fields.
     * URL: index.php?r=postgrad/default/update-fields-data
     */
    public function actionUpdateFieldsData()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;

        // Resolve CSV path relative to backend/ -> ../db/field_data.csv
        $backendPath = Yii::getAlias('@app');
        $projectRoot = dirname($backendPath);
        $csvPath = $projectRoot . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'field_data.csv';

        if (!is_file($csvPath)) {
            return "CSV file not found: $csvPath";
        }

        $schema = Yii::$app->db->schema->getTableSchema('pg_sv_field');
        $hasSubFields = $schema && $schema->getColumn('sub_fields') !== null;

        $handle = fopen($csvPath, 'r');
        if (!$handle) {
            return "Unable to open CSV file: $csvPath";
        }

        //die('good');

        $header = fgetcsv($handle); // read header
        $rowNum = 1;

        $stats = [
            'processed' => 0,
            'supervisor_created' => 0,
            'sv_field_inserted' => 0,
            'sv_field_updated' => 0,
            'skipped_no_staff' => 0,
            'errors' => 0,
        ];

        $messages = [];

        while (($data = fgetcsv($handle)) !== false) {
            $rowNum++;
            // Expecting: staff_no, field_id, sub_fields
            if (count($data) < 2) {
                $messages[] = "Row $rowNum: invalid column count";
                $stats['errors']++;
                continue;
            }

            $staffNo = trim((string)$data[0]);
            $fieldId = (int)trim((string)$data[1]);
            $subFields = isset($data[2]) ? trim((string)$data[2]) : '';

            if ($staffNo === '') {
                $messages[] = "Row $rowNum: empty staff_no";
                $stats['errors']++;
                continue;
            }

            $staff = Staff::find()->where(['staff_no' => $staffNo])->one();
            if (!$staff) {
                $messages[] = "Row $rowNum: staff_no $staffNo not found";
                $stats['skipped_no_staff']++;
                continue;
            }

            // Find or create Supervisor (internal)
            $supervisor = Supervisor::find()->where(['staff_id' => $staff->id])->one();
            if (!$supervisor) {
                $supervisor = new Supervisor();
                $supervisor->staff_id = $staff->id;
                $supervisor->is_internal = 1;
                $supervisor->created_at = time();
                $supervisor->updated_at = time();
                if (!$supervisor->save(false)) {
                    $messages[] = "Row $rowNum: failed to create supervisor for staff_no $staffNo";
                    $stats['errors']++;
                    continue;
                }
                $stats['supervisor_created']++;
            }

            // Upsert SupervisorField
            $svField = SupervisorField::find()->where(['sv_id' => $supervisor->id])->one();
            if (!$svField) {
                $svField = new SupervisorField();
                $svField->sv_id = $supervisor->id;
                $svField->field_id = $fieldId ?: null;
                if ($hasSubFields) {
                    $svField->setAttribute('sub_fields', $subFields);
                }
                if ($svField->save(false)) {
                    $stats['sv_field_inserted']++;
                } else {
                    $messages[] = "Row $rowNum: failed to insert pg_sv_field for staff_no $staffNo";
                    $stats['errors']++;
                }
            } else {
                $svField->field_id = $fieldId ?: null;
                if ($hasSubFields) {
                    $svField->setAttribute('sub_fields', $subFields);
                }
                if ($svField->save(false)) {
                    $stats['sv_field_updated']++;
                } else {
                    $messages[] = "Row $rowNum: failed to update pg_sv_field for staff_no $staffNo";
                    $stats['errors']++;
                }
            }

            $stats['processed']++;
        }

        fclose($handle);

        $summary = [];
        $summary[] = 'Update Fields Data Summary';
        $summary[] = '--------------------------------';
        foreach ($stats as $k => $v) {
            $summary[] = sprintf('%s: %d', $k, $v);
        }
        if (!$hasSubFields) {
            $summary[] = '';
            $summary[] = 'Note: Column sub_fields does not exist in table pg_sv_field. Only field_id was updated/inserted.';
        }
        if (!empty($messages)) {
            $summary[] = '';
            $summary[] = 'Details:';
            foreach ($messages as $m) {
                $summary[] = '- ' . $m;
            }
        }

        return implode("\n", $summary);
    }
}
