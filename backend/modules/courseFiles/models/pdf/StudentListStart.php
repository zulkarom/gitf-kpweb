<?php

namespace backend\modules\courseFiles\models\pdf;

use Yii;

class StudentListStart extends \TCPDF {
	
	public $model;
	public $course;
	public $semester;
	public $group;
	public $curr_page;
	public $total_page;
	public $lineFooterTable;

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
		$html ='
		<b>Universiti Malaysia Kelantan</b>
		
		<br />
		
		<b>Registered Students by Subject</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
		<br />
		
		';
		
		$this->SetFont('arial', '', 8.5);

		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true); 
		
		$x = 135;
		$this->setY(8);
		$this->setX($x);
		 
		 $this->Cell(40, 10, 'Page: '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M'); 
		 
		 $this->setY(12);
		$this->setX($x);
		
		 $this->Cell(40, 10, 'Date: '.$time, 0, false, 'L', 0, '', 0, false, 'T', 'M'); 
	 
		//$this->setX($this->myX);
		$this->setY(10);
		
		//$this->SetY($savedY);
		//$this->SetX($savedX);

	    
    }
	
	 public function Footer() {
		 
		if($this->lineFooterTable){
			$this->SetY(-13);
		$w = 178.5;
		$this ->Line($this->GetX(),$this->GetY(),$w, $this->GetY(), array('width'=>0.3));
		}
		
	 }


}
