<?php

namespace backend\modules\postgrad\models;

use Yii;

class MarkReportStart extends \TCPDF {
	
	public $model;
	public $course;
	public $semester;
	public $group;
	public $curr_page;
	public $total_page;
	public $analysis_group = null;

    //Page header
    public function Header() {
		
		//$this->myX = $this->getX();
		//$this->myY = $this->getY();
		//$savedX = $this->x;
		//savedY = $this->y;
		date_default_timezone_set("Asia/Kuala_Lumpur");
	
		$dir = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
		
		$page = $this->getPage();
		
		
		$this->SetFont('arial', '', 9);

		$html = '<table border="0"><tr><td width="60"><img src="images/umk-doc.png" width="50" /></td>
		<td style="font-size:17px">Universiti Malaysia Kelantan<br />Fakulti Keusahawanan dan Perniagaan<br />
		<b>Result and Grade Analysis</b>
		</td>
		</tr></table>
		';

		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
		
		
		$this->setY(8);
		$this->setX(170);
		 
		 $this->Cell(40, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M'); 

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
