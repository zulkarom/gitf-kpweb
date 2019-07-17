<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Update: ' . $model->course->crs_name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>

<?php $form = ActiveForm::begin(['id' => 'formsyll']); ?>
	
<div class="box">
<div class="box-header"></div>
<div class="box-body">	

    
<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>




	<table class='table table-hover table-striped'>
	<thead><tr><th width='10%'>WEEK</th><th width='10%'>CLO</th><th>TOPICS</th></tr></thead>
<?php 
$totalclo = count($clos);
foreach($syllabus as $row){ ?>
	<tr>
	<td><b>WEEK <?php echo $row->week_num ; ?></b>
	<input id="input-week-<?php echo $row->week_num ; ?>" name="input-week-<?php echo $row->week_num ; ?>" type="hidden" value="" />
	</td>
	<td>
	<?php 
	$clo = json_decode($row->clo);
	if(!$clo){
		$clo = array();
	}
	for($f=1;$f<=$totalclo;$f++){
		$check = in_array($f, $clo) ? "checked" : "";
		echo '<div class="form-group"><label><input type="checkbox" value="'.$f.'" name="'.$row->week_num.'-clo[]" '.$check.' /> CLO'.$f . "</label></div>";
	}
	
	?>
	</td>
	<td>
		<div id='topic-<?php echo $row->week_num; ?>'>
		<?php 
		$arr_all = json_decode($row->topics);
		if($arr_all){
		foreach($arr_all as $rt){
		?>
		<div class='topic-container form-group'>
		<div class='row'>
		<div class='col-md-1'><label>Topik: </label>
		<br><i>(BM)</i>
		</div>
		<div class='col-md-5'>
			<div class='form-group'>
			<textarea class='form-control topic-text'><?php echo $rt->top_bm;?></textarea>
			</div>
		</div>
		<div class='col-md-1'><label>Topic: </label><br><i>(BI)</i></div>
		<div class='col-md-5'>
			<div class='form-group'>
			<textarea class='form-control topic-text'><?php echo $rt->top_bi;?></textarea>
			</div>
		</div>
		</div>
		
		<!--  -->
		<div class='consubtopic'>
		<div class='consubtopicinput'>
		<?php 
		if($rt->sub_topic){
			foreach($rt->sub_topic as $rst){
			?>
			<div class='row-subtopic'><div class='row'>
			<div class='col-md-1'></div>
			<div class='col-md-1'><label>Sub Topik: </label><br><i>(BM)</i></div>
			<div class='col-md-4'>
			<div class='form-group'>
			<textarea class='form-control subtopic-text'><?php echo $rst->sub_bm;?></textarea>
			</div>
			</div>
			<div class='col-md-1'></div>
			<div class='col-md-1'><label>Sub Topic: </label><br><i>(BI)</i></div>
			<div class='col-md-4'>
			<div class='form-group'>
			<textarea class='form-control subtopic-text'><?php echo $rst->sub_bi;?></textarea>
			</div>
			</div>
			</div></div>
			<?php
			}
		}
		?>
		</div>
			<div class='row'>
				<div class='col-md-1'></div>
				<div class='col-md-6'>
				<button type='button' class='btn btn-default btn-sm addsubtopic' >
				<span class='glyphicon glyphicon-plus'></span> Add Sub Topic</button> <button class='btn btn-default btn-sm removesubtopic' type='button'>
				<span class='glyphicon glyphicon-remove'></span> Remove Last Sub Topic</button>
				</div>
			</div>
		</div>
		</div>
		<?php } } ?>
		</div>
		
		
		<br />
		<button type='button' class='btn btn-default' id='btn-topic-<?php echo $row->week_num;?>'>
		<span class='glyphicon glyphicon-plus'></span> Add Topic</button> <button type='button' class='btn btn-default' id='btnx-topic-<?php echo $row->week_num;?>'>
		<span class='glyphicon glyphicon-remove'></span> Remove Last Topic</button>
	
	
	
	</td>
	</tr>
<?php 
}

