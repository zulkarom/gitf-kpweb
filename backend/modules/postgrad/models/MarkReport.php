<?php

namespace backend\modules\postgrad\models;

use Yii;
use common\models\Common;

class MarkReport
{
	public $offer;
	public $students;
	public $pdf;
	public $course;
	public $assessment;
	
	public function generatePdf(){		
		date_default_timezone_set("Asia/Kuala_Lumpur");
		// $this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
		
		$this->pdf = new MarkReportStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$this->course = $this->offer->course;
		$this->assessment = $this->offer->assessment;
		
		$this->startPage();

		//$this->setHeader();

		$this->body();

		$this->pdf->Output('mark-report.pdf', 'I');
	}

	public function body(){
		
		$html = '<table border="1">';

		//$html .= '<tr></tr>';

		$html .= '<thead>
        <tr><th>#</th><th>Matric No.</th><th>Students Name</th><th>Group</th>';
            foreach ($this->assessment as $assess) {
                $html .= '<th style="text-align:center">'.$assess->assess_name_bi.' 
                <br />('.$assess->assessmentPercentage.'%)
                </th>
                
                ';

            }
			$html .='<th style="text-align:center">Total<br />(100%)</th>
        <th style="text-align:center">Grade</th>
        </tr>
    </thead>';


		$html .= '</table>';
		
$tbl = <<<EOD
$html
EOD;
		
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
		$this->pdf->AddPage("P");
		
		$this->pdf->curr_page = $this->pdf->getAliasNumPage();
		$this->pdf->total_page = $this->pdf->getAliasNbPages();
	}
	
	
}
