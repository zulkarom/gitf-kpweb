<?php

namespace backend\modules\courseFiles\models\pdf;

use Yii;

class CloSummaryStart extends \TCPDF {
	
	public $model;
	public $semester;
	public $course;
	public $curr_page;
	public $total_page;
	public $group = false;

    //Page header
    public function Header() {
		
		//$this->myX = $this->getX();
		//$this->myY = $this->getY();
		//$savedX = $this->x;
		//savedY = $this->y;
		date_default_timezone_set("Asia/Kuala_Lumpur");
	
		$dir = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
		
		$page = $this->getPage();
		$height = 31;
		$line_height = 220;
		$time = strtoupper(date('d-M-Y h:m A', time()));
		$grup = ''; 
		if($this->group == 1){
		    $grup = '(GROUP 1)';
		}else if($this->group == 2){
		    $grup = '(GROUP 2)';
		}
		$html ='
		<b>CLO SUMMARY ANALYSIS ' . $grup . '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<b>SEMESTER: </b>'. strtoupper($this->semester->shortFormat()).'
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>COURSE: </b>'.$this->course->course_code.' - '.strtoupper($this->course->course_name).'
		<br />
		
		';
		
		$this->SetFont('arial', '', 8.5);

		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true); 
		
		
		$this->setY(8);
		$this->setX(270);
		 
		 $this->Cell(40, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M'); 
	 
		//$this->setX($this->myX);
		$this->setY(10);
		
		//$this->SetY($savedY);
		//$this->SetX($savedX);

	    
    }
	
	 public function Footer() {
		 
		 $y = $this->getY();
		 $this->SetFont('arial', '', 8.5);
		 
		// $time = strtoupper(date('d-M-Y h:m A', time()));
		 
		 // $this->Cell(0, 10, 'eFasi @  '. $time, 0, false, 'L', 0, '', 0, false, 'T', 'M');
		  
		  $this->setY($y);
		 /// $this->Cell(0, 10, '* H = HADIR, XH = TIDAK HADIR ', 0, false, 'L', 0, '', 0, false, 'T', 'M');
		 $this->setY($y);

		  //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		  
		 
		
	 }


}
