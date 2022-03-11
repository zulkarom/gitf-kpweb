<?php


use backend\modules\manual\models\Module;
use backend\modules\manual\models\Section;
use yii\helpers\Html;

$this->title = $module->module_name;
?>




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
  

