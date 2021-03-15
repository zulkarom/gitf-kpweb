<?php

namespace backend\modules\esiap\models;

use Yii;
use common\models\Common;


class Tbl4Pdf
{
	public $model;
	public $pdf;
	public $html;
	public $directoryAsset;
	
	public $total_lec = 0;
	public $total_tut = 0;
	public $total_prac = 0;
	public $total_hour = 0;
	
	public $wtab = 660;
	public $colnum = 23;
	public $col_label = 98;
	public $col_content;
	public $font_size = 8;
	public $font_blue = 'color:#0070c0';
	
	/* $bgcolor = 'E7E6E6';
	$bgcolor_green = '548235';
	$bgcolor_dark = 'AEAAAA';
	$bgcolor_blue = '002060'; */
	
	public function generatePdf(){

		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new Tbl4PdfStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$this->pdf->SetFont("arialnarrow", '', 11);
		
		$this->setDocStyle();
		$this->writeHeaderFooter();
		
		$this->startPage();
		$this->courseName();
		/* $this->synopsis();
		$this->academicStaff();
		$this->semYear();
		$this->creditValue();
		$this->prerequisite();
		$this->clo();
		$this->mapping(); 
		$this->transferable();*/
		$this->sltColums();
		/* $this->sltHead();
		$this->sltSyllabus();  */
		$this->sltContAssessHead();
		$this->sltSumAssessHead();
		$this->sltSummary();
		$this->htmlWriting();
		

		$this->pdf->Output('TABLE 4 - '.$this->model->course->course_code .'.pdf', 'I');
	}
	
	public $shade_dark;
	public $shade_light;
	public $shade_green;
	public $shade_credit;
	public $border;
	public $sborder;
	public $border_top_left;
	public $border_right_left;
	public $border_top_right;
	public $border_top_bottom;
	public $border_not_top;
	public $border_not_bottom;
	public $border_bottom;
	public $border_left;
	public $border_right;
	public $border_left_bottom;
	public $border_right_bottom;
	public $wall;
	
	public function setDocStyle(){
		$this->shade_light = 'style="background-color:#e7e6e6; border: 1px solid #000000"';
		$this->shade_dark = 'style="background-color:#aeaaaa; border: 1px solid #000000"';
		$this->shade_credit = 'style="color:#FFFFFF;line-height:20px;font-weight:bold;background-color:#548235; border: 1px solid #000000"';
		$this->shade_green = 'style="color:#FFFFFF;font-weight:bold;background-color:#548235; border: 1px solid #000000"';
		$this->border = 'style="border: 1px solid #000000"';
		$this->sborder = 'border: 1px solid #000000';
		$this->border_top_left = 'style="border-top: 1px solid #000000;border-left: 1px solid #000000;"';
		$this->border_left = 'style="border-left: 1px solid #000000;"';
		$this->border_right = 'style="border-right: 1px solid #000000;"';
		$this->border_right_left = 'style="border-right: 1px solid #000000;border-left: 1px solid #000000;"';
		$this->border_top_right = 'style="border-top: 1px solid #000000;border-right: 1px solid #000000;"';
		
		$this->border_top_bottom = 'style="border-top: 1px solid #000000;border-bottom: 1px solid #000000"';
		$this->border_right_bottom = 'style="border-right: 1px solid #000000;border-bottom: 1px solid #000000"';
		$this->border_left_bottom = 'style="border-left: 1px solid #000000;border-bottom: 1px solid #000000"';
		$this->border_not_top = 'style="border-right: 1px solid #000000;border-left: 1px solid #000000;border-bottom: 1px solid #000000"';
		$this->border_not_bottom = 'style="border-right: 1px solid #000000;border-left: 1px solid #000000;border-top: 1px solid #000000"';
		$this->border_bottom = 'style="border-bottom: 1px solid #000000"';
	}
	
	
	
	
	public function writeHeaderFooter(){
		//$wtab = 180 + 450;
		//$this->wtab = $wtab;

		//$this->pdf->lineFooterTable = false;
	}
	
	public function courseName(){
		$this->pdf->lineFooterTable = true;
		$wtab = $this->wtab;
		$colnum = $this->colnum;
		$col_label = $this->col_label;
		$col_content = $wtab - $colnum - $col_label;
		$this->col_content = $col_content;
		$this->wall = $wtab - $colnum;
		$col1 = $col_content / 3;
		$col2 = $col1 * 2;
		$border = $this->border;


		if($this->model->course->classification){
			$class = $this->model->course->classification->class_name_bi;
		}else{
			$class = '';
		}

		$html = '<table border="0" width="'.$wtab.'" cellpadding="5">

		<tr>

		<td style="border: 1px solid #000000;line-height:1px" colspan="27"></td>
		</tr>

		<tr>
		<td width="'.$colnum.'" rowspan="3" align="center" '.$border.'>1</td>

		<td width="'.$col_label.'" colspan="3">Name of Course:</td>
		<td width="'.$col_content.'" colspan="23" '.$border.'>'. strtoupper($this->model->course->course_name_bi) . '</td>
		</tr>

		<tr>
		<td width="'.$col_label.'" '.$border.' colspan="3">Course Code: </td>
		<td width="'.$col_content.'" colspan="23" '.$border.'>'.$this->model->course->course_code .'</td>
		</tr>
		<tr>
		<td width="'.$col_label.'" '.$border.'  colspan="3">Course Classification: </td>
		<td width="'.$col1.'" colspan="7" '.$border.'>'.$class .'</td>
		<td width="'.$col2.'" colspan="16" '.$this->shade_light.'></td>
		</tr>


		';



		$this->html .= $html;



	}
	
	public function synopsis(){
		$html = '<tr>
		<td width="'.$this->colnum.'" align="center" '.$this->border.'>2</td>

		<td width="'.$this->col_label.'" colspan="3" '.$this->border.'>Synopsis:</td>
		<td width="'.$this->col_content.'" colspan="23" '.$this->border.'>'.$this->model->profile->synopsis_bi .'</td>
		</tr>';
		$this->html .= $html;

	}
	
	public function academicStaff(){
		$staff = $this->model->profile->academicStaff;
		$col_num_staff = 28;
		$col_name = $this->col_content - $col_num_staff;
		$rowspan =  count($staff );
		$html = '<tr>
		<td width="'.$this->colnum.'" align="center" '.$this->border.' rowspan="'. $rowspan .'" >3</td>

		<td width="'.$this->col_label.'" colspan="3" '.$this->border.' rowspan="'. $rowspan .'" >Name(s) of academic staff:</td>';


		if($staff){
			$i = 1;
			foreach($staff as $st){
				$td = '<td width="'.$col_num_staff.'"  '.$this->shade_light.' align="center">';
				$td .= $i;
				$td .= '</td>';
				$td .= '<td width="'.$col_name.'" colspan="22" '.$this->border.'>';
				$td .= $st->staff->niceName;
				$td .= '</td>';
				
				if($i == 1){
					$html .= $td . '</tr>';
				}else{
					$html .= '<tr>';
					$html .= $td;
					$html .= '</tr>';
				}
				$i++;
			}
		}

		$this->html .= $html;

	}
	
