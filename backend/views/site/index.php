<?php

use backend\modules\erpd\models\Stats;
use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */

$this->title = 'Dashboard';

?>
<div class="box">
<div class="box-header">
<h3 class="box-title">Staff</h3>
</div>
<div class="box-body">



<div class="row">


<div class="col-md-6">

<div class="table-responsive">
  <table class="table table-striped table-hover">

    <tbody>
      <tr>
        <td>Staff Name</td>
        <td></td>
      </tr>
	  <tr>
        <td>Staff No.</td>
        <td></td>
      </tr>
      <tr>
        <td>Email</td>
        <td></td>
      </tr>
	  <tr>
        <td>Type</td>
        <td></td>
      </tr>

    </tbody>
  </table>
</div>
</div>

<div class="col-md-6">

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tbody>
	<tr>
        <td>Position</td>
        <td></td>
      </tr>
      <tr>
        <td>Staff Education (abbr.)</td>
        <td></td>
      </tr>
	  <tr>
        <td>Office Location</td>
        <td></td>
      </tr>

    </tbody>
  </table>
</div>

<button class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit Information</button>


</div>

</div>


</div>
</div>

