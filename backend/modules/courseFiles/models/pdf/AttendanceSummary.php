<?php

namespace backend\modules\courseFiles\models\pdf;

use Yii;
use common\models\Common;


class AttendanceSummary
{
	public $model;
	public $course;
	public $semester;
	public $group;
	public $response;
	public $pdf;
	public $directoryAsset;
	
	public function generatePdf(){
		if($this->model){
			date_default_timezone_set("Asia/Kuala_Lumpur");
			// $this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
			
			$this->pdf = new AttendanceSummaryStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
			$this->pdf->model = $this->model;
			$this->pdf->course = $this->course;
			$this->pdf->semester = $this->semester;
			$this->pdf->group = $this->group;
			
			$this->startPage();
			$this->body();

			$this->pdf->Output('attendance.pdf', 'I');
		}else{
			echo 'Maaf, tidak dapat data dari UMK Portal. Sila periksa sama ada portal UMK berfungsi atau kursus dan kumpulan tidak ditawarkan.';
		}
		
	}
	
	public function body(){
		$wtable = 1160;
		$bil = 45;
		$box = 50;
		$matrik = 90;
		$boxall = $box * 14;
		$percent = 45;
		$name = $wtable - $bil - $percent - $matrik - $boxall;
		
		$html ='
		<table cellpadding="2" border="1" width="'.$wtable.'">
		<thead>
		
		<tr style="background-color:#ebebeb">
			<td width="'.$bil.'" align="center" style="line-height: 250%;"><b>No.</b></td>
			<td width="'.$matrik.'"  style="line-height: 250%;"><b>  Matric No</b></td>
			<td width="'.$name.'" style="line-height: 250%;"><b>  Student Name</b></td>
			';

		
			$attendance = json_decode($this->model->attendance_header);
			if($attendance){
				foreach($attendance as $attend){
				$html .= '<td width="'.$box.'" style="line-height: 250%;" align="center"><b>'.date('d-m', strtotime($attend)) .'</b></td>';
				
				}
			}else{
			        $html .= '<td width="'.$box.'" style="line-height: 250%;" align="center"></td>';
			}
			
		
		$html .= '
		<td width="'.$percent.'" align="center" style="line-height: 250%;"><b>%</b></td></tr>
		</thead>
		';
		
		if($this->model->students){
			// if($this->response->student->result){
				$x = 1;
				//style="line-height: 150%;"
				foreach($this->model->students as $student){
						$html .= '
						<tr nobr="true">
						<td style="height: 27px;" width="'.$bil.'"  align="center">'.$x.'</td>
						<td width="'.$matrik.'">  '.$student->matric_no .'</td>
						<td width="'.$name.'" style="padding:9px;">
						<table>
						<tr>
						<td width="2%"></td><td width="98%">'.$student->student->st_name .'</td>
						</tr>
						</table>
						</td>
						';
						
						$attendance = [];
						if($student->attendance_check){
						    $attendance = json_decode($student->attendance_check);
						}
						
						$column = [1];
						if($this->model->attendance_header){
						    $column = json_decode($this->model->attendance_header);
						}
						
						$count_total = count($column);
						//echo $count_total; die();
						$count = 0;
						if($column){
						    foreach($column as $idx => $col){
						        if(array_key_exists($idx, $attendance)){
						            $attend = $attendance[$idx];
						            if($attend == 1){
						                $hadir = '<b style="font-size:14px;color:#1b3110"><span style="font-family:zapfdingbats;">3</span></b>';
						                $count++;
						            }else if($attend == -1){
						                $hadir = '';
						            }else{
						                $hadir = '';
						            }
						            
						            $html .= '<td width="'.$box.'" style="line-height: 250%;" align="center"><b>'.$hadir .'</b></td>';
						        }else{
						            $html .= '<td width="'.$box.'" style="line-height: 250%;" align="center"></td>';
						        }
						        
						    }
						    $percentage = ($count / $count_total)*100;
						    $html .= '<td style="height: 27px;" width="'.$bil.'"  align="center">'.round($percentage).'%</td></tr>';
						}
						
						
						
						/* if($attendance){
							$count = 0;
							foreach($attendance as $attend){
								// $res = $this->response->attend[$col->id]->students[$row->id]->status;
								// if(strtotime($col->date) <= time()){
									
								if($attend == 1){
									$hadir = '<b style="font-size:14px;color:#1b3110"><span style="font-family:zapfdingbats;">3</span></b>';
									$count++;
								}else if($attend == -1){
									$hadir = '';
								}else{
									$hadir = '';
								}
								
							$html .= '<td width="'.$box.'" style="line-height: 250%;" align="center"><b>'.$hadir .'</b></td>';
							
							}
							$percentage = ($count / 14)*100;
							$html .= '<td style="height: 27px;" width="'.$bil.'"  align="center">'.round($percentage).'%</td></tr>';
						}else{
							$column = json_decode($this->model->attendance_header);
							if($column){
								foreach($column as $col){
									$html .= '<td width="'.$box.'" style="line-height: 250%;" align="center"></td>';
								}
								$html .= '<td style="height: 27px;" width="'.$bil.'"  align="center"></td></tr>';
							}
						} */
						
					$x++;
				}
			// }
		}
	
		
		$html .= '</table>
		';
		
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
	}
	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('eFasi');
		$this->pdf->SetTitle('Overall Attendance');
		$this->pdf->SetSubject('Overall Attendance');
		$this->pdf->SetKeywords('');



		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$this->pdf->SetMargins(15, 40, 15);
		//$this->pdf->SetMargins(0, 0, 0);
		$this->pdf->SetHeaderMargin(10);
		//$this->pdf->SetHeaderMargin(0);

		 //$this->pdf->SetHeaderMargin(0, 0, 0);
		$this->pdf->SetFooterMargin(18);

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
		$this->pdf->AddPage("L");
		
		$this->pdf->curr_page = $this->pdf->getAliasNumPage();
		$this->pdf->total_page = $this->pdf->getAliasNbPages();
	}
	
	
}
