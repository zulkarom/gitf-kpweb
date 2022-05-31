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
            $this->pdf->image_background = '../images/ecert/' . $f;
        } else {
            $this->pdf->image_background = 'images/ecert/' . $f;
        }

        $this->startPage();
        $this->writeData();

        $this->pdf->Output($this->filename . '.pdf', 'I');
    }

    public function writeData()
    {
        $this->pdf->SetFont('helvetica', 'b', 10);
        $this->pdf->SetTextColor(35, 22, 68);
        $html = '';
        $preset = $this->model->eventType->set_type;
        if ($preset == 1) {
            $html .= $this->html_preset();
        } else {
            $html = $this->model->eventType->custom_html;
        }

        $tbl = <<<EOD
        		$html
        EOD;

        $this->pdf->writeHTML($tbl, true, false, false, false, '');
    }

    public function html_preset()
    {
        $portrait = $this->model->eventType->is_portrait;
        if ($portrait == 1) {
            $all = 740;
        } else {
            $all = 1290;
        }

        $left = $this->model->eventType->margin_left;
        $left = $left > 1 ? $left : 1;
        $right = $this->model->eventType->margin_right;
        $right = $right > 1 ? $right : 1;
        $main = $all - $right - $left;

        $margin_name = $this->model->eventType->name_mt;
        $margin_field1 = $this->model->eventType->field1_mt;

        $html = '<table border="0" width="' . $all . '">
<tr>
    <td width="' . $left . '"></td>
    <td align="center" width="' . $main . '">';

        $html .= '<table>';

        if ($margin_name > 0) {
            $size = $this->model->eventType->name_size;
            $html .= '
<tr><td height="' . $margin_name . '"></td></tr>
<tr><td style="font-size:' . $size . 'px">' . strtoupper($this->model->participant_name) . '</td></tr>';
        }

        if ($margin_field1 > 0) {
            $size = $this->model->eventType->field1_size;
            $html .= '
<tr><td height="' . $margin_field1 . '"></td></tr>
<tr><td style="font-size:' . $size . 'px">' . strtoupper($this->model->field1) . '</td></tr>';
        }

        $html .= '</table>';

        $html .= '</td>
    <td width="' . $right . '"></td>
</tr>';
        $html .= '</table>';

        return $html;
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
        // $this->pdf->SetAutoPageBreak(false, 0); // margin bottom
        $this->pdf->SetAutoPageBreak(TRUE, - 30); // margin bottom

        // set image scale factor
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once (dirname(__FILE__) . '/lang/eng.php');
            $this->pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        $this->pdf->setImageScale(1.53);

        if ($this->model->eventType->is_portrait == 1) {
            $this->pdf->AddPage("P");
            $this->pdf->portrait = true;
        } else {
            $this->pdf->portrait = false;
            $this->pdf->AddPage("L");
        }

        // add a page
    }
}
