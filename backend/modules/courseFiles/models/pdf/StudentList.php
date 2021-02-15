<?php

namespace backend\modules\courseFiles\models\pdf;

use Yii;
use common\models\Common;


class StudentList
{
	public $model;
	public $course;
	public $semester;
	public $group;
	public $response;
	public $pdf;
	public $directoryAsset;
	
	public function generatePdf(){
			
			date_default_timezone_set("Asia/Kuala_Lumpur");
			// $this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
			
			$this->pdf = new StudentListStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
			$this->pdf->model = $this->model;
			$this->pdf->course = $this->course;
			$this->pdf->semester = $this->semester;
			$this->pdf->group = $this->group;
			
			$this->startPage();
			//$this->setHeader();
			$this->body();

			$this->pdf->Output('clo-analysis.pdf', 'I');
		
		
	}
	

	

	
	public function body(){

		$wtable = 1160;
		
		$bil = 45;
		$matrik = 95;
		$name = $matrik * 6;
		
		$total = $bil + $matrik + $name;
		//$this->pdf->total_width = $total;
		
		$group = 100;
		$info = $total - $group;

		

		
		$html ='
		<table cellpadding="0" width="'.$wtable.'" style="border-bottom:1px solid #000000">


		<thead>
		<tr>
		
		<td style="line-height: 150%;border-top:1px solid #000000;border-left:1px solid #000000" width="'.$group.'" align="left" >
		<b> &nbsp; Semester</b>
		</td>
		
		<td style="line-height: 150%;border-top:1px solid #000000;border-right:1px solid #000000" colspan="2" width="'.$info.'">
		'. strtoupper($this->semester->longFormat()).'
		</td>

		
		
		</tr>
		<tr>
		
		<td style="line-height: 250%;border-left:1px solid #000000" width="'.$group.'" align="left" >
		<b> &nbsp; Subject</b>
		</td>
		<td style="line-height: 250%;border-right:1px solid #000000" colspan="2" width="'.$info.'">
		'.$this->course->course_code.' - '.strtoupper($this->course->course_name).'
		</td>

		
		
		</tr>
		<tr>
		
		<td style="line-height: 250%;border-top:1px solid #000000;border-left:1px solid #000000" width="'.$group.'" align="left" >
		<b> &nbsp; Group</b>
		</td>
		<td style="line-height: 250%;border-top:1px solid #000000;border-right:1px solid #000000" colspan="2" width="'.$info.'">
		'.$this->group.'
		</td>

		
		
		</tr>
		
		<tr style="background-color:#ebebeb">

			<td width="'.$bil.'" align="center" style="line-height: 250%;border-top:1px solid #000000;border-left:1px solid #000000;border-bottom:1px solid #000000"><b>NO.</b></td>
			<td width="'.$matrik.'"  style="line-height: 250%;border-top:1px solid #000000;border-bottom:1px solid #000000"><b>  MATRIC NO.</b></td>
			<td width="'.$name.'" style="line-height: 250%;border-top:1px solid #000000;border-right:1px solid #000000;border-bottom:1px solid #000000"><b> STUDENT NAME</b></td>
			';


			
		
		$html .= '</tr>
		</thead>
		';
		
		if($this->model->students){
			// if($this->response->student->result){
				$num = 1;
				//style="line-height: 150%;"
				foreach($this->model->students as $student){
						$html .= '
						<tr nobr="true">
						<td style="border-left:1px solid #000000" width="'.$bil.'"  align="center">'.$num.'. </td>
						<td width="'.$matrik.'">  '.$student->matric_no .'</td>
						<td width="'.$name.'" style="padding:9px;border-right:1px solid #000000">
						<table>
						<tr>
						<td width="2%"></td><td width="98%">'.$student->student->st_name .'</td>
						</tr>
						</table>
						</td>
						</tr>
						';
					$num++;
				}

		}
		

		
		$html .= '</table>';

		$tbl = <<<EOD
		$html
EOD;
		$this->pdf->lineFooterTable = true;
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		$this->pdf->lineFooterTable = false;
		
	}
	

	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('FKP PORTAL');
		$this->pdf->SetTitle('Student List');
		$this->pdf->SetSubject('Student List');
		$this->pdf->SetKeywords('');



		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$this->pdf->SetMargins(15, 20, 15);
		//$this->pdf->SetMargins(0, 0, 0);
		$this->pdf->SetHeaderMargin(10);
		//$this->pdf->SetHeaderMargin(0);

		 //$this->pdf->SetHeaderMargin(0, 0, 0);
		$this->pdf->SetFooterMargin(10);

		// set auto page breaks
		$this->pdf->SetAutoPageBreak(TRUE, 13); //margin bottom

		// set image scale factor
		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$this->pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		$this->pdf->setImageScale(1.53);
		
		$this->pdf->SetFont('arial', '', 8.5);

		// add a page
		$this->pdf->AddPage("P");
		
		$this->pdf->curr_page = $this->pdf->getAliasNumPage();
		$this->pdf->total_page = $this->pdf->getAliasNbPages();
	}
	
	
}
