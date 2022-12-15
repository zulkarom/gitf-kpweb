<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use common\models\Common;
use yii\helpers\Url;
use backend\modules\teachingLoad\models\AppointmentLetter;
use backend\modules\staff\models\LetterDesignation;



class AppointmentLetterFile
{
	public $model;
	public $pdf;
	public $tuan = 'Tuan';
	public $template;
	public $fontSize = 11;
	public $en = false;
	public $margin_left = 37;
	public $store = false;
	public $multiple = false;
	public $modelMultiple;
	public $ref_left = 390;
	
	public function generatePdf(){
		
		$this->template = $this
		->model
		->staffInvolved
		->semester
		->appointLetterTemplate;
		
		if($this->model->staffInvolved->staff->nationality != 'MY'){
		    $this->en = true;
		}
		

		
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
		$file_name = $this->model->staffInvolved->staff->user->fullname . '-' . $this->model->courseOffered->course->course_code;
		$file_name = str_replace(['/', "\\", "'"],'', $file_name);
		if($this->store){
		    $path = Yii::getAlias('@upload/temp/');
		    $this->pdf->Output($path . $file_name . '.pdf', 'F');
		    return $file_name . '.pdf';
		}else{
		    $this->pdf->Output($file_name . '.pdf', 'I'); 
		}
        
	}
	
	public function generateSingle(){
	    
	}
	
	public function writeHeaderFooter(){
		$this->pdf->header_first_page_only = true;
		if($this->template->background_file == 1){
		    $this->pdf->image_background = 'lh-fkp-2021.jpg';
		    $this->pdf->margin_top = 15;
		}else if($this->template->background_file == 2){
		    $this->pdf->image_background = 'lh-fkp-2022.jpg';
		    $this->pdf->margin_top = 38;
		    $this->margin_left = 21;
		    $this->ref_left = 490;
		}
	
		//$this->pdf->header_html ='<img src="images/letterhead.jpg" />';
		
		$this->pdf->footer_first_page_only = true;
		//$this->pdf->footer_html ='<img src="images/letterfoot.jpg" />';
	}
	
	public function titleTrans(){
	    return [
	        'Prof. Madya' => 'Assoc. Prof.',
	        'Tuan' => 'Mr.',
	        'Encik' => 'Mr.',
	        'Puan' => 'Mrs.',
	        'Cik' => 'Miss'
	    ];
	}
	
