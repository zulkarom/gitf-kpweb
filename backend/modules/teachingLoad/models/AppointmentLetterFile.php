<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use common\models\Common;
use yii\helpers\Url;



class AppointmentLetterFile
{
	public $model;
	public $pdf;
	public $tuan = 'Tuan';
	public $template;
	public $fontSize = 10;
	
	public function generatePdf(){
		
		$this->template = $this
		->model
		->staffInvolved
		->semester
		->appointLetterTemplate;
		

		
		$this->pdf = new Tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$this->writeHeaderFooter();
		$this->startPage();
		
		$this->writeRef();
		$this->writeTitle();
		$this->writeTable();
		
		// $this->pdf->AddPage("P");
		$this->writeEnding();
		// $this->writeSlogan();
		$this->writeSigniture();
		$this->writeSignitureImg();
		// $this->writeSk();
		
		// $this->pdf->AddPage("P");
		// $this->writeTask();

		$this->pdf->Output('surat-perlantikan.pdf', 'I');
	}
	
	public function writeHeaderFooter(){
		$this->pdf->header_first_page_only = true;
		$this->pdf->header_html ='<img src="images/letterhead.jpg" />';
		
		$this->pdf->footer_first_page_only = true;
		$this->pdf->footer_html ='<img src="images/letterfoot.jpg" />';
	}
	public function writeRef(){

		
		if($this->model->date_appoint == "0000-00-00"){
			$date = 'TO BE DETERMINED';
		}else
		{
			$release = $this->model->date_appoint;
			$date = strtoupper(Common::date_malay($release));
		}
		
		
		
		$html = '<br /><br /><br />
		<table cellpadding="1">
		<tr>
			<td width="490"></td>
			<td width="300" align="left">'.$this->model->ref_no . '</td>
		</tr>
		<tr>
			<td></td>
			<td align="left">'. $date .'</td>
		</tr>
		</table>
		<br /><br /><br /><br />
		<b>'.strtoupper($this->model->staffInvolved->staff->user->fullname) .'<br /></b>
		<table>
		<tr>
			<td><b>'. ($this->model->staffInvolved->staff->staffPosition->position_name).' '.'('.strtoupper($this->model->staffInvolved->staff->staffPosition->position_gred).')'.'</b></td>
		</tr>
		<tr>
			<td>Fakulti Keusahawanan dan Perniagaan <br/> Universiti Malaysia Kelantan </td>
		</tr>
		</table>
		
		<br /><br /><br />
		';
		
		$this->pdf->SetMargins(20, 10, 20);
		
		$this->pdf->SetFont('arial','', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeTitle(){
		
		$gender = $this->model->staffInvolved->staff->gender;
		if($gender == 0){
			$this->tuan = 'puan';
		}
		
		$coordinator = $this->model->courseOffered->coordinator;
		if($coordinator ==  $this->model->staffInvolved->staff_id){
			$html = '
		'.ucfirst($this->tuan).',<br /><br />
		
		<b>PELANTIKAN SEBAGAI PENYELARAS DAN PENGAJAR DI FAKULTI KEUSAHAWANAN DAN PERNIAGAAN</b>
		<br /><br />
		
		Dengan hormatnya saya merujuk kepada perkara di atas.
		<br /><br />
		
		2. &nbsp;&nbsp;&nbsp;Sukacita dimaklumkan bahawa '.$this->tuan .' dilantik sebagai Penyelaras dan Pengajar bagi kursus berikut:
		<br /><br />
		';
		$this->pdf->SetFont( 'arial','', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		}else{
			$html = '
		'.ucfirst($this->tuan).',<br /><br />
		
		<b>PELANTIKAN SEBAGAI PENGAJAR DI FAKULTI KEUSAHAWANAN DAN PERNIAGAAN</b>
		<br /><br />
		
		Dengan hormatnya saya merujuk kepada perkara di atas.
		<br /><br />
		
		2. &nbsp;&nbsp;&nbsp;Sukacita dimaklumkan bahawa '.$this->tuan .' dilantik sebagai Pengajar bagi kursus berikut:
		<br /><br />
		';
		$this->pdf->SetFont( 'arial','', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		}
		
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeTable(){
		$all = 580;
		$w1 = 50;
		$w2 = 30;
		$w3 = 140;
		$w4 = 40;
		$w5 = $all - $w1 - $w2 - $w3 - $w4;
		$course = $this->model->courseOffered->course;
		$html = '
		<table cellpadding="1">
		<tr>
			<td width="'.$w1.'"></td>
			<td width="'.$w3.'">Kod Kursus</td>
			<td width="'.$w4.'">:</td>
			<td width="'.$w5.'">'.$course->course_code .'</td>
		</tr>';
		$html .='<tr>
			<td></td>
			<td>Nama Kursus</td>
			<td>:</td>
			<td width="'.$w5.'">'.$course->course_name.'</td>
		</tr>
		<tr>
			<td></td>
			<td>Semester</td>
			<td>:</td>
			<td>'.strtoupper($this->model->staffInvolved->semester->sessionLong).'</td>
		</tr>
		<tr>
			<td></td>
			<td>Sesi</td>
			<td>:</td>
			<td>'.$this->model->staffInvolved->semester->year.'</td>
		</tr>';

		if($this->model->countLecturesByStaff > 0){
		$html .='<tr>
			<td></td>
			<td>Jumlah Kuliah</td>
			<td>:</td>
			<td>'.$this->model->countLecturesByStaff.'</td>
			</tr>';
		}
		
		if($this->model->countTutorialsByStaff > 0){
			$html .= '<tr>
				<td></td>
				<td>Jumlah Tutorial</td>
				<td>:</td>
				<td>'.$this->model->countTutorialsByStaff.'</td>
			</tr>';	
		}
		
		$html .= '</table>
		';
		$this->pdf->SetFont('arial','B', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeEnding(){
		
		
		$per4 = $this->template->per1;

		$html = '<br />
		<table width="700"><tr><td><span style="text-align:justify;">3. &nbsp;&nbsp;&nbsp;
		Untuk makluman, pelantikan ini adalah berkuatkuasa mengikut perubahan dari semasa ke semasa.
		<br /><br />
		4. &nbsp;'.str_replace('{TUANPUAN}', $this->tuan, $per4).'
		<br /><br /></span>
		Sekian.
		<br />
		</td></tr></table>';

		$this->pdf->SetFont('arial','', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	

	
	public function writeSignitureImg(){
		
		$sign = $this->template->signiture_file;
		if(!$sign){
			return false;
		}

		$file = Yii::getAlias('@upload/'. $sign);
		
		$html = '
		<img src="'.$file.'" />
		';
		$tbl = <<<EOD
		$html
EOD;
		$y = $this->pdf->getY();
		$adjy = $this->template->adj_y;
		
		$posY = $y - 42 + $adjy;
		$this->pdf->setY($posY);
		
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeSigniture(){
		$tema = $this->template->tema;
		$tema = nl2br($tema);
		$benar = $this->template->yg_benar;
		$dekan = $this->template->dekan;
		
				$html = '<b>'.$tema.'</b>
		<br /><br />
		'.$benar.',<br />
		<br /><br /><br />
		<b>'.$dekan.'</b><br />
		Dekan<br />
		';
		$this->pdf->SetFont('arial','', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
	}
	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('Pusat Kokurikulum');
		$this->pdf->SetTitle('SURAT PERLANTIKAN');
		$this->pdf->SetSubject('SURAT PERLANTIKAN');
		$this->pdf->SetKeywords('');

		// set default header data
		$this->pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		//$this->pdf->writeHTML("<strong>hai</strong>", true, 0, true, true);
		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		//$this->pdf->SetMargins(25, 10, PDF_MARGIN_RIGHT);
		$this->pdf->SetMargins(0, 0, 0);
		//$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->pdf->SetHeaderMargin(0);

		 //$this->pdf->SetHeaderMargin(0, 0, 0);
		$this->pdf->SetFooterMargin(0);

		// set auto page breaks
		$this->pdf->SetAutoPageBreak(TRUE, -30); //margin bottom

		// set image scale factor
		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$this->pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		$this->pdf->setImageScale(1.53);

		// add a page
		$this->pdf->AddPage("P");
	}
	
	
}
