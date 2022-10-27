<?php

namespace backend\modules\esiap\models;

use Yii;
use common\models\Common;
use backend\models\Faculty;


class Fk1Word
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
		$this->section = $this->word->addSection(['marginTop' => 900, 'marginLeft' => 900, 'marginRight' => 900, 'marginBottom' => 900]);
	    $sectionStyle = $this->section->getStyle();
	    $sectionStyle->setOrientation($sectionStyle::ORIENTATION_PORTRAIT);
	    $this->headerPage();
		$this->headerInfo();
		//$this->headerClo();
		//$this->headerClo2();
		//$this->cloData();
		//$this->note();
		//$this->cqi();
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
	    $cell->addText(htmlspecialchars('UMK/AKAD/P&P/FK01'), $fontFK, $paraFK);
	       $fontTitle = array('bold' => true);
	       $paraTitle = array('align'=>'center', 'spaceBefore'=>0, 'spaceafter' => 0);
	    $cell->addText(htmlspecialchars('PRO FORMA KURSUS'), $fontTitle, $paraTitle);
	       $fontTitleEn = array('bold' => true, 'italic' => true);
	       $paraTitleEn = array('align'=>'center', 'spaceBefore'=>0, 'spaceafter' => 120);
	    $cell->addText(htmlspecialchars('COURSE PRO FORMA'), $fontTitleEn, $paraTitleEn);
	    

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
		$fontTitle = array('bold' => true, 'size' => 10);
		$fontTitleItalic = array('bold' => true, 'size' => 10, 'italic' => true);
		$font = array('size' => 10);
		$fontItalic = array('size' => 10, 'italic' => true);
		$paraTitle = array('align'=>'left', 'spaceBefore'=>0, 'spaceafter' => 0);
		
		
	    $table = $this->section->addTable($styleTable);
	    $table->addRow();
	    $cell = $table->addCell(4550, ['bgColor' => 'd9d9d9']);
	        $text = $cell->addTextRun();
			$text->addText('Kod Kursus: ', $fontTitle, $paraTitle);
			$text->addText($this->model->course->course_code, $font, $paraTitle);
			$text = $cell->addTextRun();
			$text->addText('Course Code: ', $fontTitleItalic, $paraTitle);
			$text->addText($this->model->course->course_code, $fontItalic, $paraTitle);
		$cell = $table->addCell(null, ['bgColor' => 'd9d9d9', 'gridSpan' => 3]);
		    $text = $cell->addTextRun();
			$text->addText('Nama Kursus: ', $fontTitle, $paraTitle);
			$text->addText($this->model->course->course_name, $font, $paraTitle);
			$text = $cell->addTextRun();
			$text->addText('Course Name: ', $fontTitleItalic, $paraTitle);
			$text->addText($this->model->course->course_name_bi, $fontItalic, $paraTitle);
		
		 $table->addRow();
	    $cell = $table->addCell(null, ['bgColor' => 'd9d9d9']);
    	    $pre = $this->model->profile->coursePrerequisite;
    	    $text = $cell->addTextRun();
    	    $text->addText('Prasyarat: ', $fontTitle, $paraTitle);
    	    $text->addText($pre[0], $font, $paraTitle);
    	    $text = $cell->addTextRun();
    		$text->addText('Pre-requisite(s): ', $fontTitleItalic, $paraTitle);
    		$text->addText($pre[1], $fontItalic, $paraTitle);
		$cell = $table->addCell(4900, ['bgColor' => 'd9d9d9', 'gridSpan' => 2]);
		    $slt = $this->model->course->credit_hour * 40;
    		$text = $cell->addTextRun();
    	    $text->addText('Jam Pembelajaran Pelajar (JPP): ', $fontTitle, $paraTitle);
    	    $text->addText($slt, $font, $paraTitle);
    	    $text = $cell->addTextRun();
    		$text->addText('Student Learning Time (SLT): ', $fontTitleItalic, $paraTitle);
    		$text->addText($slt, $fontItalic, $paraTitle);
		$cell = $table->addCell(null, ['bgColor' => 'd9d9d9']);
		    $text = $cell->addTextRun();
			$text->addText('Kredit: ', $fontTitle, $paraTitle);
			$text->addText($this->model->course->credit_hour, $font, $paraTitle);
			$text = $cell->addTextRun();
			$text->addText('Credit:', $fontTitleItalic, $paraTitle);
			$text->addText($this->model->course->credit_hour, $fontItalic, $paraTitle);
		$table->addRow();
	    $cell = $table->addCell(null, ['bgColor' => 'd9d9d9']);
	       $text = $cell->addTextRun();
	       $text->addText('Fakulti/ Pusat: ', $fontTitle, $paraTitle);
	       $text->addText($this->model->course->faculty->faculty_name, $font, $paraTitle);
	       $text = $cell->addTextRun();
		  $text->addText('Faculty/ Centre: ', $fontTitleItalic, $paraTitle);
		  $text->addText($this->model->course->faculty->faculty_name, $fontItalic, $paraTitle);
		$cell = $table->addCell(4500, ['bgColor' => 'd9d9d9']);
    		$dep = ' - ';
    		$dep_bi = ' - ';
    		if($this->model->course->department){
    		    $dep = $this->model->course->department->dep_name;
    		    $dep_bi = $this->model->course->department->dep_name_bi;
    		}
    		$text = $cell->addTextRun();
    	    $text->addText('Jabatan: ', $fontTitle, $paraTitle);
    	    $text->addText($dep, $font, $paraTitle);
    	   // $text->addText($this->model->course->faculty->faculty_name, $font, $paraTitle);
    	    $text = $cell->addTextRun();
    		$text->addText('Department: ', $fontTitleItalic, $paraTitle);
    		$text->addText($dep_bi, $fontItalic, $paraTitle);
		$cell = $table->addCell(null, ['bgColor' => 'd9d9d9', 'gridSpan' => 2]);
    		$pro = ' - ';
    		$pro_bi = ' - ';
    		if($this->model->course->program){
    		    $pro = $this->model->course->program->pro_name;
    		    $pro_bi = $this->model->course->program->pro_name_bi;
    		}
    		$text = $cell->addTextRun();
			$text->addText('Program: ', $fontTitle, $paraTitle);
			$text->addText($pro, $font, $paraTitle);
			$text = $cell->addTextRun();
			$text->addText('Programme: ', $fontTitleItalic, $paraTitle);
			$text->addText($pro_bi, $fontItalic, $paraTitle);
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
	    
	    header("Content-Disposition: attachment; filename=FK01.docx");
	    
	    $objWriter->save("php://output");
	}

	
}
