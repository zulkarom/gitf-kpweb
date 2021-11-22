<?php

namespace backend\modules\esiap\models;

use Yii;
use common\models\Common;
use backend\models\Faculty;


class Fk3Word
{
	public $model;
	public $section;
	public $word;
	public $table;
	public $directoryAsset;
	public $total_lec = 0;
	public $total_tut = 0;
	public $total_prac = 0;
	public $total_hour = 0;
	public $offer = false;
	public $cqi = false;
	public $xana = false;
	public $group = false;
	
	public $wtab;
	
	public function generate(){
		
	    $this->word = new \PhpOffice\PhpWord\PhpWord();
	    $this->word->setDefaultFontSize(12);
	    $this->word->setDefaultFontName('arial narrow');
		$this->word->setDefaultParagraphStyle(array('align' => 'both', 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0));
	    $this->section = $this->word->addSection(['marginTop' => 900, 'marginLeft' => 600, 'marginRight' => 600]);
	    $sectionStyle = $this->section->getStyle();
	    $sectionStyle->setOrientation($sectionStyle::ORIENTATION_LANDSCAPE);
	    $this->headerPage();
		$this->headerInfo();
		$this->headerClo();
		$this->headerClo2();
		$this->cloData();
		$this->note();
		//$this->sampleSpan();
		$this->saveDoc();
	    
	}
	
	
	
	public function headerPage(){
		$styleTable = array('borderSize' => 15, 'unit' => 'pct', 'width' => 5000, 'cellMargin' => 60);
	    
	    $table1 = $this->section->addTable($styleTable);
	    $table1->addRow();
	    $cell1 = $table1->addCell();
	    $styleTable2 = array('borderSize' => 6, 'unit' => 'pct', 'width' => 5000, 'cellMargin' => 60);
	    $table = $cell1->addTable($styleTable2);
	    $table->addRow();
	    $cell = $table->addCell();
	       $fontFK = array('size' => 11);
	       $paraFK = array('align'=>'right', 'spaceBefore'=>0, 'spaceafter' => 0);
	    $cell->addText(htmlspecialchars('UMK/AKAD/P&P/FK03'), $fontFK, $paraFK);
	       $fontTitle = array('bold' => true);
	       $paraTitle = array('align'=>'center', 'spaceBefore'=>0, 'spaceafter' => 0);
	    $cell->addText(htmlspecialchars('PENJAJARAN KONSTRUKTIF KURSUS DAN PROGRAM PENGAJIAN'), $fontTitle, $paraTitle);
	       $fontTitleEn = array('bold' => true, 'italic' => true);
	       $paraTitleEn = array('align'=>'center', 'spaceBefore'=>0, 'spaceafter' => 120);
	    $cell->addText(htmlspecialchars('CONSTRUCTIVE ALIGNMENT OF STUDY COURSE AND PROGRAMME'), $fontTitleEn, $paraTitleEn);
	    

	    $imageStyle = array(
	        'width' => 25,
	        'wrappingStyle' => 'infront',
	        'positioning' => 'absolute',
	        'posHorizontal' => 'absolute',
	        'posVertical' => 'absolute',
	        'marginLeft' => 10,
	        'marginTop' => -58,
			'spaceafter' => 0
	        //'posHorizontalRel' => 'margin',
	        //'posVerticalRel' => 'line',
	    );
	    $this->section->addImage('images/umk-doc.png', $imageStyle); 
	}
	
