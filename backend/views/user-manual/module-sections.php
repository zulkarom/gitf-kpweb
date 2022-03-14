<?php

use yii\helpers\Html;
$this->title = strtoupper($module->module_name);
?>


<h3><?=$module->module_name?></h3>

<?php 
$web = Yii::getAlias('@web');
echo '<ul>';
foreach($sections as $s){
    echo '<li>' . Html::a($s->section_name, ['titles', 's' => $s->id]) . '</li>';
    
    $titles = $s->titles;
    
    if($titles){
        echo '<ul>';
        foreach($titles as $t){
            if($t->is_new){
                $new = ' <img src="'.$web.'/images/new.png" style="display:inline" />';
            }else{
                $new = '';
            }
            echo '<li style="font-size:16px"><i>' . Html::a($t->title_text . ' ' . $new, ['item-steps', 't' => $t->id]) . '</i></li>';
        }
        echo '</ul>';
    }
    
    
    
}
echo '</ul>';

?>
  