	public function semYear(){
		$col_sem = 70;
		$col_sem_num = 30;
		$col_year = 60;
		$col_year_num = 30;
		$col_sem_bal = $this->wtab - $this->colnum - $this->col_label - $col_sem - $col_sem_num - $col_year - $col_year_num;
		
		$html = '<tr>
		<td width="'.$this->colnum.'" align="center" '.$this->border.'>4</td>
		<td width="'.$this->col_label.'" '.$this->border.' colspan="3">Semester and Year Offered:</td>
		<td width="'.$col_sem.'" colspan="3" align="center" '.$this->border.'>Year Offered</td>
		<td width="'.$col_sem_num.'" '.$this->border.' align="center">';
		$offer_year = $this->model->profile->offer_year;
		if($offer_year == 0){
			$offer_year = '';
		}
		$html .= $offer_year;
		
		
		$html .= '</td>
		<td width="'.$col_year.'" align="center" '.$this->border.'>Semester</td>
		<td width="'.$col_year_num.'" '.$this->border.' align="center">';
		$offer_sem = $this->model->profile->offer_sem;
		if($offer_sem == 0){
			$offer_sem = '';
		}
		$html .= $offer_sem;
		
		$html .= '</td>
		<td width="'.$col_sem_bal.'" colspan="16" '.$this->border.'>Remarks: '.$this->model->profile->offer_remark.'</td>
		</tr>';
		$this->html .= $html;
	}
	
	public function creditValue(){
		$col_credit = 70;
		$col_bal = $this->col_content - $col_credit;
		$html = '<tr>
		
		<td width="'.$this->colnum.'" '.$this->border.' align="center">5</td>
		<td width="'.$this->col_label.'" '.$this->border.' colspan="3">Credit Value:</td>
		<td width="'.$col_credit.'" colspan="3" align="center" '.$this->shade_credit.'>'.$this->model->course->credit_hour .'</td>
		<td width="'.$col_bal.'" colspan="20" '.$this->shade_light.'></td>
		
		</tr>';
		$this->html .= $html;
	}
	
	public function prerequisite(){
		$pre = $this->model->profile->coursePrerequisite;
		$html = '<tr>
<td width="'.$this->colnum.'" align="center" '.$this->border.'>6</td>

<td width="'.$this->col_label.'" colspan="3" '.$this->border.'>Prerequisite/co-requisite (if any):</td>
<td width="'.$this->col_content.'" colspan="23" '.$this->border.'>'.$pre[1].'</td>
</tr>';
	$this->html .= $html;
	

	}
	
	public $total_clo;
	
	public function clo(){
		$kira = count($this->model->clos);
		$arr_clo = array();
		if($this->model->clos){
			foreach($this->model->clos as $clo){
				$arr_clo[] = $clo;
			}
		}
		$total = $kira > 8 ? $kira : 8;
		$this->total_clo = $total;
		$col_last = 28;
		$col_clo_num = 60;
		$col_bal = $this->col_content - $col_last;
		$col_rest = $this->col_content - $col_last - $col_clo_num;
		$rowspan_number =  $total + 1;
		$rowspan_clo =  $total ;
		
		
		$html = '<tr style="line-height:1%">
		<td width="'.$this->colnum.'" align="center" '.$this->border_top_left .'></td>
		<td width="'.$this->col_label.'" colspan="3" '.$this->border_top_bottom.'></td>
		<td width="'.$col_bal.'" colspan="22" '.$this->border_top_bottom.'></td>
		<td width="'.$col_last.'" '.$this->border_top_right .'></td>
		</tr>';
		
		$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
		
		$html .= '<tr>
		<td width="'.$this->colnum.'" align="center" '.$this->border_left_bottom .' rowspan="'. $rowspan_number .'">7</td>
		<td width="'.$this->col_label.'" rowspan="'.$rowspan_clo.'" colspan="3" '.$this->border .' align="center">Course Learning Outcomes (CLO)<br /><br />
		<img src="cloinfo.png" width="35" />
		</td>';
		
		////
		if(array_key_exists(0, $arr_clo)){
			$clo = $arr_clo[0];
			$html .= '<td colspan="2" width="'.$col_clo_num.'" align="center">CLO1</td>';
			$html .= '<td width="'.$col_rest.'" colspan="2" '.$this->border .'>'.$clo->clo_text_bi .' '.$clo->taxoPloBracket.'</td>';
		}else{
			$html .= '<td colspan="2" width="'.$col_clo_num.'"></td>';
			$html .= '<td width="'.$col_rest.'" colspan="2" '.$this->border .'></td>';
		}
		
		///
		
		$html .= '<td width="'.$col_last.'" '.$this->border_right_left .'></td>
		</tr>';
		
		
		
		
		$start =  1;
		
		for($i=1;$i<=$total;$i++){
			
			$index = $i - 1;
			$row =  + $i;
			if(array_key_exists($index, $arr_clo)){
				$html .= $this->cloItem($row, $i, $arr_clo[$index],$col_rest, $col_last, $col_clo_num);
			}else{
				$html .= $this->cloItem($row, $i, '', $col_rest, $col_last, $col_clo_num);
			}
			
		}
		
		
		
		$html .= '<tr style="line-height:1%">
		
		<td width="'.$this->col_label.'" colspan="3" '.$this->border_top_bottom .'></></td>
		<td width="'.$col_bal.'" colspan="22" '.$this->border_bottom .'></></td>
		<td width="'.$col_last.'" '.$this->border_right_bottom .'></></td>
		</tr>';
		
		
		$this->html .= $html;
	}
	
	public $clo_plo_html = '';
	
	public function cloItem($row, $clonumber, $clo, $col_rest, $col_last, $col_clo_num){
		
		$html = '';
		$this->clo_plo_html .= '<tr>
		
		<td align="center" '.$this->border_right_left.'></td>';
		
		$border = $this->border;
		$text = '';
		$clo_n = '';
		if($clonumber > 1){
			if($clonumber > 5 and $clo == ''){
				$border = $this->shade_dark;
			}
			if($clo){
				$text = $clo->clo_text_bi .' '.$clo->taxoPloBracket;
			}
			$html .= '<tr>';
			$html .= '<td colspan="2" width="'.$col_clo_num.'" '.$border .' align="center">CLO'.$clonumber.'</td>';
			$html .= '<td width="'.$col_rest.'" colspan="20" '.$this->border .'>'.$text.'</td>
			<td width="'.$col_last.'" '.$this->border_right_left .'></td>
			</tr>';
		}
		
		if($clo){
			$clo_n = 'CLO'.$clonumber;
		}
		
		$this->clo_plo_html .= '<td align="center" style="'.$border.';line-height:90%">'.$clo_n.'</td>';
		for($e=1;$e<=12;$e++){
			$plo_str = 'PLO'.$e;
			$this->clo_plo_html .='<td align="center" '.$border.'>';
			if($clo){
				if($clo->{$plo_str} == 1){
					$this->clo_plo_html .= '<span style="font-size:14px;"><span>√</span></span>';
				}
			}
			
			$this->clo_plo_html .= '</td>';
		}

		
		$s=1;
		$teach = '';
			if($clo){
				if($clo->cloDeliveries){
				foreach($clo->cloDeliveries as $row){
					$comma = $s == 1 ? '':', ';
					$teach .= $comma.$row->delivery->delivery_name_bi ;
				$s++;
				}
				}
			}
		$this->clo_plo_html .= '<td '.$border.'>'.$teach.'</td>';
		
		$assess = '';
		if($clo){
			if($clo->cloAssessments){
			$s=1;
			foreach($clo->cloAssessments as $row){
				if($row->assessment){
					$comma = $s == 1 ? '':', ';
					$assess  .= $comma.$row->assessment->assess_name_bi ;
				}
			$s++;
			}
			}
		}
		

		$this->clo_plo_html .= '<td '.$border.'>'.$assess.'</td>';
		
		$this->clo_plo_html .= '<td align="center" '.$this->border_right_left.'></td>
		</tr>';
		
		return $html;
		
	}
	
