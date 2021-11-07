<?php

namespace backend\modules\courseFiles\models\pdf;

use Yii;
use common\models\Common;


class Clo
{
	public $model;
	public $course;
	public $semester;
	public $group;
	public $analysis_group = null;
	public $response;
	public $pdf;
	public $directoryAsset;
	public $assessment;
	public $listClo;
	
	public function generatePdf(){
			
			date_default_timezone_set("Asia/Kuala_Lumpur");
			// $this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
			
			$this->pdf = new CloStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
			$this->pdf->model = $this->model;
			$this->pdf->course = $this->course;
			$this->pdf->semester = $this->semester;
			$this->pdf->group = $this->group;
			$this->pdf->analysis_group = $this->analysis_group;
			
			$this->startPage();
			//$this->setHeader();
			$this->body();

			$this->pdf->Output('clo-analysis.pdf', 'I');
		
		
	}
	
	
	public function setHeader(){
		if($this->analysis_group == 1){
			$group = '(GROUP 1)';
		}else if($this->analysis_group == 2){
			$group = '(GROUP 2)';
		}else{
			$group = '';
		}
		$html ='
		<b>CLO ANALYSIS '.$group.'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<b>SEMESTER: </b>'. strtoupper($this->semester->fullFormat()).'
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>COURSE: </b>'.$this->course->course_code.' ('.$this->group.') - '.strtoupper($this->course->course_name).'
		<br />
		
		';
		
		$this->pdf->SetFont('arial', '', 8.5);
$tbl = <<<EOD
		$html
EOD;
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function body(){
		$kira_assess = count($this->assessment);
		$kira_clo = count($this->listClo);
		$total_col = $kira_assess + $kira_clo;
		$wtable = 1160;
		$bil = 45;
		
		$matrik = 95;
		$box_clo = 80;
		$clos = $box_clo * $kira_clo;
		$percent = 45;
		
		$name = $matrik * 3;
		$non_box_assesss = $bil + $matrik + $name + $clos;
		$all_box_assesss = $wtable - $non_box_assesss;
		$box_assess = $all_box_assesss / $kira_assess; 
		$w3 = $bil + $matrik + $name;
		
		$empty_clo = '';
					$header_clo = '';
					if($this->listClo){
						$empty_clo .= '<td colspan="'.$kira_clo.'" width="'.$clos.'"></td>';
                          foreach ($this->listClo as $clo) {
                            
							$header_clo .= '<td><span class="label label-primary">CLO'.$clo.'</span></td>';
                          }
                    }
		
		$html ='
		<table cellpadding="2" border="1" width="'.$wtable.'">
		 <tr align="center" style="line-height: 180%;background-color:#ebebeb">
            <td colspan="3" align="right" width="'.$w3.'"><strong>COURSE LEARNING OUTCOME</strong></td>';
					foreach ($this->assessment as $assess) {
                       $html .='<td width="'.$box_assess.'"><strong>CLO'.$assess->cloNumber.'</strong>
                        </td>';
                      }
                  $html .= $empty_clo;
                   $html .= '</tr> 
			<tr align="center" style="line-height: 180%;background-color:#ebebeb">
            <td colspan="3" align="right" width="'.$w3.'"><strong>WEIGHTAGE</strong></td>';
					foreach ($this->assessment as $assess) {
                       $html .='<td width="'.$box_assess.'"><strong>'.$assess->assessmentPercentage.'%</strong>
                        </td>';
                      }
                  $html .= $empty_clo;
                   $html .= '</tr> 
		<thead>
		
		<tr style="background-color:#ebebeb">

			<td width="'.$bil.'" align="center" style="line-height: 250%;"><b>NO.</b></td>
			<td width="'.$matrik.'"  style="line-height: 250%;"><b>  MATRIC NO.</b></td>
			<td width="'.$name.'" style="line-height: 250%;"><b> STUDENT NAME</b></td>
			';
			/* $attendance = json_decode($this->model->attendance_header);
			if($attendance){
				foreach($attendance as $attend){
				$html .= '<td width="'.$box.'" style="line-height: 250%;" align="center"><b>'.date('d-m', strtotime($attend)) .'</b></td>';
				
				}
			} */
			$cloSet = array();
			$weightage = array();
			if($this->assessment){
				foreach ($this->assessment as $assess) {
					$weightage[] = $assess->assessmentPercentage;
					$cloSet[] = $assess->cloNumber;
					$str = $assess->assess_name_bi;
					$html .= '<td width="'.$box_assess.'" style="line-height: 140%;" align="center"><b> '. $str .'</b></td>';
				}
			}
			

			
			if($this->listClo){
				foreach ($this->listClo as $clo) {
					$strtotal = 'clo'.$clo.'_total';
					$strcount = 'clo'.$clo.'_count';
					$$strtotal = 0;
					$$strcount = 0;
					$str = $assess->assess_name_bi;
					$html .= '<td width="'.$box_clo.'"  align="center" style="line-height: 250%;"><b>CLO'.$clo.'</b></td>';
				}
			}
			
		
		$html .= '
		</tr>
		</thead>
		';
		
		if($this->analysis_group == 1){
			$list_student = $this->model->studentGroup1;
		}else if($this->analysis_group == 2){
			$list_student = $this->model->studentGroup2;
		}else{
			$list_student = $this->model->students;
		}
		
		if($list_student){
			// if($this->response->student->result){
				$num = 1;
				//style="line-height: 150%;"
				foreach($list_student as $student){
						$html .= '
						<tr nobr="true">
						<td style="height: 27px;" width="'.$bil.'"  align="center">'.$num.'. </td>
						<td width="'.$matrik.'">  '.$student->matric_no .'</td>
						<td width="'.$name.'" style="padding:9px;">
						<table>
						<tr>
						<td width="2%"></td><td width="98%">'.$student->student->st_name .'</td>
						</tr>
						</table>
						</td>
						';
						 $result = json_decode($student->assess_result);
						if($this->assessment)
                            {
                              $x = 0;
                              foreach ($this->assessment as $assess) {
                                
                                if($result){
                                  if(array_key_exists($x, $result)){
                                    $mark = $result[$x];
                                    $html .= '<td align="center" width="'.$box_assess.'">'.number_format($mark,2).'</td>';
                                  }
                                  else{
                                    $html .= '<td></td>';
                                  }
                                  
                                }
                                else{
                                   $html .= '<td></td>';
                                }
                               
                                $x++;
                              }
                            }
							

                          if($this->listClo){
                            foreach ($this->listClo as $clo) {
                              $value = $this->cloValue($clo,$result,$cloSet);
                             $html .= '<td align="center" width="'.$box_clo.'">'.number_format($value,2).'</td>';

                              $strtotal = 'clo'.$clo.'_total';
                              $strcount = 'clo'.$clo.'_count';
                              
                              if(!empty($value)){
                                $$strcount++;
                              }
                              
                              $$strtotal += $value;


                            }
                          }
						
						$html .= '</tr>';
						
					$num++;
				}
			$colspan = 3 + $kira_assess;
			$html .= '<tr style="line-height: 180%;"><td  colspan="' .$colspan . ' " align="right"><b>AVERAGE</b></td>';
				  $weightage_html = '';
				  $percent = '';
				  $achievement = '';
				  $html_analysis = '';
                    if($this->listClo){
                      foreach ($this->listClo as $clo) {
                        $strtotal = 'clo'.$clo.'_total';
                        $strcount = 'clo'.$clo.'_count';
						$average = 0;
                        if($$strcount > 0){
                           $average = $$strtotal/$$strcount;
                           $html .= '<td align="center">'.number_format($average,2).'</td>';
                        }else{
                            $html .= '<td></td>';
                        }
						
						$value = $this->cloValue($clo,$weightage,$cloSet);
                        $weightage_html .= '<td align="center" >'.$value.'</td>';
						if($value == 0){
							$percentage = 0;
						}else{
							$percentage = $average / $value;
						}
						
						$percent .= '<td align="center">'.number_format($percentage,2).'</td>';
						$achieve = $percentage * 4;
						$achievement .= '<td align="center">'.number_format($achieve,2).'</td>';
						$analysis = $this->analysis($achieve);
						$html_analysis .= '<td align="center">'.$analysis.'</td>';
                       
                      }
                    }
                
                $html .= '</tr>
				<tr style="line-height: 180%;"><td  colspan="'. $colspan . ' "  align="right"><b>CLO WEIGHTAGE</b></td>';
				$html .=  $weightage_html;
                $html .= '</tr>
				<tr style="line-height: 180%;"><td colspan="' . $colspan . ' "  align="right"><b></b></td>';
				$html .=  $percent;
                $html .= '</tr>
				<tr style="line-height: 180%;"><td colspan=" ' . $colspan . '"  align="right"><b>STUDENT ACHIEVEMENT(0-4) *</b></td>';
				$html .=  $achievement;
                $html .= '</tr>
				
				<tr style="line-height: 180%;"><td colspan="' . $colspan . '"  align="right"><b>ACHIEVEMENT ANALYSIS **</b></td>';
				$html .=  $html_analysis;
                $html .= '</tr>';
		}
	
		
		$html .= '</table><div style="height:2px;">&nbsp;</div>
		<span style="font-size:12px;"> *Purata markah (jumlah markah/ bil. pelajar) dibahagikan dengan pemberat setiap HPK didarab dengan 4.0/ Average mark (total marks/no. of students) divided by weightage of each CLO multiplied by 4.0.<br />
 **0.00-0.99 (Sangat Lemah/ Very Poor), 1.00-1.99 (Lemah/ Poor), 2.00-2.99 (Baik/ Good), 3.00-3.69 (Sangat Baik/ Very Good), 3.70-4.00 (Cemerlang/ Excellent). </span>
		';
		
		$tbl = <<<EOD
		$html
EOD;
		
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
		$this->pdf->AddPage("L");
		
		$this->pdf->curr_page = $this->pdf->getAliasNumPage();
		$this->pdf->total_page = $this->pdf->getAliasNbPages();
	}
	
	
}
