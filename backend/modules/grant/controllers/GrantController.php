<?php

namespace backend\modules\grant\controllers;

use Yii;
use backend\modules\grant\models\Grant;
use backend\modules\grant\models\GrantSearch;
use yii\db\Query;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class GrantController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new GrantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionStats()
    {
        $summary = (new Query())
            ->from('grn_grant')
            ->select([
                'grant_count' => 'COUNT(*)',
                'sum_amount' => 'COALESCE(SUM(amount), 0)',
                'extended_count' => 'SUM(CASE WHEN is_extended = 1 THEN 1 ELSE 0 END)',
            ])
            ->one();

        $totalActiveAcademicStaff = (new Query())
            ->from('staff')
            ->where(['staff_active' => 1, 'is_academic' => 1, 'working_status' => 1])
            ->count();

        $distinctHeadResearcherStaff = (new Query())
            ->from(['g' => 'grn_grant'])
            ->innerJoin(['sv' => 'pg_supervisor'], 'sv.id = g.head_researcher_id')
            ->select('COUNT(DISTINCT sv.staff_id)')
            ->where(['sv.is_internal' => 1])
            ->andWhere('sv.staff_id IS NOT NULL')
            ->scalar();

        $overallPercentage = 0;
        if ((int) $totalActiveAcademicStaff > 0) {
            $overallPercentage = ((int) $distinctHeadResearcherStaff / (int) $totalActiveAcademicStaff) * 100;
        }

        $currentYear = (int) date('Y');
        $years = [];
        for ($y = $currentYear; $y >= $currentYear - 5; $y--) {
            $years[] = $y;
        }

        $byYear = [];
        foreach ($years as $yr) {
            $yearStart = $yr . '-01-01';
            $yearEnd = $yr . '-12-31';

            // Grant overlaps a year if: date_start <= yearEnd AND (date_end is null OR date_end >= yearStart)
            $distinctYr = (new Query())
                ->from(['g' => 'grn_grant'])
                ->innerJoin(['sv' => 'pg_supervisor'], 'sv.id = g.head_researcher_id')
                ->select('COUNT(DISTINCT sv.staff_id)')
                ->where(['sv.is_internal' => 1])
                ->andWhere('sv.staff_id IS NOT NULL')
                ->andWhere('g.date_start IS NOT NULL')
                ->andWhere('g.date_start <= :yearEnd', [':yearEnd' => $yearEnd])
                ->andWhere('(g.date_end IS NULL OR g.date_end >= :yearStart)', [':yearStart' => $yearStart])
                ->scalar();

            $pct = 0;
            if ((int) $totalActiveAcademicStaff > 0) {
                $pct = ((int) $distinctYr / (int) $totalActiveAcademicStaff) * 100;
            }

            $byYear[] = [
                'year' => (int) $yr,
                'distinct_staff' => (int) $distinctYr,
                'total_staff' => (int) $totalActiveAcademicStaff,
                'percentage' => $pct,
            ];
        }

        $byCategory = (new Query())
            ->from(['g' => 'grn_grant'])
            ->innerJoin(['c' => 'grn_category'], 'c.id = g.category_id')
            ->select([
                'category' => 'c.category_name',
                'grant_count' => 'COUNT(*)',
                'sum_amount' => 'COALESCE(SUM(g.amount), 0)',
            ])
            ->groupBy(['c.id', 'c.category_name'])
            ->orderBy(['grant_count' => SORT_DESC, 'category' => SORT_ASC])
            ->all();

        $byType = (new Query())
            ->from(['g' => 'grn_grant'])
            ->innerJoin(['t' => 'grn_type'], 't.id = g.type_id')
            ->select([
                'type' => 't.type_name',
                'grant_count' => 'COUNT(*)',
                'sum_amount' => 'COALESCE(SUM(g.amount), 0)',
            ])
            ->groupBy(['t.id', 't.type_name'])
            ->orderBy(['grant_count' => SORT_DESC, 'type' => SORT_ASC])
            ->all();

        return $this->render('stats', [
            'summary' => $summary,
            'totalActiveAcademicStaff' => (int) $totalActiveAcademicStaff,
            'distinctHeadResearcherStaff' => (int) $distinctHeadResearcherStaff,
            'overallPercentage' => $overallPercentage,
            'byYear' => $byYear,
            'byCategory' => $byCategory,
            'byType' => $byType,
        ]);
    }

    public function actionExportExcel()
    {
        $searchModel = new GrantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        $models = $dataProvider->getModels();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Grants');

        $headers = [
            'ID',
            'Grant Title',
            'Category',
            'Type',
            'Head Researcher',
            'Amount',
            'Date Start',
            'Date End',
            'Is Extended',
        ];

        $col = 1;
        foreach ($headers as $h) {
            $sheet->setCellValueByColumnAndRow($col, 1, $h);
            $col++;
        }

        $rowNum = 2;
        foreach ($models as $m) {
            $head = '';
            if ($m->headResearcher) {
                $sv = $m->headResearcher;
                if ($sv->staff) {
                    $head = $sv->staff->staff_no . ' - ' . strtoupper($sv->svNamePlain);
                } else {
                    $head = strtoupper($sv->svNamePlain);
                }
            }

            $values = [
                $m->id,
                $m->grant_title,
                $m->category ? $m->category->category_name : null,
                $m->type ? $m->type->type_name : null,
                $head,
                $m->amount,
                $m->date_start,
                $m->date_end,
                (int) $m->is_extended,
            ];

            $col = 1;
            foreach ($values as $v) {
                $sheet->setCellValueByColumnAndRow($col, $rowNum, $v);
                $col++;
            }

            $rowNum++;
        }

        $filename = 'grants_' . date('Ymd_His');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
        exit;
    }

    public function actionCreate()
    {
        $model = new Grant();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Grant::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