	public function mapping(){
	$wall = $this->wall;
	$col_first = 10;
	$col_last = 9;
	$col_clo = 80;
	$col_unit = 27;
	$col_plo_label = ($col_unit * 12);
	$col_teach_assess = $wall - $col_first - $col_clo - $col_plo_label - $col_last;
	$col_teach_assess = $col_teach_assess / 2;
	$col_learning =  $col_teach_assess;
	$col_assess = $col_teach_assess;
	$rowspan1 = $this->total_clo + 7;
	
	
	$html = '<tr>
<td width="'.$this->colnum.'" align="center" '.$this->border.' rowspan="'.$rowspan1.'">8</td>

<td width="'.$wall.'" colspan="26" '.$this->border_not_bottom.'>Mapping of the Course Learning Outcomes to the Programme Learning Outcomes, Teaching Methods and Assessment Methods.
<br />
</td>
</tr>';

$html .= '<tr>

<td width="'.$col_first.'" align="center" '.$this->border_right_left.'></td>
<td width="'.$col_clo.'" align="center" '.$this->shade_light.' rowspan="2">Course Learning Outcomes</td>
<td width="'.$col_plo_label.'" align="center" '.$this->shade_light.' colspan="12">Programme Learning Outcomes (PLO)</td>
<td width="'.$col_learning.'" align="center" '.$this->shade_light.' rowspan="2">Teaching Methods</td>
<td width="'.$col_assess.'" align="center" '.$this->shade_light.' rowspan="2">Assessment Methods</td>
<td width="'.$col_last.'" colspan="26" '.$this->border_right_left.'></td>
</tr>';



$html .= '<tr>

<td width="'.$col_first.'" align="center" '.$this->border_right_left.'></td>';
for($i=1;$i<=12;$i++){
	$params = $this->pdf->serializeTCPDFtagParameters(['PLO'. $i]);
	$html .= '<td width="'.$col_unit.'" '.$this->shade_light.'>';
	if($i<12){
		$html .= '<tcpdf method="textRotate" params="'.$params.'" />';
	}
	
	$html .='</td>';
}

$html .= '<td width="'.$col_last.'" '.$this->border_right_left.'></td>
</tr>';

//MQF
$html .= $this->clo_plo_html;

for($q=1;$q<=3;$q++){
	$rowspan='';
	
	$html .= '<tr nobr="true">';
	$html .= '	<td align="center" '.$this->border_right_left.' ></td>';
	$others = '';
	if($q == 1){
		$html .= '<td align="center" '.$this->shade_light.' rowspan="3">
		Mapping with MQF Cluster of Learning Outcomes</td>';
		$others = '<td align="center" '.$this->shade_light.' rowspan="3"></td>
		<td align="center" '.$this->shade_light.' rowspan="3"></td>';
	}
	$arr = ['C1','C2', 'C3A', 'C3B', 'C3C', 'C3D', 'C3E', 'C3F', 'C4A', 'C4B', 'C5'];

	for($e=1;$e<=12;$e++){
		$html .='<td align="center" style="'.$this->sborder.';line-height:90%">';
		$idx = $e - 1;
		if($idx < 11 and $q == 1){
			$html .= $arr[$idx];
		}
		
		$html .= '</td>';
	}
	
	$html .= $others;
	$html .= '<td align="center" '.$this->border_right_left.'></td>
	</tr>
	';
}

$wd = $wall - $col_first;
$html .= '<tr>

<td width="'.$col_first.'"  '.$this->border_left_bottom.'></td>
<td width="'.$wd.'" colspan="25" '.$this->border_right_bottom.'>
<br />
<br />
Indicate the primary causal link between the CLO and PLO by ticking  \'√\' in the appropriate box.<br />
<span style="'. $this->font_blue.'"><b>C1</b> = Knowledge & Understanding, <b>C2</b> = Cognitive Skills, <b>C3A</b> = Practical Skills, <b>C3B</b> = Interpersonal Skills, <b>C3C</b> = Communication Skills, <b>C3D</b> = Digital Skills,<br />
<b>C3E</b> = Numeracy Skills, <b>C3F</b> = Leadership, Autonomy & Responsibility, <b>C4A</b> = Personal Skills, <b>C4B</b> = Entrepreneurial Skills, <b>C5</b> = Ethics & Professionalism</span>
</td>
</tr>';
	$this->html .= $html;

	}
	
	public function transferable(){
		$wall = $this->wall;
		$col_label = $this->col_label + 70;;
		$col_num = 28;
		$col_last = 50;
		$col_content = $wall - $col_label - $col_last - $col_num;
		
		$transferables = $this->model->profile->transferables;
		$kira = count($transferables);
		$total = $kira > 3 ? $kira : 3;
		$arr_transfer = array();
		$x = 1;
		if($transferables){
			foreach($transferables as $transfer){
				$arr_transfer[$x] = $transfer->transferable->transferable_text_bi;
				$x++;
			}
		
		}
		$rowspan_num = $total + 4;
		$rowspan_desc = $total + 2;

	$html = '<tr>
<td width="'.$this->colnum.'" align="center" '.$this->border.' rowspan="'.$rowspan_num.'">9</td>
<td width="'.$wall.'" colspan="26" '.$this->border_not_bottom.'>Transferable Skills (if applicable)
</td>
</tr>';

$html .= '<tr>
<td width="'.$col_label.'" colspan="6" '.$this->border_right_left.' rowspan="'.$total.'"><i>(Skills learned in the course of study which can be useful and utilized in other settings)</i></td>
<td width="'.$col_num.'" '.$this->shade_light.' align="center">1</td>
<td width="'.$col_content.'" '.$this->border.' colspan="17">';

if(array_key_exists(1, $arr_transfer)){
	$html .= $arr_transfer[1];
}

$html .='</td>
<td width="'.$col_last.'" '.$this->border_right_left.' colspan="17"></td>
</tr>';

for($i=1;$i<=$total;$i++){
	if($i > 1){
		$html .= '<tr>
		<td width="'.$col_num.'" '.$this->shade_light.' align="center">'.$i.'</td>
		<td width="'.$col_content.'" '.$this->border.' colspan="17">';
		if(array_key_exists($i, $arr_transfer)){
			$html .= $arr_transfer[$i];
		}
		$html .= '</td><td width="'.$col_last.'" '.$this->border_right_left.' colspan="17"></td>
		</tr>';
	}
}

$span = $col_num + $col_content;
$html .= '<tr style="line-height:6px">
		<td width="'.$col_label.'" colspan="6" '.$this->border_left.'></td>
		<td width="'.$span.'"  colspan="18">Open-ended response (if any)';
		$html .= '</td><td width="'.$col_last.'" '.$this->border_right.' colspan="17"></td>
		</tr>';
//open 
$trans_text = $this->model->profile->transfer_skill_bi;
$html .= '<tr>
		<td width="'.$col_label.'" colspan="6" '.$this->border_right_left.'></td>
		<td width="'.$col_num.'" '.$this->shade_light.' align="center">'.$i.'</td>
		<td width="'.$col_content.'" '.$this->border.' colspan="17">'.$trans_text;

		$html .= '</td><td width="'.$col_last.'" '.$this->border_right_left.' colspan="17"></td>
		</tr>';

	$html .= '<tr style="line-height:6px">
<td width="'.$wall.'" colspan="26" '.$this->border_not_top.'> 
</td>
</tr>';

$this->html .= $html;
	}
	
	public	$col_topic ;
	public	$col_clo;
	public	$col_learning ;
	public	$col_total_slt;
	public	$col_last ;
	public	$col_f2f ;
	public	$col_nf2f;
	public	$col_phy_online;
	public	$col_unit;
	public	$col_first;
	public $col_subtotal;
	public $col_week;
	public $col_topic_text;
	
