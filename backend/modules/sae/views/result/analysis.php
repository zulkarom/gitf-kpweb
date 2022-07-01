<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use yii\bootstrap4\Modal;
use kartik\export\ExportMenu;
use yii\grid\GridView;
use yii\helpers\Url;
use softark\duallistbox\DualListbox;
use yii\widgets\ActiveForm;



$this->title = 'Analysis';
$this->params['breadcrumbs'][] = ['label' => 'Participants', 'url' => ['/answer/index']];
$this->params['breadcrumbs'][] = ['label' => 'Overall Result', 'url' => ['index', 'bat_id' => $analysis->batch->id ]];
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\DualListboxAsset::register($this);

?>

<div class="result-index">
<div class="card card-primary">
<div class="card-body">
<div class="row">
<!-- <div class="col-2">
</div> -->
<div class="col-md-8">



           <?php $form = ActiveForm::begin([
                'id' => 'favorite-form',
                'enableAjaxValidation' => false,
            ]); ?>
			
			
<div class="listbox-area">
  <div class="left-area">
    <span id="ms_av_l" class="listbox-label"><b>Available Domain</b></span>
    <ul id="ms_imp_list" tabindex="0" role="listbox" style="height: 250px; overflow:auto" aria-labelledby="ms_av_l" aria-multiselectable="true">
	<?php 
	if($analysis->aval_domains){
		foreach($analysis->aval_domains as $aval){
			echo '<li id="ms_opt'.$aval->id.'" data-value="'.$aval->id.'" role="option" aria-selected="false">'.$aval->gcat_text.'</li>';
		}
	}
	
	?>
     
    </ul>
    <button type="button" id="ex2-add" class="move-right-btn calc-domain" aria-keyshortcuts="Alt+ArrowRight Enter" aria-disabled="true">Add</button>
  </div>
  <div class="right-area">
    <span id="ms_ch_l" class="listbox-label"><b>Selected Domain</b></span>
    <ul id="ms_unimp_list" style="height: 250px; overflow:auto" tabindex="0" role="listbox" aria-labelledby="ms_ch_l" aria-activedescendant="" aria-multiselectable="true">
	<?php 
	$sd = [];
	if($analysis->sel_domains){
		
		foreach($analysis->sel_domains as $aval){
			$sd[] = $aval->grade_cat;
			echo '<li id="ms_opt'.$aval->grade_cat.'" data-value="'.$aval->grade_cat.'" role="option" aria-selected="false">'.$aval->category->gcat_text.'</li>';
		}
	}
	
	?>
    </ul>
    <button type="button" id="ex2-delete" class="move-left-btn calc-field" aria-keyshortcuts="Alt+ArrowLeft Delete" aria-disabled="true">Remove</button>
  </div>

</div>
<?=$form->field($analysis, 'domains')->hiddenInput(['value' => json_encode($sd)])->label(false)?>

<div class="row">
<div class="col-md-4"> <?= $form->field($analysis, 'point_min', ['template' => '{label}{input}<i>Value from 1 to 20 <br /> leave blank if not applicable</i>{error}'])->input('number', ['min' => 1, 'step' => 1]) ?></div>

<div class="col-md-3"> <?= $form->field($analysis, 'point_min_total', ['template' => '{label}{input}<i>Value from 1 to 120 <br /> leave blank if not applicable</i>{error}'])->input('number', ['min' => 1, 'step' => 1]) ?></div>

</div>

<?php 

if($analysis->demoList()){
	foreach($analysis->demoList() as $key => $demo){
		listBoxDemo($analysis, $key, $demo, $form);
	}
}

?>


<div class="row">
<div class="col-md-3"> <?= $form->field($analysis, 'limit', ['template' => '{label}{input}<i>e.g. 30, 50, 100 <br /> leave blank to show all</i>{error}'])->input('number', ['min' => 1, 'step' => 1])->label('Result Limit') ?></div>



</div>
    
   

<div class="form-group">
	<?= Html::a('RESET', ['analysis', 'id' => $analysis->batch->id, 'reset' => 1], [
            'class' => 'btn btn-default'
        ]) ?>
        <?= Html::submitButton('SAVE & VIEW RESULT', [
            'class' => 'btn btn-info', 'id' => 'btn-save'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
        
</div>

</div>

</div>
</div>
</div>

<?php 
function listBoxDemo($analysis, $colum, $text, $form){
		$field = 'colum' . $colum;
		$attr_sel = '';
		$attr_aval = '';
	?>
	<div class="listbox-area">
  <div class="left-area">
    <span id="ms_av_l" class="listbox-label"><b>Available <?=$text?></b></span>
    <ul id="ms_imp_list<?=$colum?>" tabindex="0" role="listbox" style="height: 250px; overflow:auto" aria-labelledby="ms_av_l" aria-multiselectable="true">
	<?php
	$available = $analysis->getAvailableColumn($colum);
	if($available){
		foreach($available as $key => $aval){
			echo '<li id="ms_opt'.$key.'" data-value="'.$aval[0].'" role="option" aria-selected="false">'.$aval[0].' ('.$aval[1].')</li>';
		}
	}
	?>
    </ul>
    <button type="button" id="ex2-add<?=$colum?>" class="move-right-btn calc-domain" aria-keyshortcuts="Alt+ArrowRight Enter" aria-disabled="true">Add</button>
  </div>
  <div class="right-area">
    <span id="ms_ch_l" class="listbox-label"><b>Selected <?=$text?></b></span>
    <ul id="ms_unimp_list<?=$colum?>" style="height: 250px; overflow:auto" tabindex="0" role="listbox" aria-labelledby="ms_ch_l" aria-activedescendant="" aria-multiselectable="true">
	<?php 
	$selected = $analysis->getSelectedColumn($colum);
	$sd = [];
	if($selected){
		foreach($selected as $key => $aval){
			$sd[] = $key;
			echo '<li id="ms_opt'.$key.'" data-value="'.$aval[0].'" role="option" aria-selected="false">'.$aval[0].' ('.$aval[1].')</li>';
		}
	}
	
	?>
    </ul>
    <button type="button" id="ex2-delete<?=$colum?>" class="move-left-btn calc-field" aria-keyshortcuts="Alt+ArrowLeft Delete" aria-disabled="true">Remove</button>
  </div>

</div>
<?=$form->field($analysis, $field)->hiddenInput(['value' => json_encode($sd)])->label(false)?>	
	
<?php
}

$script = '';
for($i=1;$i<=4;$i++){
	$script .= 'if($("ul#ms_unimp_list'.$i.'").length){
			const arr'.$i.' = [];
			$("ul#ms_unimp_list'.$i.' li").each(function(){
				val = $(this).attr("data-value");
				arr'.$i.'.push(val);
			});
			$("#analysisform-colum'.$i.'").val(JSON.stringify(arr'.$i.'));
		}';
}

$this->registerJs('
	$("#btn-save").click(function(){
		const arr = [];
		var val;
		$("ul#ms_unimp_list li").each(function(){
			val = parseInt($(this).attr("data-value"));
			arr.push(val);
		});
		$("#analysisform-domains").val(JSON.stringify(arr));
		
		'. $script .'
		
		
		
		
	});
');


?>
