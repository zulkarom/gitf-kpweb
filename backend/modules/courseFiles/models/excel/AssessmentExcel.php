<?php

namespace backend\modules\courseFiles\models\excel;

use Yii;
use common\models\Common;
use backend\modules\teachingLoad\models\CourseOffered;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AssessmentExcel
{
	public $model;
	public $sheet;
	public $border;
	public $course;
	public $assessment;
	public $listClo;

	public function generateExcel(){
		$offer = $this->model->courseOffered;
		$this->assessment = $offer->assessment;
		$this->course = $offer->course;
		$this->listClo = $offer->listClo();

		$this->start();
		$this->setStyle();
		$this->createSheet();
		$this->setColumWidth();
		$this->setHeader();
		$this->setClos();
		$this->setWeigtage();
		$this->setTotalMark();
		$this->setAssessment();
		$this->studentList();
		$this->generate('Student Assessment');
		
		
	}
	
	
	public function start(){
		
		$title = 'Student Assessment';
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
		$this->sheet->getColumnDimension('A')->setWidth(5.57);
		$this->sheet->getColumnDimension('B')->setWidth(10.57);
		$this->sheet->getColumnDimension('C')->setWidth(50);

	}
	
	public function setHeader(){
		//ROW HEIGHT
		$this->sheet->getRowDimension('1')->setRowHeight(24);
		$this->sheet->getRowDimension('5')->setRowHeight(24);
		
		//SET SYTLE
		$this->sheet->getStyle('A1:P4')->applyFromArray($this->bold);
		
		/* $this->sheet->getStyle('D:P')
		->applyFromArray($this->normal)
		->getAlignment()
		->setVertical(Alignment::VERTICAL_CENTER)
		->setHorizontal(Alignment::HORIZONTAL_CENTER)
		; */
		
		$this->sheet->getStyle('C1:C3')->applyFromArray($this->normal)
		->getAlignment()
			->setVertical(Alignment::VERTICAL_CENTER)
			->setHorizontal(Alignment::HORIZONTAL_RIGHT);
		
		$this->sheet->getStyle('D1:P3')
		->getAlignment()
		->setVertical(Alignment::VERTICAL_CENTER)
		->setHorizontal(Alignment::HORIZONTAL_CENTER);
		


		//CONTENT
		$this->sheet
			->setCellValue('A4', 'No.')
			->setCellValue('B4', 'Matric No.')
			->setCellValue('C4', 'Name')
			->setCellValue('C1', 'Course Learning Outcome')
			->setCellValue('C2', 'Weightage')
			->setCellValue('C3', 'Total Mark');
	}
	
	public function setClos(){
		if($this->assessment){
			
			$col = 4;
			foreach ($this->assessment as $assess) {
				
				$a = $this->abc($col);
				$str = 'CLO'.$assess->cloNumber;
				$this->sheet->setCellValue($a.'1', $str);
			$col++;
			}
		}
		
	}
	
	public function setWeigtage(){
		if($this->assessment){
			$col = 4;
			foreach ($this->assessment as $assess) {
				
				$a = $this->abc($col);
				$str = $assess->assessmentPercentage . '%';
				$this->sheet->setCellValue($a.'2', $str);
			$col++;
			}
		}
		
	}
	
	public function setTotalMark(){
		if($this->assessment){
			$col = 4;
			foreach ($this->assessment as $assess) {
				
				$a = $this->abc($col);
				$str = $assess->assessmentPercentage ;
				$this->sheet->setCellValue($a.'3', $str);
			$col++;
			}
		}
	}
	
	public function setAssessment(){
		if($this->assessment){
			$col = 4;
			foreach ($this->assessment as $assess) {
				
				$a = $this->abc($col);
				$str = $assess->assess_name_bi;
				$this->sheet->setCellValue($a.'4', $str);
			$col++;
			}
		}
	}

	public function studentList(){

			if($this->model->students)
			{
				$row =5;
				foreach ($this->model->students as $student) {
					$i=$row-4;
					$this->sheet
					->setCellValue('A'.$row, $i)
					->setCellValue('B'.$row, $student->matric_no)
					->setCellValue('C'.$row, $student->student->st_name);
					
					$result = json_decode($student->assess_result);
					
					$col = 4;
					
					foreach ($this->assessment as $assess) {
						$x = $col -4;
						if($result){
						  if(array_key_exists($x, $result)){
							$mark = $result[$x];
							$a = $this->abc($col);
							$this->sheet->setCellValue($a.$row, $mark);
						  }
						}
						
						
					$col++;
					}
					
					
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