	public function sltColums(){
		$wall = $this->wall;
		$this->col_topic = 225;
		$this->col_clo = 35;
		$this->col_learning = 300;
		$this->col_total_slt = 48;
		$this->col_last = 15;
		$this->col_f2f = 225;
		$this->col_nf2f = $this->col_learning - $this->col_f2f;
		$this->col_phy_online = $this->col_f2f / 2;
		$this->col_unit = $this->col_phy_online / 4;
		$this->col_first = $wall - $this->col_topic - $this->col_clo - $this->col_learning - $this->col_total_slt - $this->col_last;
		$this->col_subtotal = $this->col_topic + $this->col_clo + $this->col_learning;
		
		$this->col_week = 27;
		$this->col_topic_text = $this->col_topic - $this->col_week ;
	}
	
	public function sltHead(){
		
		
		$rowspan_topic = 4;
		$style_head = 'style="background-color:#e7e6e6; border: 1px solid #000000;line-height:9"';
		
		$html = '<tr>
		<td width="'.$this->colnum.'" align="center" '.$this->border.'>10</td>
		<td width="'.$this->wall.'" colspan="26" '.$this->border .'>Distribution of Student Learning Time (SLT)
		<br />Note: This SLT calculation is designed for home grown programme only.
		<br />
		</td>
		</tr>';
		
		
		$html .= '<tr align="center">
		<td width="'.$this->colnum.'" align="center" '.$this->border.'></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_topic.'" '.$style_head .' colspan="7" rowspan="'.$rowspan_topic.'">Course Content Outline and Subtopics</td>
		<td width="'.$this->col_clo.'" '.$style_head.' colspan="2" rowspan="'.$rowspan_topic.'">CLO*</td>
		<td width="'.$this->col_learning.'" '.$this->shade_light.' colspan="11">Learning and Teaching Activities**</td>
		<td width="'.$this->col_total_slt.'" '.$style_head.' colspan="3" rowspan="'.$rowspan_topic.'">Total SLT</td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		
		$html .= '<tr align="center">
		<td width="'.$this->colnum.'" align="center" '.$this->border.'></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>


		<td width="'.$this->col_f2f.'" '.$this->shade_light.' colspan="8">Face-to-Face (F2F)</td>
		<td width="'.$this->col_nf2f.'" '.$this->shade_light.' colspan="3" rowspan="3">NF2F
	Independent Learning
	(Asynchronous)</td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		
		$html .= '<tr align="center">
		<td width="'.$this->colnum.'" align="center" '.$this->border.'></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>


		<td width="'.$this->col_phy_online.'" '.$this->shade_light.' colspan="4">Physical</td>
		<td width="'.$this->col_phy_online.'" '.$this->shade_light.' colspan="4">Online/ Technology-mediated (Synchronous)</td>
		
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		
		$html .= '<tr align="center">
		<td width="'.$this->colnum.'" align="center" '.$this->border.'></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>


		<td width="'.$this->col_unit.'" '.$this->shade_light.'>L</td>
		<td width="'.$this->col_unit.'" '.$this->shade_light.'>T</td>
		<td width="'.$this->col_unit.'" '.$this->shade_light.'>P</td>
		<td width="'.$this->col_unit.'" '.$this->shade_light.'>O</td>
		<td width="'.$this->col_unit.'" '.$this->shade_light.'>L</td>
		<td width="'.$this->col_unit.'" '.$this->shade_light.'>T</td>
		<td width="'.$this->col_unit.'" '.$this->shade_light.'>P</td>
		<td width="'.$this->col_unit.'" '.$this->shade_light.'>O</td>
		
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		
		

		$this->html .= $html;
		
	}
	
	public $sub_total_syll = 0;
	
	public function sltSyllabus(){
		if($this->model->syllabus ){
			$week_num = 1;
			foreach($this->model->syllabus as $row){
				if($row->duration > 1){
					$end = $week_num + $row->duration - 1;
					$show_week = $week_num . '<br/>-<br />' . $end;
				}else{
					$show_week = $week_num;
				}
				$week_num = $week_num + $row->duration;
			$arr_all = json_decode($row->topics);
			$topic = '';
			if($arr_all){
				$i = 1;
				$topic .= '<table><tr><td width="93%">';
				foreach($arr_all as $rt){
					$wk = $i == 1 ? $row->week_num . ".  " : '';
					$br = $i == 1 ? '' : "<br />";
					$topic .= $br . $rt->top_bi;
					
					if($rt->sub_topic){
					$topic .= '<br/><table>';
						foreach($rt->sub_topic as $rst){
						$topic .='<tr><td width="5%">- </td><td width="95%">' . $rst->sub_bi . '</td></tr>';
						}
					$topic .='</table>';
					}
				$i++;
				}
				$topic .= '</td></tr></table>';
			}
			
			$clo = json_decode($row->clo);
			$clo_str="";
			if($clo){
				$kk=1;
				foreach($clo as $clonum){
					$comma = $kk == 1 ? "" : "<br />";
					$clo_str .= $comma. 'CLO'.$clonum;
					$kk++;
				}
			}
			
			$numbers = [$row->pnp_lecture, $row->pnp_tutorial, $row->pnp_practical, $row->pnp_others, 
			$row->tech_lecture, $row->tech_tutorial, $row->tech_practical, $row->tech_others, 
			$row->independent];
			$this->sub_total_syll += array_sum($numbers);
			
			$this->sltSyllabusItem($show_week, $topic, $clo_str, $numbers);
			
				
		}
		}
		
		
		$html = '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_subtotal.'" '.$this->border .' align="right" colspan="20"><b>SUB-TOTAL SLT:</b></td>
		
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center">'.$this->sub_total_syll.'</td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		$this->html .= $html;
		
	}
	
	
	
	public function sltSyllabusItem($show_week, $topic, $clo_str, $numbers){
		
		
		$html = '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_week.'" '.$this->border .' align="center">'.$show_week.'</td>
		<td width="'.$this->col_topic_text.'" '.$this->border .' colspan="6">'.$topic.'</td>
		<td width="'.$this->col_clo.'" '.$this->border.' colspan="2" align="center">'.$clo_str.'</td>

		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[0].'</td>
		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[1].'</td>
		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[2].'</td>
		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[3].'</td>
		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[4].'</td>
		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[5].'</td>
		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[6].'</td>
		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[7].'</td>
		
		<td width="'.$this->col_nf2f.'" '.$this->border.' colspan="3" align="center">'.$numbers[8].'</td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_light.' colspan="3"></td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		$this->html .= $html;
	}
	
	public $total_cont_assess = 0;
	
	public function sltContAssessHead(){
		$rowspan_topic = 3;
		$style_head = 'style="background-color:#e7e6e6; border: 1px solid #000000;line-height:5"';
		

		
		$html = '<tr align="center">
		<td width="'.$this->colnum.'" align="center" '.$this->border.'></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_topic.'" '.$style_head .' colspan="7" rowspan="2">Continous Assessement</td>
		<td width="'.$this->col_clo.'" '.$style_head.' colspan="2" rowspan="2">%</td>

		<td width="'.$this->col_f2f.'" '.$this->shade_light.' colspan="8">Face-to-Face (F2F)</td>
		<td width="'.$this->col_nf2f.'" '.$this->shade_light.' colspan="3" rowspan="2">NF2F
	Independent Learning
	(Asynchronous)</td>
	<td width="'.$this->col_total_slt.'" '.$style_head.' colspan="3" rowspan="2"></td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		
		
		
		$html .= '<tr align="center">
		<td width="'.$this->colnum.'" align="center" '.$this->border.'></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>


		<td width="'.$this->col_phy_online.'" '.$this->shade_light.' colspan="4">Physical</td>
		<td width="'.$this->col_phy_online.'" '.$this->shade_light.' colspan="4">Online/ Technology-mediated (Synchronous)</td>
		
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		$this->html .= $html;
		
		
		if($this->model->courseAssessmentFormative){
			$i = 1;
			foreach($this->model->courseAssessmentFormative as $rf){
					$per = $rf->as_percentage + 0;
					$f2f = $rf->assess_f2f;
					$tech = $rf->assess_f2f_tech;
					$nf2f = $rf->assess_nf2f;
					$numbers = [$f2f, $tech, $nf2f];
					$this->total_cont_assess += array_sum($numbers);
					$name = $rf->assess_name_bi;
					$this->sltAssessItem($i, $name, $per, $numbers);
			$i++;
			}
		}else{
			$data = ['','',''];
			$this->sltAssessItem(1, '', '', $data);
		}
		
		$html = '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_subtotal.'" '.$this->border .' align="right" colspan="20"><b>SUB-TOTAL SLT:</b></td>
		
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center">'.$this->total_cont_assess.'</td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';

		
		$this->html .= $html;
	}
	
