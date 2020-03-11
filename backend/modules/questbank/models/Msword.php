<?php

namespace backend\modules\questbank\models;

use Yii;
use backend\modules\esiap\models\Course;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\TablePosition;


class Msword
{
	public $model;
	
   public function generate(){

	$languageEnGb = new \PhpOffice\PhpWord\Style\Language(\PhpOffice\PhpWord\Style\Language::EN_GB);

	$phpWord = new \PhpOffice\PhpWord\PhpWord();
	$phpWord->getSettings()->setThemeFontLang($languageEnGb);
	
	$styleBm = array('name' => 'Arial', 'size' => 11, 'spaceAfter' =>  \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));
	$styleBi = array('name' => 'Arial', 'size' => 11, 'italic' => true, 'spaceAfter' =>  \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0));


	$fontStyleName = 'bmStyle';
	
	$phpWord->addFontStyle($fontStyleName, array('bold' => true, 'italic' => true, 'size' => 16, 'allCaps' => true, 'doubleStrikethrough' => true));

	$paragraphStyleName = 'pStyle';
	$phpWord->addParagraphStyle($paragraphStyleName, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));

	$phpWord->addTitleStyle(1, array('bold' => true), array('spaceAfter' => 240));
	// New portrait section
	$section = $phpWord->addSection();

	// Simple text
	$section->addTitle('Welcome to PhpWord', 1);
	
	$section->addText('Hello World!');
	
	$questions = $this->model->questions;
	if($questions ){
		foreach($questions as $quest){
			$section->addText($quest->qtext, $styleBm);
			//$section->addTextBreak();
			$section->addText($quest->qtext_bi, $styleBi);
		}
		
	}
	
	
	$header = array('size' => 16, 'bold' => true);
	$rows = 10;
	$cols = 5;
	
	$section->addText('Basic table', $header);

	$table = $section->addTable();
	for ($r = 1; $r <= 8; $r++) {
		$table->addRow();
		for ($c = 1; $c <= 5; $c++) {
			$table->addCell(1750)->addText("Row {$r}, Cell {$c}");
		}
	}

	// Inline font style
	

	//$textrun = $section->addTextRun();
	//textrun->addText('I am inline styled ', $fontStyle);


	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
	
	
	$fileName = "question.docx";
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=" . $fileName);
	header("Content-Transfer-Encoding: binary");    
	$objWriter->save("php://output");
	
   }
   
   public function question(){
	   
   }

}


