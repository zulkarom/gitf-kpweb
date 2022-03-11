<?php

use yii\helpers\Html;

$this->title = 'FKP PORTAL';
?>



<div> 
<ul> 
<li><?=$title->section->module->module_name?>
	<ul>
	<li><?=$title->section->section_name?></li>
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