	public function headerInfo(){
		$styleTable = array('borderSize' => 6, 'unit' => 'pct', 'width' => 5000, 'cellMargin' => 60);
		
	    $table = $this->section->addTable($styleTable);
	    $table->addRow();
	    $cell = $table->addCell(5350, ['bgColor' => 'd9d9d9']);
	       $fontTitle = array('bold' => true, 'size' => 10);
		   $fontTitleItalic = array('bold' => true, 'size' => 10, 'italic' => true);
	       $paraTitle = array('align'=>'left', 'spaceBefore'=>0, 'spaceafter' => 0);
			$cell->addText(htmlspecialchars('Kod Kursus:'), $fontTitle, $paraTitle);
			$cell->addText(htmlspecialchars('Course Code:'), $fontTitleItalic, $paraTitle);
		$cell = $table->addCell(null, ['bgColor' => 'd9d9d9', 'gridSpan' => 3]);
			$cell->addText(htmlspecialchars('Nama Kursus:'), $fontTitle, $paraTitle);
			$cell->addText(htmlspecialchars('Course Name:'), $fontTitleItalic, $paraTitle);
		
		 $table->addRow();
	    $cell = $table->addCell(null, ['bgColor' => 'd9d9d9']);
	       $fontTitle = array('bold' => true, 'size' => 10);
	       $paraTitle = array('align'=>'left', 'spaceBefore'=>0, 'spaceafter' => 0);
	    $cell->addText(htmlspecialchars('Prasyarat:'), $fontTitle, $paraTitle);
		$cell->addText(htmlspecialchars('Pre-requisite(s):'), $fontTitleItalic, $paraTitle);
		$cell = $table->addCell(8000, ['bgColor' => 'd9d9d9', 'gridSpan' => 2]);
	    $cell->addText(htmlspecialchars('Jam Pembelajaran Pelajar (JPP):'), $fontTitle, $paraTitle);
		$cell->addText(htmlspecialchars('Student Learning Time (SLT):'), $fontTitleItalic, $paraTitle);
		$cell = $table->addCell(null, ['bgColor' => 'd9d9d9']);
			$cell->addText(htmlspecialchars('Kredit:'), $fontTitle, $paraTitle);
			$cell->addText(htmlspecialchars('Credit:'), $fontTitleItalic, $paraTitle);
			
		$table->addRow();
	    $cell = $table->addCell(null, ['bgColor' => 'd9d9d9']);
	       $fontTitle = array('bold' => true, 'size' => 10);
	       $paraTitle = array('align'=>'left', 'spaceBefore'=>0, 'spaceafter' => 0);
	    $cell->addText(htmlspecialchars('Fakulti/ Pusat:'), $fontTitle, $paraTitle);
		$cell->addText(htmlspecialchars('Faculty/ Centre:'), $fontTitleItalic, $paraTitle);
		$cell = $table->addCell(5500, ['bgColor' => 'd9d9d9']);
	    $cell->addText(htmlspecialchars('Jabatan:'), $fontTitle, $paraTitle);
		$cell->addText(htmlspecialchars('Department:'), $fontTitleItalic, $paraTitle);
		$cell = $table->addCell(null, ['bgColor' => 'd9d9d9', 'gridSpan' => 2]);
			$cell->addText(htmlspecialchars('Program:'), $fontTitle, $paraTitle);
			$cell->addText(htmlspecialchars('Programme:'), $fontTitleItalic, $paraTitle);
	}
	
