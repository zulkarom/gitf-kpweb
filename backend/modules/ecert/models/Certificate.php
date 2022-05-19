<?php
namespace backend\modules\ecert\models;

use Yii;

class Certificate
{

    public $model;

    public $pdf;

    public $filename;

    public $frontend = false;

    public function generatePdf()
    {
        $this->pdf = new StartPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $file = Yii::getAlias('@upload/' . $this->model->eventType->template_file);
        $f = basename($file);

        if ($this->frontend) {
            $this->pdf->image_background = 'web/ecert/images/ecert/' . $f;
        } else {
            $this->pdf->image_background = 'images/ecert/' . $f;
        }

        if ($this->model->eventType->is_portrait == 1) {
            $this->pdf->AddPage("P");
            $this->pdf->portrait = true;
        } else {
            $this->pdf->portrait = false;
            $this->pdf->AddPage("L");
        }

        $this->startPage();
        $this->writeData();

        $this->pdf->Output($this->filename . '.pdf', 'I');
    }

    public function writeData()
    {
        $this->pdf->SetFont('helvetica', 'b', 10);
        $this->pdf->SetTextColor(35, 22, 68);

        $all = 740;

        $left = 70;
        $kuda = 260;
        $laju = 157;
        $jarak = 153;
        $right = $all - $left - $kuda - $laju - $jarak;

        $html = '<table border="0">
<tr>
<td colspan="2" height="330"></td>
</tr>

<tr>
<td width="170"></td>
<td align="center" width="740" style="font-size:17pt"></td>
</tr>

<tr>
<td colspan="2" height="493"></td>
</tr>




</table>';
        $tbl = <<<EOD
        		$html
        EOD;

        $this->pdf->writeHTML($tbl, true, false, false, false, '');
    }

    public function startPage()
    {
        $this->filename = 'ECERT';
        $this->pdf->SetCreator(PDF_CREATOR);
        $this->pdf->SetAuthor('FKP PORTAL');
        $this->pdf->SetTitle('ECERT');
        $this->pdf->SetSubject('ECERT');
        $this->pdf->SetKeywords('');

        // set default header data
        $this->pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        // $this->pdf->writeHTML("<strong>hai</strong>", true, 0, true, true);
        // set header and footer fonts
        $this->pdf->setHeaderFont(Array(
            PDF_FONT_NAME_MAIN,
            '',
            PDF_FONT_SIZE_MAIN
        ));
        $this->pdf->setFooterFont(Array(
            PDF_FONT_NAME_DATA,
            '',
            PDF_FONT_SIZE_DATA
        ));

        // set default monospaced font
        $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        // $this->pdf->SetMargins(25, 10, PDF_MARGIN_RIGHT);
        $this->pdf->SetMargins(0, 0, 0);
        // $this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->pdf->SetHeaderMargin(0);

        // $this->pdf->SetHeaderMargin(0, 0, 0);
        $this->pdf->SetFooterMargin(0);

        // set auto page breaks
        $this->pdf->SetAutoPageBreak(false, 0); // margin bottom

        // set image scale factor
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once (dirname(__FILE__) . '/lang/eng.php');
            $this->pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        $this->pdf->setImageScale(1.53);

        // add a page
    }
}
