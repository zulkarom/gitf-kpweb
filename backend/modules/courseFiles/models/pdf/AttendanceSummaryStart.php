<?php

namespace backend\modules\courseFiles\models\pdf;

use Yii;

class AttendanceSummaryStart extends \TCPDF {
	
	public $model;
	public $course;
	public $semester;
	public $group;
	public $curr_page;
	public $total_page;

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
		$wtable = 1160;
		$html ='
		<table border="1" cellpadding="6" width="'.$wtable.'">
		<tr>
		
		<td align="center" width="5%">
		<img src="images/logo-attendance.png" />
		</td>
		
		<td width="95%">
		
		<table border="0" cellpadding="2" >
		<tr>
		<td width="80%" height="'.$height.'" style="line-height:'.$line_height.'%">&nbsp;&nbsp;<b>STUDENT ATTENDANCE</b>
		</td>
		<td width="20%"  style="line-height:'.$line_height.'%">&nbsp;&nbsp;
		</td>
		</tr>
		
		<tr height="'.$height.'" style="line-height:'.$line_height.'%">
		<td>&nbsp;&nbsp;<b>SEMESTER: </b>'. strtoupper($this->semester->fullFormat()).'
		</td>
		<td>&nbsp;&nbsp;'.$time.'</td>
		</tr>
		
		<tr height="'.$height.'" style="line-height:'.$line_height.'%">
		<td>&nbsp;&nbsp;<b>SUBJECT: </b>'.$this->course->course_code.' ('.$this->group.') - '.strtoupper($this->course->course_name).'
		</td>
		<td></td>
		</tr>
		
		
		</table>
		
		</td>
		</tr>
		</table>
		
		';
		
		$this->SetFont('arial', '', 8.5);

		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
		
		
		$this->setY(10);
		$this->setX(234);
		
		  $this->Cell(40, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
	 
		//$this->setX($this->myX);
		//$this->setY(90);
		
		//$this->SetY($savedY);
		//$this->SetX($savedX);

	    
    }
	
	 public function Footer() {
		 
		 $y = $this->getY();
		 $this->SetFont('arial', '', 8.5);
		 
		// $time = strtoupper(date('d-M-Y h:m A', time()));
		 
		 // $this->Cell(0, 10, 'eFasi @  '. $time, 0, false, 'L', 0, '', 0, false, 'T', 'M');
		  
		  //$this->setY($y);
		  //$this->Cell(0, 10, '* H = HADIR, XH = TIDAK HADIR ', 0, false, 'L', 0, '', 0, false, 'T', 'M');
		 //$this->setY($y);

		  //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		  
		 
		
	 }


}