	public function headerClo(){
		$this->section->addTextBreak(1);
		$styleTable = array('borderSize' => 6, 'unit' => 'pct', 'width' => 5000, 'cellMargin' => 60);
		$fontTitle = array('bold' => true, 'size' => 10);
	   $fontTitleItalic = array('bold' => true, 'size' => 10, 'italic' => true);
	   $paraTitle = array('align'=>'center',  'spaceBefore'=>0, 'spaceafter' => 0);
	   
	   $assess = $this->model->assessments;
		$as_span = count($assess) + 1;
	   
	    $this->table = $this->section->addTable($styleTable);
	    $this->table->addRow();
	    $cell = $this->table->addCell(4500, ['valign' => 'center', 'gridSpan' => 2]);
			$cell->addText('HASIL PEMBELAJARAN KURSUS (HPK)/', $fontTitle, $paraTitle);
			$cell->addText('COURSE LEARNING OUTCOMES (CLOs)', $fontTitleItalic, $paraTitle);
		$cell = $this->table->addCell(2100, ['valign' => 'top', 'gridSpan' => 3]);
			$cell->addText('TAHAP TAKSONOMI/', $fontTitle, $paraTitle);
			$text = $cell->addTextRun(['align' => 'center']);
				$text->addText('TAXONOMY LEVEL ', $fontTitleItalic, $paraTitle);
				$text->addText('DAN/', $fontTitle, $paraTitle);
				$text->addText('AND', $fontTitleItalic, $paraTitle);
			$text = $cell->addTextRun(['align' => 'center']);
				$text->addText('HPP/', $fontTitle, $paraTitle);
				$text->addText('PLO', $fontTitleItalic, $paraTitle);
		$cell = $this->table->addCell(null, ['valign' => 'center']);
			$text = $cell->addTextRun(['align' => 'center']);
				$text->addText('KI/', $fontTitle, $paraTitle);
				$text->addText('(SS)*', $fontTitleItalic, $paraTitle);
		$cell = $this->table->addCell(null, ['valign' => 'center', 'gridSpan' => $as_span]);
			$cell->addText('KAEDAH PENTAKSIRAN/', $fontTitle, $paraTitle);
			$cell->addText('ASSESSMENT METHODS', $fontTitleItalic, $paraTitle);
		$cell = $this->table->addCell(null, ['valign' => 'center']);
			$cell->addText('TEKNIK PENYAMPAIAN/', $fontTitle, $paraTitle);
			$cell->addText('DELIVERY TECHNIQUE', $fontTitleItalic, $paraTitle);
		$cell = $this->table->addCell(null, ['valign' => 'center']);
			$cell->addText('PENCAPAIAN PELAJAR/', $fontTitle, $paraTitle);
			$cell->addText('STUDENT ACHIEVEMENT', $fontTitleItalic, $paraTitle);
			$cell->addText('(0-4)**', $fontTitleItalic, $paraTitle);
		$cell = $this->table->addCell(null, ['valign' => 'center']);
			$cell->addText('ANALISIS PENCAPAIAN/', $fontTitle, $paraTitle);
			$cell->addText('ACHIEVEMENT ANALYSIS +', $fontTitleItalic, $paraTitle);
	}
	
	public function headerClo2(){
		$fontTitle = array('size' => 10);
	   $paraTitle = array('align'=>'left',  'spaceBefore'=>0, 'spaceafter' => 0);
	   $paraCenter = array('align'=>'center',  'spaceBefore'=>0, 'spaceafter' => 0);
	   
		$assess = $this->model->assessments;
	    $this->table->addRow(1550);
	    $cell = $this->table->addCell(250, ['valign' => 'center']);
		$cell = $this->table->addCell();
			$cell = $this->table->addCell();
				$cell->addText('C', $fontTitle, $paraCenter);
			$cell = $this->table->addCell();
				$cell->addText('P', $fontTitle, $paraCenter);
			$cell = $this->table->addCell();
				$cell->addText('A', $fontTitle, $paraCenter);
		$cell = $this->table->addCell(null, ['valign' => 'center']);
			$bt = ['textDirection'=>\PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR];
			if($assess){
				foreach($assess as $as){
					$cell = $this->table->addCell(null, $bt);
					$cell->addText($as->assess_name, $fontTitle, $paraTitle);
				}
			}
			
			$cell = $this->table->addCell(null, $bt);
			$cell->addText('Total/Weight',  $fontTitle, $paraTitle);
		$cell = $this->table->addCell(null, ['valign' => 'center']);
		$cell = $this->table->addCell(null, ['valign' => 'center']);
		$cell = $this->table->addCell(null, ['valign' => 'center']);
	}
	
