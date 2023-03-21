<?php

namespace backend\modules\postgrad\models;

use Yii;

class MarkReportStart extends \TCPDF {
	
	public $course;
	public $program;


    //Page header
    public function Header() {
		
		//$this->myX = $this->getX();
		//$this->myY = $this->getY();
		//$savedX = $this->x;
		//savedY = $this->y;
		date_default_timezone_set("Asia/Kuala_Lumpur");
	
		$dir = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
		
		$page = $this->getPage();
		
		
		$this->SetFont('arial', '', 8.5);

		$html = '<table border="0"><tr><td width="80"><img src="images/umk-doc.png" width="50" /></td>
		<td>UNIVERSITI MALAYSIA KELANTAN<br />FAKULTI KEUSAHAWANAN DAN PERNIAGAAN<br /><br />
		<b>ASSESSMENT RESULT AND GRADE ANALYSIS</b>
<br />'. strtoupper($this->course->program->pro_name_bi)  .'


		</td>
		</tr></table>
		';

		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
		
		

		$this->setY(8);
		$this->setX(240);
		 
		 $this->Cell(40, 10, 'Page: '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M'); 
		 $this->setY(13);
		$this->setX(240);
		 $this->Cell(40, 10, 'Date: ' . date('d-M-Y h:i:s A'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
		 
		 //$this->setY(40);
	 
		//$this->setX($this->myX);
		//$this->setY(30);
		
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