	public $total_sum_assess = 0;
	
	public function sltSumAssessHead(){
		$rowspan_topic = 3;
		$style_head = 'style="background-color:#e7e6e6; border: 1px solid #000000;line-height:5"';
		

		
		$html = '<tr align="center">
		<td width="'.$this->colnum.'" align="center" '.$this->border.'></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_topic.'" '.$style_head .' colspan="7" rowspan="2">Final Assessement</td>
		<td width="'.$this->col_clo.'" '.$style_head.' colspan="2" rowspan="2">%</td>

		<td width="'.$this->col_f2f.'" '.$this->shade_light.' colspan="8">Face-to-Face (F2F)</td>
		<td width="'.$this->col_nf2f.'" '.$this->shade_light.' colspan="3" rowspan="2">NF2F
	Independent Learning
	(Asynchronous)</td>
	<td width="'.$this->col_total_slt.'" '.$style_head.' colspan="3" rowspan="2"></td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		
		
		
		$html .= '<tr align="center">
		<td width="'.$this->colnum.'" align="center" '.$this->border.'></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>


		<td width="'.$this->col_phy_online.'" '.$this->shade_light.' colspan="4">Physical</td>
		<td width="'.$this->col_phy_online.'" '.$this->shade_light.' colspan="4">Online/ Technology-mediated (Synchronous)</td>
		
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		$this->html .= $html;
		
		
		if($this->model->courseAssessmentSummative){
			$i = 1;
			foreach($this->model->courseAssessmentSummative as $rf){
					$per = $rf->as_percentage + 0;
					$f2f = $rf->assess_f2f;
					$tech = $rf->assess_f2f_tech;
					$nf2f = $rf->assess_nf2f;
					$numbers = [$f2f, $tech, $nf2f];
					$this->total_sum_assess += array_sum($numbers);
					$name = $rf->assess_name_bi;
					$this->sltAssessItem($i, $name, $per, $numbers);
			$i++;
			}
		}else{
			$data = ['','',''];
			$this->sltAssessItem(1, '', '', $data);
		}
		
		$html = '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_subtotal.'" '.$this->border .' align="right" colspan="20"><b>SUB-TOTAL SLT:</b></td>
		
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center">'.$this->total_sum_assess.'</td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';

		
		$this->html .= $html;
	}
	