	public function cloData(){
		$fontTitle = array('size' => 10);
		$fontTitleEn = array('size' => 10, 'italic' => true);
	   $para = array('align'=>'left',  'spaceBefore'=>0, 'spaceafter' => 0);
	   $paraCenter = array('align'=>'center',  'spaceBefore'=>0, 'spaceafter' => 0);
		$assess = $this->model->assessments;
		
		$clos = $this->model->clos;
		$gtotal = 0;
		if($clos){
			foreach($clos as $i => $clo){
				$num = $i + 1;
				$this->table->addRow();
				$cell = $this->table->addCell(null, ['valign' => 'center']);
				$cell->addText($num . '.', $fontTitle, $paraCenter);
				$cell = $this->table->addCell(null, ['valign' => 'center']);
				$cell->addText($clo->clo_text, $fontTitle, $para);
				$cell->addText($clo->clo_text_bi, $fontTitleEn, $para);
					$cell = $this->table->addCell();
						$a = 1;
						for($c=1;$c<=6;$c++){
							$prop = 'C'.$c;
							if($clo->{$prop} == 1){
								$comma = $a == 1 ? '' : ', ';
								$a++;
								$cell->addText($comma.$prop, $fontTitle, $paraCenter);
								$cell->addText('('. $clo->plo . ')', $fontTitle, $paraCenter);
								
							}
						} 
					$cell = $this->table->addCell();
						$a = 1;
						for($c=1;$c<=7;$c++){
							$prop = 'P'.$c;
							if($clo->{$prop} == 1){
								$comma = $a == 1 ? '' : ', ';
								$a++;
								$cell->addText($comma.$prop, $fontTitle, $paraCenter);
								$cell->addText('('. $clo->plo . ')', $fontTitle, $paraCenter);
								
							}
						}
					$cell = $this->table->addCell();
						$a = 1;
						for($c=1;$c<=5;$c++){
							$prop = 'A'.$c;
							if($clo->{$prop} == 1){
								$comma = $a == 1 ? '' : ', ';
								$a++;
								$cell->addText($comma.$prop, $fontTitle, $paraCenter);
								$cell->addText('('. $clo->plo . ')', $fontTitle, $paraCenter);
								
							}
						}
				$cell = $this->table->addCell(null, ['valign' => 'center']);
					$cell->addText($clo->softskillStr, $fontTitle, $paraCenter);
					
					$sub = 0;
					if($assess){
						$ix = 0;
						$arr = [];
						foreach($assess as $ca){
							$val = $clo->assessPercent($ca->id);
							$val = $val == 0 ? '' : $val;
							$cell = $this->table->addCell(null);
								$cell->addText($val, $fontTitle, $para);
							$per = $clo->assessPercent($ca->id) + 0;
							$sub += $per;
						$ix++;
						}
					}
					$gtotal += $sub;
					
				$cell = $this->table->addCell(null);
					$cell->addText($sub,  $fontTitle, $paraCenter);
				$cell = $this->table->addCell(null, ['valign' => 'center']);
					$delivers = $clo->cloDeliveries;
					
					if($delivers){
						foreach($delivers as $d){
							$text = $cell->addTextRun(['align' => 'left']);
							$text->addText($d->delivery->delivery_name . '/ ',  $fontTitle, $para);
							$text->addText($d->delivery->delivery_name_bi ,  $fontTitleEn, $para);
							
						}
						
					}
					
				$cell = $this->table->addCell(null, ['valign' => 'center']);
				$cell = $this->table->addCell(null, ['valign' => 'center']);
			}
		}
		
		$this->table->addRow();
		$cell = $this->table->addCell(null, ['valign' => 'center']);
		$cell = $this->table->addCell(null, ['valign' => 'center']);
			$text = $cell->addTextRun();
			$text->addText('Jumlah / ', $fontTitle, $para);
			$text->addText('Total', $fontTitleEn, $para);
		$cell = $this->table->addCell();
		$cell = $this->table->addCell();
		$cell = $this->table->addCell();
		$cell = $this->table->addCell(null, ['valign' => 'center']);
			$cell->addText('', $fontTitle, $paraCenter);
			
			$sub = 0;
			if($assess){
				$ix = 0;
				$arr = [];
				foreach($assess as $ca){
					$cell = $this->table->addCell(null);
						$cell->addText($ca->assessmentPercentage, $fontTitle, $para);
				$ix++;
				}
			}

		$cell = $this->table->addCell(null);
			$cell->addText($gtotal,  $fontTitle, $paraCenter);
		$cell = $this->table->addCell(null, ['valign' => 'center']);
		$cell = $this->table->addCell(null, ['valign' => 'center']);
		$cell = $this->table->addCell(null, ['valign' => 'center']);
	}
	
