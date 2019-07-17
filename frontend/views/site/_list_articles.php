<?php 

use yii\helpers\Html;
use yii\helpers\Url;

?>
			<div class="row">
			
			<div class="col-md-12">
		<?php 
		
			$article = $journal->articles;
		?>
		<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th><?=$journal->journalName?>, <?=$journal->journal_name?></th>
			<th width="10%"><i class="fa  fa-dot-circle-o"></i> Abstract</th>
			<th width="10%"><i class="fa fa-download"></i> Download</th>
		</tr>
		</thead>
		<tbody>
		<?php 
			
			
			if($article){
				
				foreach($article as $ar){
					echo '<tr>
						<td><b>Title</b> : '.$ar->title .' <br /><b>Authors</b> :  <i>'.$ar->stringAuthors .'</i>
						
						<br /><div class="abs-con" id="abs-'.$ar->id .'" style="display:none; text-align:justify";>
						<b>Abstract: </b>
						'.Html::encode($ar->abstract) .'<br />
						<b>Keywords: </b>
						'.Html::encode($ar->keyword) .'
						</div>
						
						
						</td>
						<td><a href="javascript:void(0)"  class="btn-abs" id="show-abs-'.$ar->id .'"><i id="icon-'.$ar->id .'" class="fa  fa-plus-square-o hide"></i> Abstract</a></td>
						
						<td><a href="'.Url::to($ar->linkArticle()).'" target="_blank"><i class="fa fa-file-pdf-o"></i> PDF</a></td>
					</tr>';

				}
			}
			
			?>
			
		</tbody>
		</table>
			
			

			</div>
			</div>
		

	
<?php 

$this->registerJs('

$(".btn-abs").click(function(){
	var arr = $(this).attr("id").split("-");
	var id = arr[2];
	var c = $("#icon-" + id);
	var w = $("#abs-" + id);
	 if(c.hasClass("hide")) {
		 c.removeClass("fa fa-plus-square-o hide");
		c.addClass("fa fa-minus-square-o show");
		w.slideDown();
	 }else{
		c.removeClass("fa fa-minus-square-o show");
		c.addClass("fa fa-plus-square-o hide");
		w.slideUp(); 
	 }
	
	
	
	
});

');



?>