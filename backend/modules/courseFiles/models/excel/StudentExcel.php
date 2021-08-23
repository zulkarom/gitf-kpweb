<?php

namespace backend\modules\courseFiles\models\excel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class StudentExcel
{
	public $model;
	public $sheet;
	public $border;
	public $course;

	public function generateExcel(){
		$offer = $this->model->courseOffered;
		$this->course = $offer->course;

		$this->start();
		$this->setStyle();
		$this->createSheet();
		$this->setColumWidth();
		$this->setHeader();
		$this->studentList();
		$this->generate('Student List');
		
		
	}
	
	
	public function start(){
		
		$title = 'Student List';
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
	
		$this->spreadsheet->getActiveSheet()->setTitle($this->course->course_code . ' ' . $this->model->lec_name);
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
		$this->normal = array(
				'font'  => array(
					'size'  => 11,
					'name'  => 'Calibri'
					),
			);
	}
	
	public function setColumWidth(){
		$normal = 24.29;//9.43
		$this->sheet->getColumnDimension('A')->setWidth(12.57);
		$this->sheet->getColumnDimension('B')->setWidth(40.57);

	}
	
	public function setHeader(){
		//ROW HEIGHT
		//$this->sheet->getRowDimension('1')->setRowHeight(24);

		//CONTENT
		$this->sheet
			->setCellValue('A1', 'Matric No.')
			->setCellValue('B1', 'Name');
	}
	


	public function studentList(){

			if($this->model->students)
			{
				$row =2;
				foreach ($this->model->students as $student) {
					$this->sheet
					->setCellValue('A'.$row, $student->matric_no)
					->setCellValue('B'.$row, $student->student->st_name);

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
	
	public function abc($col){
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
