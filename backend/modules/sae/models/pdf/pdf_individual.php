<?php


namespace backend\modules\sae\models\pdf;

use Yii;
use backend\modules\sae\models\pdf\MYPDF_individual;
use backend\modules\sae\models\Answer;

class pdf_individual{
	public $gcat;
	public $user;
	public function generatePdf(){
		$pdf = new MYPDF_individual(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('UMK FKP');
		$pdf->SetTitle('Individual-Result');
		$pdf->SetSubject('Individual-Result');
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
		$pdf->SetAutoPageBreak(TRUE, -30); //margin bottom

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

$pdf->SetFont('helvetica', '', 10);

$html = '

<br />

<table cellpadding="3">
<tr><td><strong>NAMA: </strong> '. strtoupper($this->user->can_name) . ' </td></tr>

<tr><td><strong>NO. KAD PENGENALAN: </strong>'. strtoupper($this->user->username) .'</td></tr>


</table>
<br /><br /><br />';

$tbl = <<<EOD
$html
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$pdf->SetFont('helvetica', '', 9);
$html ='<table cellpadding="3">
<thead>
<tr>';


$rowstring="";
foreach($this->gcat as $grow){
	$html .= "<th><strong>".strtoupper($grow->gcat_text) ."</strong></th>";
	$result_cat = Answer::getAnswersByCat($this->user->id,$grow->id);
	$stringdata ='<table border="0" cellpadding="5">
	<tr><td><strong>Q</strong></td>
	<td><strong>A</strong></td>
	</tr>';
	$jum = 0;
	foreach($result_cat as $rowcat){
		$stringdata .="<tr>";
		$stringdata .='<td><strong>'.$rowcat->quest .'</strong></td>';
		if($rowcat->answer == 1){
			$ans ="YA";
			$jum +=1;
		}else if($rowcat->answer == 0){
			$ans ="TIDAK";
		}else{
			$ans ="NA";
		}
		$stringdata .="<td>".$ans ."</td>";
		$stringdata .="</tr>";
	}
	$stringdata .="
	<tr><td></td><td></td></tr>
	<tr><td><strong>TOTAL</strong></td><td><strong>".$jum."</strong></td></tr></table>";
	$rowstring .= "<td>".$stringdata."</td>";
} 

$html .= "</tr>
</thead>
<tbody>
<tr>";
$html .= $rowstring;
$html .= "</tr>

</tbody>
</table>";
	

$tbl = <<<EOD
$html
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


$pdf->Output($this->user->username.'.pdf', 'I');
	}
}
?>