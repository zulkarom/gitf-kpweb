<?php

use yii\helpers\Html;

?>


<h3><?=$module->module_name?></h3>

<?php 

echo '<ul>';
foreach($sections as $s){
    echo '<li>' . Html::a($s->section_name, ['titles', 's' => $s->id]) . '</li>';
    
    $titles = $s->titles;
    
    if($titles){
        echo '<ul>';
        foreach($titles as $t){
            echo '<li style="font-size:16px"><i>' . Html::a($t->title_text, ['item-steps', 't' => $t->id]) . '</i></li>';
        }
        echo '</ul>';
    }
    
    
    
}
echo '</ul>';

?>
  

