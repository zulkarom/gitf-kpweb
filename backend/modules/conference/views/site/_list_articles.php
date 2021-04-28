<?php 

use yii\helpers\Html;
use yii\helpers\Url;

?>
			<div class="row">
			
			<div class="col-md-12">
		<?php 
		
			$article = $journal->articles;
		?>
		<table class="table" id="list-articles">
		<thead>
		<tr>
			<th><div align="center"><?=strtoupper($journal->journalIssueName)?></div></th>
		</tr>
		</thead>
		<tbody>
		
		<tr>
						<td>	<div class="row">
		<?php 
			
			
			if($article){
				
				foreach($article as $ar){
					echo '
						
					
<div class="col-md-6 form-group">
						
						<a href="'.Url::to(['page/article' , 'id' => $ar->id]).'">'.$ar->title .'</a> <br />
						<i>'.$ar->stringAuthors .'</i>
						
						<br />
						
						<a href="javascript:void(0)"  class="btn-abs" id="show-abs-'.$ar->id .'"><i id="icon-'.$ar->id .'" class="fa  fa-plus-square-o hide"></i> <i>View Abstract</i></a> | <a href="'.Url::to($ar->linkArticle()).'" target="_blank"><i class="fa fa-file-pdf-o"></i> <i>Download Full Paper</i></a>
						<br />
						
						<div class="abs-con" id="abs-'.$ar->id .'" style="display:none; text-align:justify";>
						<b>Abstract: </b>
						'.Html::encode($ar->abstract) .'<br />
						<b>Keywords: </b>
						'.Html::encode($ar->keyword) .'
						</div>
						
						</div>
						
						
						';

				}
			}
			
			?>
			</div>
			</td>
					</tr>
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