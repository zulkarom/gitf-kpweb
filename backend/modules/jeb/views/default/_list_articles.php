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
		</tr>
		</thead>
		<tbody>
		<?php 
			
			
			if($article){
				
				foreach($article as $ar){
					echo '<tr>
						<td><h4><a href="'.Url::to(['page/article', 'id' => $ar->id]).'" class="article-list">'.$ar->title .'</a></h4><i>'.$ar->stringAuthors .'</i>
						</td>
					
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