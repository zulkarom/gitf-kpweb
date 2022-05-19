<?php
namespace backend\modules\ecert\models;

class StartPdf extends \TCPDF
{

    public $image_background = null;

    public $portrait = true;

    // Page header
    public function Header()
    {
        if ($this->image_background) {
            $img_file = $this->image_background;
            if ($this->portrait) {
                $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
            } else {
                $this->Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
            }
        }
    }

    // Page footer
    public function Footer()
    {}
}