	public function writeRef(){

		
	    if($this->model->date_appoint == "0000-00-00" or $this->model->date_appoint == null){
			$date = 'TO BE DETERMINED';
		}else{
			$release = $this->model->date_appoint;
			if($this->en){
			    $date = strtoupper(date('d F Y', strtotime($release)));
			}else{
			    $date = strtoupper(Common::date_malay($release));
			}
			
		}
		
		
		$title = $this->model->staffInvolved->staff->staff_title;
		if($this->en){
		    $arr = $this->titleTrans();
		    foreach($arr as $k => $a){
		        $title = str_replace($k, $a, $title);
		    }
		}
		
		
		
		$html = '<br /><br />
        <div style="line-height:24px;">&nbsp;</div>
		<table cellpadding="1" border="0">
		<tr>
			<td width="'. $this->ref_left .'"></td>
			<td width="300" align="left">'.$this->model->ref_no . '</td>
		</tr>
		<tr>
			<td></td>
			<td align="left">'. $date .'</td>
		</tr>
		</table>
		<br /><br />';
		
		if($this->template->background_file == 1){
		    $html .= '<br />';
		}
		
		$html .= '
		<b>'. $title . ' ' . $this->model->staffInvolved->staff->user->fullname;
		$status = $this->model->staffInvolved->staff->staffPositionStatus->status_cat;
		
		
		$show_full = true;
		if($status == 'Kontrak' or $status == 'Sementara'){
			$show_full = false;
		}
		
		$position = $this->model->staffInvolved->staff->staffPosition->position_plain;
		
		if($this->en){
    		if($status == 'Kontrak'){
    		    $status = 'Contract';
    		}else if($status == 'Sementara'){
    		    $status = 'Temporary';
    		}else if($status == 'Tetap'){
    		    $status = 'Permanent';
    		}else if($status == 'Pinjaman'){
    		    $status = 'Loan';
    		}
    		
    		$position = $this->model->staffInvolved->staff->staffPosition->position_en;
		}

		
		if($show_full  == false){
		    
		        
		   
			$html .= ' ('.$status.')';
		}
		
		
		$html .= '<br /></b>
		<table>';
		if($show_full){
			$html .= '<tr>
			<td><b>'. $position .' 
'.'('.strtoupper($this->model->staffInvolved->staff->staffPosition->position_gred).') 
'.$status .' '.'</b></td>
		</tr>';
		}
		
		if($this->en){
		    
		    $fak = $this->model->staffInvolved->staff->faculty->faculty_name_bi;
		}else{
		    $fak = $this->model->staffInvolved->staff->faculty->faculty_name;
		}
		
		
		
		$html .= '<tr>
			<td>'. $fak .' <br/> Universiti Malaysia Kelantan </td>
		</tr>
		</table>
		
		<br /><br />
		';
		
		    
		if($this->template->background_file == 1){
		    $html .= '<br />';
		}
		        
		
		$this->pdf->SetMargins($this->margin_left, 10, 35);
		
		$this->pdf->SetFont('arialnarrow','', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function setTitle(){
	    $gender = $this->model->staffInvolved->staff->gender;
	    if($gender == 0){
	        $this->tuan = 'Puan';
	    }else{
	        $this->tuan = 'Tuan';
	    }
	    
	    $panggilan = $this->model->staffInvolved->staff->designation;
	    if($panggilan ){
	        $this->tuan = $panggilan;
	    }
	    
	    if($this->en){
	        $this->tuan = str_replace('Prof. Madya ', '', $this->tuan);
	        $this->tuan = str_replace('YBrs. ', '', $this->tuan);
	    }
	    
	}
	
	public function writeTitle(){
		
		$this->setTitle();
		
		$coordinator = $this->model->courseOffered->coordinator;
		
		if($coordinator ==  $this->model->staffInvolved->staff_id || $this->model->courseOffered->all_coordinator){
		    $penyelaras = 'Penyelaras dan ';
		    $coor1 = 'COORDINATOR AND ';
		    $coor2 = 'a coordinator and ';
		}else{
		    $penyelaras = '';
		    $coor1 = '';
		    $coor2 = '';
		}
		
		if($this->en){
		    $html = '
		'.ucfirst($this->tuan).',<br /><br />
		    
		<b>AN APPOINTMENT AS '. strtoupper($coor1) .'LECTURER AT FACULTY OF ENTREPRENEURSHIP AND BUSINESS</b>
		<br /><br />
		    
		With due respect to the above matter.
		<br /><br />
		    
		<span style="text-align:justify;">2. &nbsp;&nbsp;&nbsp;</span><span style="text-align:justify;">Kindly be informed that you have been appointed as '. $coor2 .'a lecturer for the following course:
		<br />
		';
		}else{
		    $html = '
		'.ucfirst($this->tuan).',<br /><br />
		    
		<b>PELANTIKAN SEBAGAI '. strtoupper($penyelaras) .'PENGAJAR DI FAKULTI KEUSAHAWANAN DAN PERNIAGAAN</b>
		<br /><br />
		    
		Dengan hormatnya saya merujuk kepada perkara di atas.
		<br /><br />
		 <table width="630"><tr><td>
		<span style="text-align:justify;">2. &nbsp;&nbsp;&nbsp;</span><span style="text-align:justify;">Sukacita dimaklumkan bahawa '.$this->tuan .' dilantik sebagai '. $penyelaras .'Pengajar bagi kursus berikut:</span>
</td></tr>
</table>
		<br />
		';
		}
		
		
		$this->pdf->SetMargins($this->margin_left, 10, 25);
		$this->pdf->SetFont( 'arialnarrow','', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		

		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeTable(){
		$all = 700;
		$w1 = 50;
		$w2 = 30;
		$w3 = 120;
		$w4 = 20;
		$w5 = $all - $w1 - $w2 - $w3 - $w4;
		$course = $this->model->courseOffered->course;
		
		if($this->en){
		    $course_code = 'Course Code';
		    $course_name = 'Course Name';
		    $course_name_data = $course->course_name_bi;
		    $session = 'Session';
		    $total_lecture = 'Total Lecture';
		    $total_tutorial = 'Total Tutorial';
		}else{
		    $course_code = 'Kod Kursus';
		    $course_name = 'Nama Kursus';
		    $session = 'Sesi';
		    $course_name_data = $course->course_name;
		    $total_lecture = 'Jumlah Kuliah';
		    $total_tutorial = 'Jumlah Tutorial';
		}
		
		
		$html = '
		<table cellpadding="1" border="0">
		<tr>
			<td width="'.$w1.'"></td>
			<td width="'.$w3.'">'. $course_code .'</td>
			<td width="'.$w4.'">:</td>
			<td width="'.$w5.'">'.$course->course_code .'</td>
		</tr>';
		$html .='<tr>
			<td></td>
			<td>'. $course_name .'</td>
			<td>:</td>
			<td width="'.$w5.'">'.$course_name_data.'</td>
		</tr>';
		if($this->en){
		    $sesi = $this->model->staffInvolved->semester->sessionLongEn;
		}else{
		    $sesi = $this->model->staffInvolved->semester->sessionLong;
		}
		
		$html .='<tr>
			<td></td>
			<td>Semester</td>
			<td>:</td>
			<td>'.strtoupper($sesi).'</td>
		</tr>
		<tr>
			<td></td>
			<td>'. $session .'</td>
			<td>:</td>
			<td>'.$this->model->staffInvolved->semester->year.'</td>
		</tr>';

		if($this->model->countLecturesByStaff > 0){
		$html .='<tr>
			<td></td>
			<td>'. $total_lecture .'</td>
			<td>:</td>
			<td>'.$this->model->countLecturesByStaff.'</td>
			</tr>';
		}
		
		if($this->model->countTutorialsByStaff > 0){
			$html .= '<tr>
				<td></td>
				<td>'. $total_tutorial .'</td>
				<td>:</td>
				<td>'.$this->model->countTutorialsByStaff.'</td>
			</tr>';	
		}
		
		$html .= '</table>
		';
		$this->pdf->SetFont('arialnarrow','B', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		$this->pdf->SetMargins($this->margin_left, 10, 25);
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeEnding(){
		
		
		
		$wd = 630;
		
		if($this->template->background_file == 2){
		    $wd = 720;
		}
        
		if($this->en){
		    $per4 = $this->template->per1_en;
		    $html = '<br />
		<table width="'. $wd .'" border="0"><tr><td><span style="text-align:justify;">3. &nbsp;&nbsp;&nbsp;</span><span style="text-align:justify;">However, this appointment is subject to any changes.
		
</span>
<br /><br />
<span style="text-align:justify;">4. &nbsp;&nbsp;&nbsp;'. str_replace('{TUANPUAN}', $this->tuan, $per4). '</span><br /><br />
		Thank you.
		<br />
		</td></tr></table>';
		}else{
		    $per4 = $this->template->per1;
		    $html = '<br />
		<table  width="'. $wd .'"><tr><td><span style="text-align:justify;">3. &nbsp;&nbsp;</span><span style="text-align:justify;">Untuk makluman, pelantikan ini adalah berkuatkuasa daripada semester berkenaan tertakluk kepada perubahan.
		

</span>
<br /><br />
<span style="text-align:justify;">4. &nbsp;&nbsp;&nbsp;</span><span style="text-align:justify;">'.str_replace('{TUANPUAN}', $this->tuan, $per4).'</span><br /><br />
		Sekian.';
		    if($this->template->background_file == 1){
		        $html .= '<br />';
		    }
		$html .= '</td></tr></table>';
		}
		
		
		$this->pdf->SetFont('arialnarrow','', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	

	
	public function writeSignitureImg(){
		$html = '';
		$sign = $this->template->signiture_file;
		//$html .= $sign;
		$file = Yii::getAlias('@upload/'. $sign);
		//$html .= '**' . $file;
		if(!$sign){
			return false;
		}
		
		if($this->model->status == 10){
			
		
			$html .= '
			<img src="images/dekan.png" />
			';

		}
		

		$y = $this->pdf->getY();
		$adjy = $this->template->adj_y;
		
		$posY = $y - 42 + $adjy;
		$this->pdf->setY($posY); 
$tbl = <<<EOD
$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
	}
	
	public function writeSigniture(){
		$tema = $this->template->tema;
		$tema = nl2br($tema);
		$benar = $this->template->yg_benar;
		$dekan = $this->template->dekan;
		$sk = 's.k';
		if($this->en){
		    $tda = 'Deputy Dean (Academic & Student Development)';
		    $dekan_text = 'Dean';
		    $sk = 'c.c';
		}else{
		    $tda = 'Timbalan Dekan (Akademik & Pembangunan Pelajar)';
		    $dekan_text = 'Dekan';
		    $sk = 's.k';
		}
		
		
	   $html = '<b>'.$tema.'</b>
		<br /><br />
		'.$benar.',<br /><br />';
	   
	   if($this->template->is_computer != 1){
	       $html .= '<br /><br />';
	   }
		
		
		$html .= '<b>'.strtoupper($dekan).'</b><br />';
	   
	   
		$html .=  $dekan_text . '<br /><br />';
		
		
		
		
		//$html .=  $sk .' - '. $tda .'';
		
		if($this->template->is_computer == 1){
		    $html .= '<div align="center"><i>';
		    if($this->en){
		        $html .= 'This is a computer-generated document and no signature is required.';
		    }else{
		        $html .= 'Surat ini adalah cetakan komputer dan tandatangan tidak diperlukan.';
		    }
		    
		    $html .= '</i></div><br />';
		}
		$this->pdf->SetFont('arialnarrow','', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
	}
	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('FKP');
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
