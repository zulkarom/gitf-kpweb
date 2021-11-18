<?php

namespace backend\modules\esiap\models;

use Yii;
use common\models\Common;
use backend\models\Faculty;


class Fk3Word
{
	public $model;
	public $pdf;
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

	    $phpWord = new \PhpOffice\PhpWord\PhpWord();
	    
	    $phpWord->setDefaultFontSize(12);
	    $phpWord->setDefaultFontName('arial narrow');
	    
	    
	    /* Note: any element you append to a document must reside inside of a Section. */
	    
	    // Adding an empty Section to the document...
	    $section = $phpWord->addSection(['marginTop' => 900, 'marginLeft' => 500, 'marginRight' => 500]);
	    
	    $sectionStyle = $section->getStyle();
	    $sectionStyle->setOrientation($sectionStyle::ORIENTATION_LANDSCAPE);

	    $styleTable = array('borderSize' => 15, 'unit' => 'pct', 'width' => 5000, 'cellMargin' => 60);
	    
	    $table1 = $section->addTable($styleTable);
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
	        //'posHorizontalRel' => 'margin',
	        //'posVerticalRel' => 'line',
	    );
	    $section->addImage('images/umk-doc.png', $imageStyle); 
	    
	    // Saving the document as OOXML file...
	    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
	    
	    header("Content-Disposition: attachment; filename=FK03.docx");
	    
	    $objWriter->save("php://output");
	    

	}

	
}