	public function note(){
		$this->section->addTextBreak(1);
		$styleTable = array('border' => 0, 'unit' => 'pct', 'width' => 5000, 'cellMargin' => 60);
		$fontTitle = array('size' => 9.5);
		$fontTitleEn = array('size' => 9.5, 'italic' => true);
	   $para = array('align'=>'left',  'spaceBefore'=>0, 'spaceafter' => 0);
	   
	    $this->table = $this->section->addTable($styleTable);
	    $this->table->addRow();
	    $cell = $this->table->addCell(600);
			$cell->addText('Nota:',  $fontTitle, $para);
		$cell = $this->table->addCell();
			$text = $cell->addTextRun();
			$text->addText('HPP- Hasil Pembelajaran Program/', $fontTitle, $para);
			$text->addText('PLO- Program Learning Outcome', $fontTitleEn, $para);
			$text->addText('; KI- Kemahiran Insaniah/ SS – Soft skills.', $fontTitle, $para);
			$text->addText('SS – Soft skills.', $fontTitleEn, $para);
			
			$text = $cell->addTextRun();
			$text->addText('* Ruberik bagi KI boleh disepadu dengan ruberik pembelajaran taksonomi berkaitan/ ', $fontTitle, $para);
			$text->addText('Rubrics for soft skills can be integrated in relevant learning taxonomy (A) rubrics.', $fontTitleEn, $para);
			
			$text = $cell->addTextRun();
			$text->addText('** Purata markah (jumlah markah/ bil. pelajar) dibahagikan dengan pemberat setiap HPK didarab dengan 4.0/ ', $fontTitle, $para);
			$text->addText('Average mark (total marks/no. of students) divided by weightage of each CLO multiplied by 4.0.', $fontTitleEn, $para);
			
			$text = $cell->addTextRun();
			$text->addText('+ 0.00-0.99 (Sangat Lemah/ ', $fontTitle, $para);
			$text->addText('Very Poor', $fontTitleEn, $para);
			$text->addText('), 1.00-1.99 (Lemah/ ', $fontTitle, $para);
			$text->addText('Poor', $fontTitleEn, $para);
			$text->addText('), 2.00-2.99 (Baik/ ', $fontTitle, $para);
			$text->addText('Good', $fontTitleEn, $para);
			$text->addText('), 3.00-3.69 (Sangat Baik/ ', $fontTitle, $para);
			$text->addText('Very Good', $fontTitleEn, $para);
			$text->addText('), 3.70-4.00 (Cemerlang/ ', $fontTitle, $para);
			$text->addText('Excellent', $fontTitleEn, $para);
			$text->addText('). Laporan pencapaian pelajar ini dibuat pada penghujung semester kursus ditawarkan/ ', $fontTitle, $para);
			$text->addText('This achievement report of students is done at the end of the semester of the course offered.', $fontTitleEn, $para);
		
	}
	
	
	
	public function sampleSpan(){
		$header = array('size' => 16, 'bold' => true);
		//$this->section->addPageBreak();
		$this->section->addText('Table with colspan and rowspan', $header);

		$fancyTableStyle = array('borderSize' => 6, 'borderColor' => '999999');
		$cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'FFFF00');
		$cellRowContinue = array('vMerge' => 'continue');
		$cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
		$cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
		$cellVCentered = array('valign' => 'center');

		$spanTableStyleName = 'Colspan Rowspan';
		$this->word->addTableStyle($spanTableStyleName, $fancyTableStyle);
		$table = $this->section->addTable($spanTableStyleName);

		$table->addRow();

		$cell1 = $table->addCell(2000, $cellRowSpan);
		$textrun1 = $cell1->addTextRun($cellHCentered);
		$textrun1->addText('A');
		$textrun1->addFootnote()->addText('Row span');

		$cell2 = $table->addCell(4000, $cellColSpan);
		$textrun2 = $cell2->addTextRun($cellHCentered);
		$textrun2->addText('B');
		$textrun2->addFootnote()->addText('Column span');

		$table->addCell(2000, $cellRowSpan)->addText('E', null, $cellHCentered);

		$table->addRow();
		$table->addCell(null, $cellRowContinue);
		$table->addCell(2000, $cellVCentered)->addText('C', null, $cellHCentered);
		$table->addCell(2000, $cellVCentered)->addText('D', null, $cellHCentered);
		$table->addCell(null, $cellRowContinue);

	}
	
	public function saveDoc(){
		// Saving the document as OOXML file...
	    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->word, 'Word2007');
	    
	    header("Content-Disposition: attachment; filename=FK03.docx");
	    
	    $objWriter->save("php://output");
	}

	
}
