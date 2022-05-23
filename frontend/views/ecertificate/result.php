<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\proceedings\models\ProceedingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'E-certificate Search Result';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="proceeding-index">


<section class="contact-page spad pt-0">
        <div class="container">

	<h3><?=Html::encode($this->title)?></h3>
	<br />



<div class="row">
<div class="col-md-10">
<?=$model->listEvents()[$model->event]?> / <?=$model->identifier?>
</div>

</div>
<br /><br />
<div class="row">

<div class="col-md-5">

<?php

if ($docs) {
    echo '<table>';
    foreach ($docs as $doc) {
        echo '<tr>';
        echo '<td width="25"><i class="fa fa-certificate"></i></td><td> <i>' . $doc->type_name . '</i></td>';

        echo '</tr>';

        echo '<tr>';
        echo '<td></td><td>';
        echo strtoupper($doc->participant_name);
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td></td><td>';
        echo strtoupper($doc->participant_name);
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'No result found';
}

?>

</div>

</div>
<br /><br />
<div class="form-group">
<a href="<?=Url::to(['index'])?>">Back to search form</a>
</div>















	        </div>
    </section>

</div>
