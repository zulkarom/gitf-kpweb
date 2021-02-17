<?php

namespace backend\modules\courseFiles\models\pdf;

use Yii;
use common\models\Common;


class CloSummary
{
	public $model;
	public $semester;
	public $course;
	public $response;
	public $pdf;
	public $listClo;
	public $directoryAsset;
	
	public function generatePdf(){
			
			date_default_timezone_set("Asia/Kuala_Lumpur");
			// $this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
			
			$this->pdf = new CloSummaryStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
			$this->pdf->model = $this->model;
			$this->pdf->semester = $this->semester;
			$this->pdf->course = $this->course;
			
			
			$this->startPage();
			//$this->setHeader();
			$this->body();

			$this->pdf->Output('clo-summary.pdf', 'I');
		
		
	}
	
	
	
	public function body(){

		$wtable = 730;
		$bil = 45;
		$kira = count($this->listClo);
		$boxclo = 70;
		$lecture = 80;
		$lecturer = $wtable  - ($bil + $lecture + ($boxclo * $kira));
		

		$header_clo = '';
		if($this->listClo){
			  foreach ($this->listClo as $clo) {
				
				$header_clo .= '<td width="'.$boxclo.'">CLO'.$clo.'</td>';
			  }
		}
		
		
		$html ='
		<br /><br />
		<table cellpadding="10" border="1" width="'.$wtable.'">
		<tr style="background-color:#ebebeb">
			<td width="'.$bil.'"><b>No.</b></td>
			<td width="'.$lecture.'"><b>Lecture</b></td>
			<td width="'.$lecturer.'"><b>Lecturer</b></td>';
		$html .= $header_clo;
		$html .= '</tr>
		';
		
		$i=1;
		if($this->model->lectures){
			foreach($this->model->lectures as $lecture){
				$html .= '<tr><td>'.$i.'. </td><td>'.$lecture->lec_name.'</td><td>';
				
				if($lecture->lecturers){
					
					foreach($lecture->lecturers as $lecturer){
						$html .= $lecturer->staff->user->fullname;
					}
		
				}
				
				
				$html .= '</td>';
				
			$html .= '<td>'.$lecture->clo_achieve .'</td>';
				
				$html .= '</tr>';
				$i++;
			}
		
		}
		$html .= '</table>
		
		<div style="height:2px;">&nbsp;</div>
		<span style="font-size:13px;"> 
 * 0.00-0.99 (Sangat Lemah/ Very Poor), 1.00-1.99 (Lemah/ Poor), 2.00-2.99 (Baik/ Good), 3.00-3.69 (Sangat Baik/ Very Good), 3.70-4.00 (Cemerlang/ Excellent). </span>
		';
		
		$tbl = <<<EOD
		$html
EOD;
		$this->pdf->SetFont('arial', '', 10);
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
	}
	
	public function cloValue($clo,$result,$cloSet)
	{
	  $i =0;
	  $mark=0;
	  if($cloSet && $result)
	  {
		foreach($cloSet as $cs)
		{
		  if($cs == $clo){
			if(array_key_exists($i, $result))
			{
			  $mark += $result[$i];
			}
			
		  }
		  
		  $i++;
		}
		
	  }
	  return $mark;
	}

	public function analysis($point){
		if($point >= 3.7 and $point <= 4){
			return 'Cemerlang/ Excellent';
		}else if($point >= 3 and $point < 3.7){
			return 'Sangat Baik/ Very Good';
		}else if($point >= 2 and $point < 3){
			return 'Baik/ Good';
		}else if($point >= 1 and $point < 2){
			return 'Lemah/ Poor';
		}else if($point >= 0 and $point < 1){
			return 'Sangat Lemah/ Very Poor';
		}else{
			return '';
		}
	}
	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('FKP PORTAL');
		$this->pdf->SetTitle('CLO Analysis');
		$this->pdf->SetSubject('CLO Analysis');
		$this->pdf->SetKeywords('');



		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$this->pdf->SetMargins(15, 17, 15);
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
