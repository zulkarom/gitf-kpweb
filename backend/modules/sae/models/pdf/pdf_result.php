<?php


namespace backend\modules\sae\models\pdf;

use Yii;
use backend\modules\sae\models\pdf\MYPDF_result;
use backend\modules\sae\models\Answer;
use backend\modules\sae\models\GradeCategory;

class pdf_result{
	public $gcat;
	public $users;
	public function generatePdf(){
		$pdf = new MYPDF_result(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('UMK FKP');
$pdf->SetTitle('All-Result');
$pdf->SetSubject('All-Result');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
//$pdf->writeHTML("<strong>hai</strong>", true, 0, true, true);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
//$pdf->SetMargins(0, 0, 0);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetHeaderMargin(0);

 //$pdf->SetHeaderMargin(0, 0, 0);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 30); //margin bottom

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------



// add a page
$pdf->AddPage("P");

for($i=1;$i<=9;$i++){
	
}
$w2=32;
$w3= 10.5;
$w4= 8;
$pdf->Cell(0, 10, 'KEPUTUSAN UJIAN PSIKOMETRIK', 0, false, 'C', 0, '', 0, false, 'M', 'M');


$wid = [10, 8, 9, 11, 8.5, 12];

$pdf->SetFont('helvetica', '', 8);
$html ='<br /><br /><br /><table border="1" cellpadding="5" width="620">
	<thead>
	<tr >
		<th width="5%"><strong>#</strong></th>
		<th width="'.$w2.'%"><strong>NAMA</strong><br/><i>(NRIC)</i></th>
		';
			
foreach($this->gcat as $i => $grow){
    $text = ucfirst(strtolower($grow->gcat_text));

    $html .= '<th width="'.$wid[$i].'%"><strong>'. $text .'</strong></th>';
	}

$html .= '<th width="'.$w4.'%"><strong>TOTAL</strong></th>
</tr>
</thead>';

$i=1;
$x=1;
foreach ($this->users as $user) {
	$html .= '<tr nobr="true">
		<td width="5%">'. $x.'. </td>
		<td width="'.$w2.'%">'. $user->can_name .'<br /><i>('. $user->username .')</i></td>
		';

		$set_sort = GradeCategory::getGradeCat();
			foreach($set_sort as $i => $sr){
				$id = "c".$sr->id;
				$html .= '<td width="'.$wid[$i].'%">'.$user->$id.'</td>';
			}
		$total = $user->c1+$user->c2+$user->c3+$user->c4+$user->c5+$user->c6;
		$html .= '<td width="'.$w4.'%">'. $total .'</td></tr>';
$i++;
$x++;
}
$html .= '</table>'; 

// echo $html;

$tbl = <<<EOD
$html
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$pdf->Output('AllResult.pdf', 'I');
	}
}
?>