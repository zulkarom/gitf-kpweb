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
	public $group = null;
	
	public function generatePdf(){
			
			date_default_timezone_set("Asia/Kuala_Lumpur");
			// $this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
			
			$this->pdf = new CloSummaryStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
			$this->pdf->model = $this->model;
			$this->pdf->semester = $this->semester;
			$this->pdf->course = $this->course;
			$this->pdf->group = $this->group;
			
			
			$this->startPage();
			//$this->setHeader();
			$this->body();

			$this->pdf->Output('clo-summary.pdf', 'I');
		
		
	}
	
	
	
	public function body(){

		$wtable = 730;
		$bil = 45;
		$kira = count($this->listClo);
		$boxclo = 80;
		$lecture = 80;
		$lecturer = $wtable  - ($bil + $lecture + ($boxclo * $kira));
		

		$header_clo = '';
		if($this->listClo){
			  foreach ($this->listClo as $clo) {
				$str_total = 'total_clo'. $clo;
				$$str_total = 0;
				$str_count = 'count_clo'. $clo;
				$$str_count = 0;
				$header_clo .= '<td width="'.$boxclo.'" align="center"><b>CLO'.$clo.'</b></td>';
			  }
		}
		
		
		$html ='
		<br /><br />
		<table cellpadding="10" border="1" width="'.$wtable.'">
		<tr style="background-color:#ebebeb">
			<td width="'.$bil.'"><b>No.</b></td>
			<td width="'.$lecture.'" align="center"><b>Lecture</b></td>
			<td width="'.$lecturer.'"><b>Lecturer</b></td>';
		$html .= $header_clo;
		$html .= '</tr>
		';
		
		$i=1;
		if($this->model->lectures){
			
			foreach($this->model->lectures as $lecture){
				$has_value = true;
				if($this->group == 2){
				    $arr = json_decode($lecture->clo_achieve2);
				    
				}else{
				    $arr = json_decode($lecture->clo_achieve);
				}
				
				/* if(!is_array($arr)){
					$arr = [];
				} */
				$counted = true;
				if($arr == null){
					$arr = [];
					$counted = false;
					
				}
				
				if(!$arr){
				    $has_value = false;
				}
				
				if($has_value){
				$html .= '<tr><td>'.$i.'. </td><td align="center">'.$lecture->lec_name.'</td><td>';
				if($lecture->lecturers){
					foreach($lecture->lecturers as $b => $lecturer){
					    $br = $b == 0 ? '' : '<br />';
						$html .= $br . $lecturer->staff->staff_title .' '. $lecturer->staff->user->fullname;
					}
				}
				
				
				$html .= '</td>';
				$arr_avg = [];
				if($this->listClo){
				$x = 0;
				$html_average = '';
					$total = 0;
					$count = 0;
					foreach ($this->listClo as $clo) {
						$str_total = 'total_clo'. $clo;
						$str_count = 'count_clo'. $clo;
						$val = 0;
						if($counted){$$str_count++;}
						if(array_key_exists($x, $arr)){
							$val = $arr[$x];
						}
						$$str_total += $val;

						$html .= '<td width="'.$boxclo.'" align="center">'.$val.'</td>';

						$x++;
						
					}
					
				}
				
				
				$html .= '</tr>';
				
				
				$i++;
				}
			}
		
		}
		$html .= '
		<tr>
		<td colspan="3" align="right"><b>AVERAGE</b></td>';
		if($this->listClo){
		$p =0;
		$analysis = '';
		foreach ($this->listClo as $clo) {
			$str_total = 'total_clo'. $clo;
			$str_count = 'count_clo'. $clo;
			if($$str_count == 0){
				$avg = 0;
			}else{
				$avg = $$str_total / $$str_count;
			}
			$point = number_format($avg,2);
			$html .= '<td align="center"><b>'.$point.'</b></td>';
			$analysis .= '<td align="center">'. $this->analysis($point).'</td>';
		$p++;
		}
		}
		$html .= '</tr>';
		
		$html .= '
		<tr>
		<td colspan="3" align="right">ACHIEVEMENT ANALYSIS</td>';
		$html .= $analysis;
		$html .= '</tr>';
		
		$html .= '</table>';
		
		$html .= '<div style="height:2px;">&nbsp;</div>
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
