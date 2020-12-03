<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use common\models\Common;
use backend\modules\teachingLoad\models\CourseOffered;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class BulkSessionExcel
{
	public $model;
	public $sheet;
	public $border;

	

	public function generateExcel(){
		$this->start();
		$this->setStyle();
		$this->createSheet();
		$this->setColumWidth();
		$this->item1Name();
		$this->generate('Bulk Session'.'-'.$this->model->semester);
		
		
	}
	
	
	public function start(){
		
		$title = 'Bulk Session'.'-'.$this->model->semester;
		$this->spreadsheet = new Spreadsheet();
		$this->spreadsheet->getProperties()->setCreator('FKP PORTAL')
			->setLastModifiedBy('FKP PORTAL')
			->setTitle($title)
			->setSubject($title)
			->setDescription($title)
			->setKeywords($title);
	}
	
	public function createSheet(){

		$this->spreadsheet->createSheet();
		$this->spreadsheet->setActiveSheetIndex(0);
	
		$this->spreadsheet->getActiveSheet()->setTitle('Bulk Session'.'-'.$this->model->semester);
		$this->sheet = $this->spreadsheet->getActiveSheet();
	}

	public function setStyle(){
		 $this->bold = array(
				'font'  => array(
					'bold'  => true,
					//'color' => array('rgb' => 'FF0000'),
					'size'  => 11,
					'name'  => 'Calibri'
					),
			);
		}
	
	public function setColumWidth(){
		$normal = 24.29;//9.43
		$this->sheet->getColumnDimension('A')->setWidth(1.57);
		$this->sheet->getColumnDimension('B')->setWidth(5.57);
		$this->sheet->getColumnDimension('C')->setWidth(18.57);
		$this->sheet->getColumnDimension('D')->setWidth(70);
		$this->sheet->getColumnDimension('E')->setWidth(16.22);
		$this->sheet->getColumnDimension('F')->setWidth(16.22);
		$this->sheet->getColumnDimension('G')->setWidth($normal);
		$this->sheet->getColumnDimension('H')->setWidth(28.29);
		$this->sheet->getColumnDimension('I')->setWidth(19.29);
		$this->sheet->getColumnDimension('J')->setWidth(28.29);
		$this->sheet->getColumnDimension('K')->setWidth(19.29);
	}

	public function item1Name(){
		//ROW HEIGHT
		$this->sheet->getRowDimension('1')->setRowHeight(24);
		$this->sheet->getRowDimension('5')->setRowHeight(24);
		
		//SET SYTLE
		$this->sheet->getStyle('B1')->applyFromArray($this->bold)
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('C1')->applyFromArray($this->bold)
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('D1')->applyFromArray($this->bold)
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('E1')->applyFromArray($this->bold)
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('F1')->applyFromArray($this->bold)
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('G1')->applyFromArray($this->bold)
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('H1')->applyFromArray($this->bold)
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('I1')->applyFromArray($this->bold)
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('J1')->applyFromArray($this->bold)
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$this->sheet->getStyle('K1')->applyFromArray($this->bold)
		->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		//CONTENT
		$this->sheet
			->setCellValue('B1', '#')
			->setCellValue('C1', 'Course Code')
			->setCellValue('D1', 'Course Name (BM)')
			->setCellValue('E1', 'Current Lectures')
			->setCellValue('F1', 'Current Tutorials')
			->setCellValue('G1', 'Total Number of Students')
			->setCellValue('H1', 'Maximum Student of a Lecture')
			->setCellValue('I1', 'Prefix Lecture Name')
			->setCellValue('J1', 'Maximum Student of a Tutorial')
			->setCellValue('K1', 'Prefix Tutorial Name');
			
			if($this->model->course)
			{
				$row =2;
				
				foreach ($this->model->course as $offer) {
					$i=$row-1;
					$this->sheet
					->setCellValue('B'.$row, $i)
					->setCellValue('C'.$row, $offer->course->course_code)
					->setCellValue('D'.$row, $offer->course->course_name)
					->setCellValue('E'.$row, $offer->countLectures)
					->setCellValue('F'.$row, $offer->countTutorials)
					->setCellValue('G'.$row, $offer->total_students)
					->setCellValue('H'.$row, $offer->max_lec)
					->setCellValue('I'.$row, $offer->prefix_lec)
					->setCellValue('J'.$row, $offer->max_tut)
					->setCellValue('K'.$row, $offer->prefix_tut);
					$row++;
				}
				
			
	}
}
		

	
	public function generate($filename){
		

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$this->spreadsheet->setActiveSheetIndex(0);
		
		// Redirect output to a client’s web browser (Xls)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
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
		exit;
	}

}