?>
</table>


    <div class="form-group">
        <?= Html::submitButton('SAVE SYLLABUS', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


<?php 

$js = <<<'EOD'

for(i=1;i<=14;i++){
		$("#btn-topic-"+i).click(function(){
			var att = $(this).attr('id');
			att = att.split('-');
			var week = att[2];
			$("#topic-" + week).append(genTopic());
			btnSubTopic();
			clearBtn();
			btnSubTopic();
			
		});
		$("#btnx-topic-"+i).click(function(){
			var att = $(this).attr('id');
			att = att.split('-');
			var week = att[2];
			$("#topic-" + week + " div.topic-container").last().remove();
			
		});
		
		
		
	}
	
	btnSubTopic();
	
	$('#test').click(function(){
	
	});
	

	$("form#formsyll").submit(function(){
    putJson();
	});




function putJson(){
	for(g=1;g<=14;g++){
		var myArray = [];
	var topic;
	var subtopic;
 	$("#topic-"+g+" .topic-text").each(function(i,obj){
		var val = $(this).val();
		if(isEven(i)){
			topic = new Object();
			topic.top_bm = val;
		}else{
			topic.top_bi = val;
			var mySubArray = [];
			$(this).parents('.topic-container').children('.consubtopic').children('.consubtopicinput').find('.subtopic-text').each(function(x){
				var subval = $(this).val();
				if(isEven(x)){
					subtopic = new Object();
					subtopic.sub_bm = subval;
				}else{
					subtopic.sub_bi = subval;
					mySubArray.push(subtopic);
				}
				//alert();
			});
			//alert(sel);
			topic.sub_topic = mySubArray;
			myArray.push(topic);
		}
		
	}); 
	
	var myString = JSON.stringify(myArray);
	$("#input-week-"+g).val(myString);
	
	}
	
	
}

function isEven(n) {
   return n % 2 == 0;
}

function isOdd(n) {
   return Math.abs(n % 2) == 1;
}

function clearBtn(){
	$(".addsubtopic").off('click');
	$(".removesubtopic").off('click');
}

function btnSubTopic(){
	$(".addsubtopic").click(function(){
		var sel = $(this).parents("div.consubtopic").children(".consubtopicinput");
		sel.append(genSubTopic());
	});
	$(".removesubtopic").click(function(){
		var sel = $(this).parents("div.consubtopic").children(".consubtopicinput").children("div.row-subtopic"); 
		sel.last().remove();
			
	}); 
}

function genSubTopic(){
	var html = "<div class='row-subtopic'><div class='row'>";
	html += "<div class='col-md-1'></div>";
	html += "<div class='col-md-1'><label>Sub Topik: </label><br><i>(BM)</i></div>";
	html += "<div class='col-md-4'>";
	html += "<div class='form-group'>";
	html += "<textarea class='form-control subtopic-text' ></textarea>";
	html += "</div>";
	html += "</div>";
	html += "<div class='col-md-1'></div>";
	html += "<div class='col-md-1'><label>Sub Topic: </label><br><i>(BI)</i></div>";
	html += "<div class='col-md-4'>";
	html += "<div class='form-group'>";
	html += "<textarea class='form-control subtopic-text' ></textarea>";
	html += "</div>";
	html += "</div>";
	html += "</div></div>";
	return html;
}

function genTopic(){
	var html = "<div class='topic-container form-group'>";
		html += "<div class='row'>";
		html += "<div class='col-md-1'><label>Topik: </label>";
		html += "<br><i>(BM)</i>";
		html += "</div>";
		html += "<div class='col-md-5'>";
			html += "<div class='form-group'>";
			html += "<textarea class='form-control topic-text' ></textarea>";
			html += "</div>";
		html += "</div>";
		html += "<div class='col-md-1'><label>Topic: </label><br><i>(BI)</i></div>";
		html += "<div class='col-md-5'>";
			html += "<div class='form-group'>";
			html += "<textarea class='form-control topic-text' ></textarea>";
			html += "</div>";
		html += "</div>";
		html += "</div>";
		
		html += "	<div class='consubtopic'>";
		html += "<div class='consubtopicinput'> </div>";
			html += "<div class='row'>";
				html += "<div class='col-md-1'></div>";
				html += "<div class='col-md-6'>";
				html += "<button type='button' class='btn btn-default btn-sm addsubtopic' >";
				html += "<span class='glyphicon glyphicon-plus'></span> Add Sub Topic</button> <button type='button' class='btn btn-default btn-sm removesubtopic'>";
				html += "<span class='glyphicon glyphicon-remove'></span> Remove Last Sub Topic</button>";
				html += "</div>";
			html += "</div>";
		html += "</div>";
			html += "</div>";
	
	return html;
}


EOD;

$this->registerJs($js);

?>