<?php

use yii\helpers\Html;

$this->title = 'FKP PORTAL';
?>



<div> 
<ul> 
<li><?=Html::a($title->section->module->module_name, ['/user-manual/module-sections', 'm' => $title->section->module_id])?>
	<ul>
	<li><?=Html::a($title->section->section_name, ['/user-manual/titles', 's' => $title->section_id])?></li>
	</ul>

</li>
</ul>

</div>


<h3><?=$title->title_text?></h3>

<?php 

foreach($items as $t){
    echo '<p>' . $t->item_text . '</p>';
    if($t->steps){
        echo '<ol>';
        foreach($t->steps as $s){
            echo '<li>'  . $s->step_text  . '</li>'; 
        }
        echo '</ol>';
    }
}

?>