	public function sltSummary(){
		$col_summary = $this->col_subtotal - $this->col_week;
		$total_slt_assess = $this->total_cont_assess + $this->total_sum_assess;
		$html = '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_subtotal.'" '.$this->border .' align="right" colspan="20"><b>SLT for Assessment:</b></td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center">'.$total_slt_assess.'</td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		$grand_total_slt = $total_slt_assess + $this->sub_total_syll;
		$html .= '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_subtotal.'" '.$this->border .' align="right" colspan="20"><b>GRAND TOTAL SLT:</b></td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center">'.$grand_total_slt.'</td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		
		$html .= '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_week.'" '.$this->border.' align="center">A</td>
		<td width="'.$col_summary.'" '.$this->border .' align="right" colspan="20">% SLT for F2F Physical Component:<br />
		<span style="'.$this->font_blue.'">[Total F2F Physical /(Total F2F Physical + Total F2F Online + Total Independent Learning) x 100)]</span>
		</td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center"></td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		
		$html .= '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_week.'" '.$this->border.' align="center">B</td>
		<td width="'.$col_summary.'" '.$this->border .' align="right" colspan="20">% SLT for Online & Independent Learning Component:<br />
		<span style="'.$this->font_blue.'">[(Total F2F Online + Total Independent Learning) /( Total F2F Physical + Total F2F Online + Total Independent Learning) x 100]</span>
		</td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center"></td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		
		$html .= '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_week.'" '.$this->border.' align="center">C</td>
		<td width="'.$col_summary.'" '.$this->border .' align="right" colspan="20">% SLT for All Practical Component:<br />
		<span style="'.$this->font_blue.'">[% F2F Physical Practical + % F2F Online Practical]</span>
		</td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center"></td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		
		$html .= '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_week.'" '.$this->border.' align="center">C1</td>
		<td width="'.$col_summary.'" '.$this->border .' align="right" colspan="20">% SLT for F2F Physical Practical Component:<br />
		<span style="'.$this->font_blue.'">[Total F2F Physical Practical /( Total F2F Physical + Total F2F Online + Total Independent Learning)  x 100)]</span>
		</td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center"></td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		
		$html .= '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_week.'" '.$this->border.' align="center">C2</td>
		<td width="'.$col_summary.'" '.$this->border .' align="right" colspan="20">% SLT for F2F Online Practical Component:<br />
		<span style="'.$this->font_blue.'">[Total F2F Online Practical / (Total F2F Physical + Total F2F Online + Total Independent Learning) x 100]</span>
		</td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center"></td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		
		$html .= '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->wall.'" '.$this->border.' colspan="25"></td>
		
		</tr>';
		
		$html .= '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_subtotal.'" '.$this->border .' colspan="20">Please  tick (√) if this course is Industrial Industrial Training/ Clinical Placement/ Practicum using 50% of Effective Learning Time (ELT)</td>
		<td width="'.$this->col_total_slt.'" '.$this->border.' colspan="3" align="center"></td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		$col_note = $this->col_subtotal + $this->col_total_slt;
		$html .= '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$col_note.'" '.$this->border .' colspan="21">Note:<br />
		* Indicate the CLO based on the CLO\'s numbering in Item 8<br />
		** For ODL programme: Courses with mandatory practical requiremnets imposed by the programme standards or any related standards can be exempted from complying to the minimum 80% ODL delivery rule in the SLT.
		
		</td>
	
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';

		
		$this->html .= $html;
	}
	
	public function sltAssessItem($i, $name, $per, $numbers){
		$html = '<tr>
		<td width="'.$this->colnum.'" '.$this->border.' ></td>
		<td width="'.$this->col_first.'" '.$this->border.'></td>
		<td width="'.$this->col_week.'" '.$this->border .' align="center">'.$i.'</td>
		<td width="'.$this->col_topic_text.'" '.$this->border .' colspan="6">'.$name.'</td>
		<td width="'.$this->col_clo.'" '.$this->border.' colspan="2" align="center">'.$per.'</td>
		<td width="'.$this->col_phy_online.'" '.$this->border.' align="center" colspan="4">'.$numbers[0].'</td>
		<td width="'.$this->col_phy_online.'" '.$this->border.' align="center" colspan="4">'.$numbers[1].'</td>
		<td width="'.$this->col_nf2f.'" '.$this->border.' colspan="3" align="center">'.$numbers[2].'</td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_light.' colspan="3"></td>
		<td width="'.$this->col_last.'" '.$this->border.' colspan="2"></td>
		</tr>';
		$this->html .= $html;
	}

	
	public function doBody(){
$col_wide = $wtab - $colnum;
$html_clo = '';
$col_assess = 88;
$col_unit = 32;
$col_unit2 = 36.5;
$col_learning = $col_content - $col_assess - ($col_unit * 9) - ($col_unit2 * 3);
$col_plo_label = ($col_unit * 9) + ($col_unit2 * 3);

///////////////////////// plo ////////////////////////

$html_plo= '';
if($this->model->clos){
	$clo_row = count($this->model->clos) + 7;
	$i=1;
	foreach($this->model->clos as $c){
	$html_plo .= '<tr>
<td width="'.$col_label.'" '.$style_shade.' align="center">CLO '.$i.'</td>';

for($e=1;$e<=12;$e++){
	$plo_str = 'PLO'.$e;
	$html_plo .='<td align="center" '.$border.'>';
	if($c->{$plo_str} == 1){
		$html_plo .= '<span style="font-size:14px;"><span>√</span></span>';
	}
	$html_plo .= '</td>';
}

$html_plo .= '<td '.$border.'>';

$s=1;
if($c->cloDeliveries){
$html_plo .='<table border="0">';
foreach($c->cloDeliveries as $row){
	$html_plo .= '<tr>';
	$html_plo .= '<td>';
	$html_plo .= $row->delivery->delivery_name_bi ;
	$html_plo .= '</td>';
	$html_plo .= '</tr>';
$s++;
}
$html_plo .='</table>';
}
$html_plo .='</td><td '.$border.'>';

if($c->cloAssessments){
$html_plo .='<table border="0">';
foreach($c->cloAssessments as $row){
	$html_plo  .= '<tr>';
	$html_plo  .= '<td>';
	if($row->assessment){
		$html_plo  .= $row->assessment->assess_name_bi ;
	}
	
	$html_plo  .= '</td>';
	$html_plo  .= '</tr>';
}
$html_plo  .='</table>';
}


$html_plo .='</td>


</tr>';
	$i++;	
	}
}else{
	$clo_row = 8;
	$html_plo .= '<tr>
<td width="'.$col_label.'" '.$style_shade.' align="center">CLO 1</td>
<td width="'.$col_content.'" colspan="14" '.$border.'></td>
</tr>';

}
$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center" rowspan="'.$clo_row.'">8. </td>

<td width="'.$col_wide.'" colspan="15" '.$style_shade.'>
Mapping of the Course Learning Outcomes to the Programme Learning Outcomes, Teaching Methods and Assessment :<br />
Please select the Learning Outcome Domain (LOD) for each PLO in the cells above it. E.g. PLO1 - Knowledge, PLO2 - Cognitive, PLO3 - Practical Skills

</td>
</tr>';

$html .= '
<tr>
<td width="'.$col_label.'" '.$style_shade.' align="center" rowspan="3"><b>Course Learning Outcomes (CLO)</b></td>
<td width="'.$col_plo_label.'" align="center" colspan="12" '.$style_shade.'><b>Programme Learning Outcomes (PLO)</b></td>
<td width="'.$col_learning.'" rowspan="3" align="center" '.$style_shade.'><b>Learning and Teaching Method</b></td>
<td width="'.$col_assess.'" rowspan="3" align="center" '.$style_shade.'><b>Assessment Method</b></td>
</tr>


<tr>';

$vert = $this->model->versionType;

for($i=1;$i<=9;$i++){
	$pattr = 'plo' .$i. '_bi';
	$html .= '<td width="'.$col_unit.'" style="font-size:8px; border:1px solid #000000">'.$vert->{$pattr}.'</td>';
}
//make separate due to width difference
for($i=10;$i<=12;$i++){
	$pattr = 'plo' .$i. '_bi';
	$html .= '<td width="'.$col_unit2.'" style="font-size:8px; border:1px solid #000000">'.$vert->{$pattr}.'</td>';
}
$html .='</tr>


<tr>';
//row PLO NUMBER
for($i=1;$i<=9;$i++){
	$html .= '<td align="center" '.$border.'><b>PLO'.$i.'</b></td>';
}

for($i=10;$i<=12;$i++){
	$html .= '<td align="center" '.$border.'><b>PLO'.$i.'</b></td>';
}
$html .='</tr>

';
$html .= $html_plo;

$html .= '<tr>
<td width="'.$col_wide.'" colspan="15" style="border-right:1px solid #000000">

</td>
</tr>
<tr>
<td width="'.$col_wide.'" colspan="15" style="border-right:1px solid #000000">
<i>Indicate the relevancy between the CLO and PLO by ticking “√“ the appropriate relevant box.</i>
</td>
</tr>
<tr>
<td width="'.$col_wide.'" colspan="15" style="border-right:1px solid #000000">
<i>(This description must be read together  with Standards 2.1.2 , 2.2.1 and 2.2.2 in  Area 2 - pages 16 & 18) </i>
</td>
</tr>';

///////////////////////////////////////////// transferable
$col_trans_label = $col_label + ($col_unit * 5);
$col_trans_number = $col_unit;
$col_trans_bal = $wtab - $colnum - $col_trans_label - $col_trans_number;

$trans_text = $this->model->profile->transfer_skill_bi;

$version_type = $this->model->version_type_id;

$transferables = $this->model->profile->transferables;


$html_transfer = '';
$rowspan_transfer = 1;
if($version_type == 1){
$html_transfer .= '<td width="'.$col_trans_number.'" '.$style_shade.' align="center">1</td>
	<td colspan="8" width="'.$col_trans_bal.'" '.$border.'>
	'.$trans_text.'
	</td>
	</tr>';
}elseif($version_type == 2){

if($transferables){
	$kira = 1;
	foreach($transferables as $transfer){
		if($kira == 1){
			$html_transfer .= '<td width="'.$col_trans_number.'" '.$style_shade.' align="center">1</td>
					<td colspan="8" width="'.$col_trans_bal.'" '.$border.'>
					'.$transfer->transferable->transferable_text_bi.'
					</td>
					</tr>';
		}else{
			$html_transfer .= '<tr>
				<td width="'.$col_trans_number.'" '.$style_shade.' align="center">'.$kira.'</td>
				<td colspan="8" width="'.$col_trans_bal.'" '.$border.'>'. $transfer->transferable->transferable_text_bi.'</td>
				</tr>';
		}
	$kira++;
	}
	$rowspan_transfer = $kira - 1;
}else{
	$html_transfer .= '<td width="'.$col_trans_number.'" '.$style_shade.' align="center">1</td>
				<td colspan="8" width="'.$col_trans_bal.'" '.$border.'>
				
				</td>
				</tr>';
}

	
}else{ // if no version type
	$html_transfer .= '<td width="'.$col_trans_number.'" '.$style_shade.' align="center">1</td>
	<td colspan="8" width="'.$col_trans_bal.'" '.$border.'>
	NO_APPLICATION_VERSION_TYPE_ERROR
	</td>
	</tr>';
}


$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center" rowspan="'.$rowspan_transfer.'">9. </td>

<td width="'.$col_trans_label.'" colspan="6" '.$style_shade.' rowspan="'.$rowspan_transfer.'">
Transferable Skills (if applicable)
(Skills learned in the course of study which can be useful and utilized in other settings)<br />

</td>';
$html .= $html_transfer;
//////////////////
//////////////////
/////////////////

$syl_row = count($this->model->syllabus);
if($this->model->courseAssessmentFormative){
	$formative_row = count($this->model->courseAssessmentFormative);
}else{
	$formative_row = 1;
}
if($this->model->courseAssessmentSummative){
	$summative_row = count($this->model->courseAssessmentSummative);
}else{
	$summative_row = 1;
}

$span_10 = 14 + $syl_row + $formative_row + $summative_row;
$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center" rowspan="'.$span_10.'">10. </td>

<td width="'.$col_wide.'" colspan="15" '.$style_shade.'>
<b>Distribution of Student Learning Time (SLT)</b>
</td>
</tr>';
$tab_syl = $wtab - $colnum;
$htopic = $col_trans_label + $col_unit;
$hclo = $col_unit;

$depend = 35;
$dep_all = $depend * 4;
$gui = 63;
$ind = 73;
$hslt = $dep_all + $gui + $ind;
$flex = $wtab - $colnum - $htopic - $hclo - $hslt;
$assess_percent = ($dep_all / 4) + $hclo;
$assess_f2f = ($dep_all / 4) * 3;
$assess_nf2f = $gui + $ind;

$html .= '<tr nobr="true">
<th width="'.$htopic.'" rowspan="3" align="center" '.$style_shade.'><b>Course Content Outline</b></th>
<th width="'.$hclo.'" rowspan="3" align="center" '.$style_shade.'><b>CLO*</b></th>
<th width="'.$hslt.'" colspan="6" align="center" '.$style_shade.'>
<b>Teaching and Learning Activities </b>
</th>

<th rowspan="3" width="'.$flex.'" align="center" '.$style_shade.'>
<b>SLT</b>
</th>

</tr>
<tr nobr="true" '.$style_shade.'>
<th colspan="4" width="'.$dep_all.'" align="center" '.$style_shade.'><b>Guided Learning<br />(F2F)</b></th>
<th rowspan="2" width="'.$gui.'" align="center" '.$style_shade.'><b>Guided Learning<br />(NF2F)</b><br />eg: 
e-Learning</th>
<th rowspan="2" width="'.$ind.'" align="center" '.$style_shade.'><b>Independent Learning (NF2F)</b></th>
</tr>
<tr>';
$html .= '<th align="center" '.$style_shade.'><b>L</b></th>
<th align="center" '.$style_shade.'><b>T</b></th>
<th align="center" '.$style_shade.'><b>P</b></th>
<th align="center" '.$style_shade.'><b>O</b></th>
</tr>';



$tlec = 0;
$ttut = 0;
$tprac =0;
$toth = 0;
$tind = 0;
$tass = 0;
$tgrand = 0;
if($this->model->syllabus ){
	$week_num = 1;
	foreach($this->model->syllabus as $row){
	if($row->duration > 1){
		$end = $week_num + $row->duration - 1;
		$show_week = $week_num . '-<br />' . $end;
	}else{
		$show_week = $week_num;
	}
	$week_num = $week_num + $row->duration;
	$html .='<tr nobr="true">';
	$html .='<td '.$border.'>';
	$arr_all = json_decode($row->topics);
	if($arr_all){
	$i = 1;
	$html .= '<table><tr><td width="7%">'.$show_week.'. </td><td width="93%">';
	foreach($arr_all as $rt){
		$wk = $i == 1 ? $row->week_num . ".  " : '';
		$br = $i == 1 ? '' : "<br />";
		$html .= $br . $rt->top_bi;
		
		if($rt->sub_topic){
		$html .= '<br/><table>';
			foreach($rt->sub_topic as $rst){
			$html .='<tr><td width="5%">- </td><td width="95%">' . $rst->sub_bi . '</td></tr>';
			}
		$html .='</table>';
		}
	$i++;
	}
	$html .= '</td></tr></table>';
	}
	$html .='</td>';
	$clo = json_decode($row->clo);
	$str="";
	if($clo){
		$kk=1;
		foreach($clo as $clonum){
			$comma = $kk == 1 ? "" : "<br />";
			$str .= $comma. 'CLO'.$clonum;
			$kk++;
		}
	}
	$html .= '<td align="center" '.$border.'>'.$str.'</td>';
	$html .='<td align="center" '.$border.'>'.$row->pnp_lecture .'</td>';
	$html .='<td align="center" '.$border.'>'.$row->pnp_tutorial .'</td>';
	$html .='<td align="center" '.$border.'>'.$row->pnp_practical .'</td>';
	$html .='<td align="center" '.$border.'>'.$row->pnp_others .'</td>';
	$html .='<td align="center" '.$border.'>'.$row->nf2f .'</td>';
	$html .='<td align="center" '.$border.'>'.$row->independent .'</td>';
	$sub = $row->pnp_lecture + $row->pnp_tutorial + $row->pnp_practical + $row->pnp_others + $row->independent + $row->nf2f;
	$html .='<td align="center" '.$style_shade.'>'.$sub.'</td>';
	$html .='</tr>';
	$tlec += $row->pnp_lecture;
	$ttut += $row->pnp_tutorial;
	$tprac += $row->pnp_practical;
	$toth += $row->pnp_others;
	$tind += $row->nf2f;
	$tass += $row->independent;
	$tgrand +=$sub;
		
}
}



	$html .='<tr>';
	$html .='<td colspan="8" align="right" >';
		$html .= '<b>Total</b>';
	$html .='</td>';
	$html .='<td align="center" '.$style_shade.'>'.$tgrand.'</td>';
	$html .='</tr>';
	$gran_total_slt = $tgrand;
	$html .='<tr>
<td width="'.$col_wide.'" colspan="15" style="border-right:1px solid #000000"></td>
</tr>';

	
	$html .='<tr style="font-weight:bold">
	<td width="'.$htopic.'" colspan="7" align="center" '.$style_shade.'>Continuous Assessment</td>

	<td width="'.$assess_percent.'" colspan="2" align="center" '.$style_shade.'>Percentage (%)</td>
	<td width="'.$assess_f2f .'" colspan="3" align="center" '.$style_shade.'>F2F</td>
	<td width="'.$assess_nf2f .'" colspan="2" align="center" '.$style_shade.'>NF2F</td>
	<td width="'.$flex.'" align="center" '.$style_shade.'>SLT</td>
	</tr>';
	
	$i=1;
	$total = 0;
	$slt_assess = 0;
	$total_form = 0;
	
	$num = $htopic / 4;
	$as_width = $htopic / 4 * 3;
	
	if($this->model->courseAssessmentFormative){
	
	foreach($this->model->courseAssessmentFormative as $rf){
			$per = $rf->as_percentage + 0;
			$f2f = $rf->assess_f2f;
			$nf2f = $rf->assess_nf2f;
			$sub_total = $f2f + $nf2f;
			$slt_assess += $sub_total;
			$c=1;
			$cc=1;
			$str="";

			$html .='<tr>
			<td width="'.$num.'" '.$style_shade.' align="center">'.$i.'</td><td width="'.$as_width.'" colspan="2" '.$border.'>'.$rf->assess_name_bi .'</td>
			
			<td width="'.$assess_percent .'" colspan="3" align="center" '.$border.'>'. $per .'</td>
			<td width="'.$assess_f2f .'" colspan="2" align="center" '.$border.'>'.$f2f.'</td>
			<td width="'.$assess_nf2f .'" align="center" '.$border.'>'.$nf2f.'</td>
			<td width="'.$flex.'" align="center" '.$style_shade.'>'.$sub_total .'</td>
			</tr>';
			$total +=$per;
	$i++;
	}
	}else{
		$html .='<tr>
			<td width="'.$num.'" '.$style_shade.' align="center">'.$i.'</td><td width="'.$as_width.'" colspan="2" '.$border.'></td>
			<td width="'.$assess_percent .'" colspan="3" align="center" '.$border.'></td>
			<td width="'.$assess_f2f .'" colspan="2" align="center" '.$border.'></td>
			<td width="'.$assess_nf2f .'" align="center" '.$border.'></td>
			<td width="'.$flex.'" align="center" '.$style_shade.'></td>
			</tr>';
	}
	
	
	$html .='<tr>';
	$html .='<td colspan="9" align="right" >';
		$html .= '<b>Total</b>';
	$html .='</td>';
	$html .='<td align="center" '.$style_shade.'>'.$slt_assess.'</td>';
	$html .='</tr>';
	$gran_total_slt += $slt_assess;
	$html .='<tr>
<td width="'.$col_wide.'" colspan="15" style="border-right:1px solid #000000"></td>
</tr>';


$html .='<tr style="font-weight:bold">
	<td width="'.$htopic.'" colspan="7" align="center" '.$style_shade.'>Final Assessment</td>

	<td width="'.$assess_percent.'" colspan="2" align="center" '.$style_shade.'>Percentage (%)</td>
	<td width="'.$assess_f2f .'" colspan="3" align="center" '.$style_shade.'>F2F</td>
	<td width="'.$assess_nf2f .'" colspan="2" align="center" '.$style_shade.'>NF2F</td>
	<td width="'.$flex.'" align="center" '.$style_shade.'>SLT</td>
	</tr>';
	
	$i=1;
	$total = 0;
	$slt_assess = 0;
	$total_form = 0;
	if($this->model->courseAssessmentSummative){
	
	foreach($this->model->courseAssessmentSummative as $rf){
			$per = $rf->as_percentage + 0;
			$f2f = $rf->assess_f2f;
			$nf2f = $rf->assess_nf2f;
			$sub_total = $f2f + $nf2f;
			$slt_assess += $sub_total;
			$c=1;
			$cc=1;
			$str="";

			$html .='<tr>
			<td width="'.$num.'" '.$style_shade.' align="center">'.$i.'</td><td width="'.$as_width.'" colspan="2" '.$border.'>'.$rf->assess_name_bi .'</td>
			
			<td width="'.$assess_percent .'" colspan="3" align="center" '.$border.'>'. $per .'</td>
			<td width="'.$assess_f2f .'" colspan="2" align="center" '.$border.'>'.$f2f.'</td>
			<td width="'.$assess_nf2f .'" align="center" '.$border.'>'.$nf2f.'</td>
			<td width="'.$flex.'" align="center" '.$style_shade.'>'.$sub_total .'</td>
			</tr>';
			$total +=$per;
	$i++;
	}
	}else{
		$html .='<tr>
			<td width="'.$num.'" '.$style_shade.' align="center">'.$i.'</td><td width="'.$as_width.'" colspan="2" '.$border.'></td>
			<td width="'.$assess_percent .'" colspan="3" align="center" '.$border.'></td>
			<td width="'.$assess_f2f .'" colspan="2" align="center" '.$border.'></td>
			<td width="'.$assess_nf2f .'" align="center" '.$border.'></td>
			<td width="'.$flex.'" align="center" '.$style_shade.'></td>
			</tr>';
	}
	
	
	$html .='<tr>';
	$html .='<td colspan="9" align="right" >';
		$html .= '<b>Total</b>';
	$html .='</td>';
	$html .='<td align="center" '.$style_shade.'>'.$slt_assess.'</td>';
	$html .='</tr>';
	$gran_total_slt += $slt_assess;
	
	$total_ind_text = $htopic + $assess_percent + $assess_f2f ;
$box_practical = $gui - 20;
$grand_slt_text = $assess_nf2f - $box_practical;
	
	$html .='<tr>
	<td colspan="11" rowspan="2" width="'.$total_ind_text.'" >
	<br /><br /><b>**Please tick (√) if this course is Latihan Industri/ Clinical Placement/ Practicum/ WBL <br />using Effective Learning Time(ELT) of 50%</b>
	</td>
<td width="'.$box_practical.'"></td>
	<td colspan="2" width="'.$grand_slt_text.'" align="right"></td>
	
	';
	$html .='<td align="center" width="'.$flex.'" style="border-right:1px solid #000000"></td>
</tr>';

if($this->model->slt->is_practical == 1){
	$tick_prac = '√';
}else{
	$tick_prac = '';
}

$html .='<tr>';
	$html .='
	<td style="border:1px solid #000000;font-size:15px" align="center" width="'.$box_practical.'">'.$tick_prac.'</td>
	<td colspan="2" width="'.$grand_slt_text.'" align="right"><b>GRANT TOTAL SLT</b></td>
	
	';
	$html .='<td align="center" '.$style_shade.' width="'.$flex.'"><b>'.$gran_total_slt.'</b></td>';
	$html .='</tr>';
	
	$html .='<tr>
<td width="'.$col_wide.'" colspan="15" style="border-right:1px solid #000000">
<i>L = Lecture, T = Tutorial, P= Practical, O= Others, F2F=Face to Face, NF2F=Non Face to Face</i><br />
<i>*Indicate the CLO based on the CLO’s numbering in Item 8.</i>
</td>
</tr>';

$special = $col_label + 90;
$special_content = $col_content - 90;
$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center">11. </td>

<td width="'.$special.'" '.$style_shade.' colspan="3">Identify special requirement to deliver the course (e.g: software, nursery, computer lab, simulation room, etc): </td>


<td width="'.$special_content.'" colspan="12" '.$border.'>'.$this->model->profile->requirement_bi.'</td>
</tr>';


$ref = $special + 80;
$ref_content = $special_content -80;
$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center">12. </td>

<td width="'.$ref.'" '.$style_shade.' colspan="3">References (include required and further readings, and should be the most current) </td>


<td width="'.$ref_content.'" colspan="12" '.$border.'>';


$i = 1;
if($this->model->mainReferences){
	
	$html .= '<table>';
	foreach($this->model->mainReferences as $row){
		$html .='<tr>';
		$html .='<td width="5%">'.$i.'. </td>';
		$html .='<td width="95%">'.$row->formatedReference.'</td>';
		$html .='</tr>';
	$i++;
	}
	$html .= '</table>';
}

if($this->model->additionalReferences){
	$html .= '<table>';
	foreach($this->model->additionalReferences as $row){
		$html .='<tr>';
		$html .='<td width="5%">'.$i.'. </td>';
		$html .='<td width="95%">'.$row->formatedReference.'</td>';
		$html .='</tr>';
	$i++;
	}
	$html .= '</table>';
}




$html .= '</td>
</tr>';

$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center">13. </td>

<td width="'.$ref .'" '.$style_shade.' colspan="3">Other additional information : </td>


<td width="'.$ref_content.'" colspan="12" '.$border.'>'.$this->model->profile->additional_bi.'</td>
</tr>';
	

$html .= '</table>
';

//echo $html;die();

$this->pdf->SetFont('calibri', '', 8); // 8
$tbl = <<<EOD
$html
EOD;

$this->pdf->writeHTML($tbl, true, false, false, false, '');
$this->pdf->lineFooterTable = false;
		
		
	}
	
	

	
	public function htmlWriting(){
	$html = $this->html;
	$html .= '</table>';
	//echo $html;die();
		$this->pdf->SetFont('calibri', '', $this->font_size); // 8
$tbl = <<<EOD
$html
EOD;

$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('Table 4');
		$this->pdf->SetTitle('Table 4 - '.$this->model->course->course_code );
		$this->pdf->SetSubject('Table 4 - '.$this->model->course->course_code );
		$this->pdf->SetKeywords('Maklumat Kursus');



		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$this->pdf->SetMargins(12, 18, 12);
		//$this->pdf->SetMargins(0, 0, 0);
		$this->pdf->SetHeaderMargin(13);
		//$this->pdf->SetHeaderMargin(0);

		 //$this->pdf->SetHeaderMargin(0, 0, 0);
		$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$this->pdf->SetAutoPageBreak(TRUE, 20); //margin bottom

		// set image scale factor
		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$this->pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------



		// add a page
		$this->pdf->AddPage("P");
	}
	
	
}
