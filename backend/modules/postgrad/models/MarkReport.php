<?php

namespace backend\modules\postgrad\models;

use common\models\Grade;

class MarkReport
{
	public $offer;
	public $students;
	public $pdf;
	public $course;
	public $assessment;
	public $mark_arr;
	
	public function generatePdf(){		
		date_default_timezone_set("Asia/Kuala_Lumpur");
		// $this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
		
		$this->pdf = new MarkReportStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$this->pdf->course = $this->offer->course;
		//$this->pdf->semester = $this->offer->semester;

		$this->course = $this->offer->course;
		$this->assessment = $this->offer->assessment;
		
		$this->startPage();

		//$this->setHeader();

		$this->marksTable();
		$this->summary();
		$this->signature();

		$this->pdf->Output('mark-report.pdf', 'I');
	}

	public function signature(){
		$html = '
		<br /><br /><br />
		

<table border="0">
<tr><td width="10%"></td><td width="45%">

<table border="0" cellpadding="5">
<tr><td>Nota:<br />
Sila sahkan keputusan ini dengan tandatangan dan cop jawatan.<br /><br /></td></tr>
<tr><td>COURSE COORDINATOR : _____________________________________
</td></tr>
<tr><td>NAME:
</td></tr>
<tr><td>DATE:
</td></tr>
</table>



</td>
<td width="45%">
		
<table border="0" cellpadding="5">
<tr><td><br /><br /><br /><br /></td></tr>
<tr><td>DIRECTOR APROVAL : _____________________________________
</td></tr>
<tr><td>NAME:
</td></tr>
<tr><td>DATE:
</td></tr>
</table>



</td></tr>
</table>

		';
		$tbl = <<<EOD
$html
EOD;
		$this->pdf->SetFont('arial', '', 8);
		$this->pdf->writeHTML($tbl, true, false, false, false, '');

	}

	public function summary(){
		//generate chart
		$list = Grade::analyse($this->mark_arr);
		Report::BarChart(json_encode($list), true);
		

		$html = '<table nobr="true" border="0"><tr><td width="24%"></td><td width="50%">';
		
		//chart

		//$html .= $from;
		//copy($from, 'images/chartbar.png');

		$html .= '<img width="500" src="images/temp/mark/bar.png" />';

		$html .= '</td><td align="right">';
		
		
		$html .= '<br /><br /><br /><br /><table border="1" width="300" align="right" cellpadding="3">
    <thead><tr style="text-align:center;font-weight:bold">
    <th style="text-align:center">Range</th><th style="text-align:center">Grade</th><th style="text-align:center">Point</th><th style="text-align:center">Result Count</th>
    </tr></thead>
    <tbody>';
        
        foreach($list as $min=>$v){
            $html .= '<tr style="text-align:center"><td>'.$min.' - '.$v[1].'</td><td>'.$v[0].'</td><td>'.number_format($v[3],2).'</td><td>'.$v[2].'</td></tr>';
        }

    $html .= '</tbody></table>';
		
		$html .= '</td></tr></table>';


$tbl = <<<EOD
$html
EOD;
		$this->pdf->SetFont('arial', '', 8);
		$this->pdf->writeHTML($tbl, true, false, false, false, '');

	}

