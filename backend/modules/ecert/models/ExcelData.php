<?php
namespace backend\modules\ecert\models;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelData
{

    public $model;

    public $sheet;

    public $border;

    public $documents;

    public function generateExcel()
    {
        $this->documents = $this->model->documents;

        $this->start();
        $this->setStyle();
        $this->createSheet();
        $this->setColumWidth();
        $this->setHeader();
        $this->studentList();
        $this->generate('Certificate Data');
    }

    public function start()
    {
        $title = 'Certificate List';
        $this->spreadsheet = new Spreadsheet();
        $this->spreadsheet->getProperties()
            ->setCreator('FKP PORTAL')
            ->setLastModifiedBy('FKP PORTAL')
            ->setTitle($title)
            ->setSubject($title)
            ->setDescription($title)
            ->setKeywords($title);
    }

    public function createSheet()
    {
        $this->spreadsheet->createSheet();
        $this->spreadsheet->setActiveSheetIndex(0);

        $this->spreadsheet->getActiveSheet()->setTitle('Certificate Data');
        $this->sheet = $this->spreadsheet->getActiveSheet();
    }

    public function setStyle()
    {
        $this->bold = array(
            'font' => array(
                'bold' => true,
                // 'color' => array('rgb' => 'FF0000'),
                'size' => 11,
                'name' => 'Calibri'
            )
        );
        $this->normal = array(
            'font' => array(
                'size' => 11,
                'name' => 'Calibri'
            )
        );
    }

    public function setColumWidth()
    {
        $normal = 24.29; // 9.43
        $this->sheet->getColumnDimension('A')->setWidth(12.57);
        $this->sheet->getColumnDimension('B')->setWidth(40.57);
    }

    public function setHeader()
    {
        // ROW HEIGHT
        // $this->sheet->getRowDimension('1')->setRowHeight(24);

        // CONTENT
        $this->sheet->setCellValue('A1', 'Identifier')
            ->setCellValue('B1', 'Participant Name')
            ->setCellValue('C1', 'Field 1')
            ->setCellValue('D1', 'Field 2')
            ->setCellValue('E1', 'Field 3')
            ->setCellValue('F1', 'Field 4')
            ->setCellValue('G1', 'Field 5');
    }

    public function studentList()
    {
        if ($this->model->documents) {
            $row = 2;

            foreach ($this->model->documents as $doc) {
                $this->sheet->setCellValue('A' . $row, $doc->identifier)
                    ->setCellValue('B' . $row, $doc->participant_name)
                    ->setCellValue('C' . $row, $doc->field1)
                    ->setCellValue('D' . $row, $doc->field2)
                    ->setCellValue('E' . $row, $doc->field3)
                    ->setCellValue('F' . $row, $doc->field4)
                    ->setCellValue('G' . $row, $doc->field5);

                $row ++;
            }
        }
    }

    public function generate($filename)
    {

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $this->spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($this->spreadsheet, 'Xls');
        $writer->save('php://output');
        exit();
    }

    public function abc($col)
    {
        $arr = [
            1 => 'A',
            2 => 'B',
            3 => 'C',
            4 => 'D',
            5 => 'E',
            6 => 'F',
            7 => 'G',
            8 => 'H',
            9 => 'I',
            10 => 'J',
            11 => 'K',
            12 => 'L',
            13 => 'M',
            14 => 'N',
            15 => 'O',
            16 => 'P',
            17 => 'Q'
        ];

        return $arr[$col];
    }
}
