<?php

namespace backend\modules\sae\models\pdf;

use Yii;


class MYPDF_individual extends \TCPDF {

    //Page header
    public function Header() {
		//$this->myX = $this->getX();
		//$this->myY = $this->getY();
		//$savedX = $this->x;
		//savedY = $this->y;

        $this->SetFont('times', '', 10);
		 $html = 'hai';
		//$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
	 
		//$this->setX($this->myX);
		//$this->setY($this->myY);
		$this->setY(10);
		//$this->SetY($savedY);
		//$this->SetX($savedX);
        // Title
       $this->Cell(0, 10, 'SAE - ONLINE INTERVIEW', 0, 1, 'R', 0, '', 0, false, 'M', 'M');

	    $this->SetTopMargin($this->GetY() + 2);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-30);
		 $html = '';
		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

?>