	public function marksTable(){


		$c = count($this->assessment);
		$total_col = 7 + $c;
		

		//$html .= '<tr></tr>';

		///width
		$all = 1170;
		$bil = 30;
		$matric = 80;
		$group = 55;
		$total = 70;
		$grade = 70;
		$wmark = 100;
		$point = 70;
		$name = $all - ($bil + $matric + $group + $total + $grade + $point + ($wmark * $c));

		$html = '<table border="0" cellpadding="5">';
		$style='style="text-align:center;border:1px solid #000000"';
		$style_shade='style="text-align:center;border:1px solid #000000;background-color: #ededed"';
		$style_name='style="border:1px solid #000000"';
		$style_header='style="border:1px solid #000000;line-height:25px;font-size:8pt"';
		$html .= '<thead>
		<tr>
		<td '.$style_header.'  colspan="'.$total_col.'" width="'. $all .'">
		<b>'. $this->offer->semester->longFormat() .'</b>
		</td>
		</tr>

		<tr>
		<td '.$style_header.'  colspan="'.$total_col.'" width="'. $all .'">
		<b>COURSE</b>         '. $this->course->course_code .' - '. $this->course->course_name_bi   .'
		</td>
		</tr>

        <tr style="font-size:7pt">
		<th '.$style.' width="'.$bil.'"><b>NO.</b></th>
		<th '.$style.' width="'.$matric.'"><b>MATRIC NO.</b></th>
		<th '.$style_name.' width="'.$name.'"><b>STUDENT NAME</b></th>
		<th '.$style.' width="'.$group.'"><b>GROUP</b></th>';
            foreach ($this->assessment as $assess) {
                $html .= '<th '.$style.' width="'.$wmark.'"><b>'.$assess->assess_name_bi.' 
                </b><br />('.$assess->assessmentPercentage.'%)
                </th>
                
                ';

            }
		$html .='<th '.$style_shade.' width="'.$total.'"><b>TOTAL</b><br />(100%)</th>
        <th '.$style_shade.' width="'.$grade.'"><b>GRADE</b></th>
		<th '.$style_shade.' width="'.$grade.'"><b>POINT</b></th>
        </tr>
    </thead>';

	$html .= '<tbody>';


	if($this->students){
	 	$i = 1;
		$mark_arr = [];
		foreach($this->students as $st){
			$html .=  '<tr><td '.$style.' width="'.$bil.'">'.$i.'. </td>
			<td '.$style.' width="'.$matric.'">'.$st->student->matric_no.'</td>
			<td '.$style_name.' width="'.$name.'">'.strtoupper($st->student->st_name).'</td>
			<td '.$style.' width="'.$group.'">'.$st->courseLecture->lec_name.'</td>';
			
			$result = json_decode($st->assess_result);
			
	
			if($this->assessment)
			{
				$x = 0;
				$sum = 0;
				
				foreach ($this->assessment as $assess) {
				
				if($result){
					if(array_key_exists($x, $result)){
					$mark = $result[$x];
					$sum += $mark;
					$html .= '<td '.$style.' width="'.$wmark.'">'.number_format($mark,2).'</td>';
					}
					else{
					$html .= '<td '.$style.' width="'.$wmark.'"></td>';
					}
					
				}
				else{
					$html .= '<td '.$style.' width="'.$wmark.'"></td>';
				}
				
				$x++;
				}
			}
			$mark_arr[] = $sum;
			$html .=  '<td '.$style_shade.' width="'.$total.'"><b>'.number_format($sum,2).'</b></td>
			<td '.$style_shade.' width="'.$grade.'"><b>'.Grade::showGrade($sum).'</b></td><td '.$style_shade.' width="'.$point.'"><b>'.number_format(Grade::showPoint($sum),2).'</b></td>';
			$html .=  '</tr>';
	$i++;
	}

	$spn = $c + 4;
    $html .= '<tr><td colspan="'.$spn.'" style="text-align:right">Average</td><td style="text-align:center"><b>
    '. number_format(Grade::average($mark_arr),2) .'</b></td><td></td><td></td></tr>';
    $html .= '<tr><td colspan="'.$spn.'" style="text-align:right">St. Dev.</td><td style="text-align:center"><b>'. number_format(Grade::stdev($mark_arr),2) .'</b></td><td></td><td></td></tr>'; 
}

		$html .= 	'</tbody>';


		$html .= '</table>';

		$this->mark_arr = $mark_arr;

$tbl = <<<EOD
$html
EOD;
		$this->pdf->SetFont('arial', '', 7);
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('FKP PORTAL');
		$this->pdf->SetTitle('Mark Report');
		$this->pdf->SetSubject('Mark Report');
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
