<?php 
$this->title = 'JEB Current Issue';
?>
			
			
<div class="box">
<div class="box-header"></div>
<div class="box-body"><?php 

if($journal){
	echo $this->render('_list_articles', [
			'journal' => $journal,
	]);
}else{
	echo 'In progress';
}
			?></div>
</div>

<div align="center">
<a href="" class="btn btn-primary" target="_blank">JEB PREVIOUS ISSUES</a>
</div>


