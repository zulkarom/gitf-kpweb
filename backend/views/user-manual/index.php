<?php


use backend\modules\manual\models\Module;
use backend\modules\manual\models\Section;
use yii\helpers\Html;

$this->title = 'FKP PORTAL';


$modules = Module::find()->all();

echo '<ul>';
foreach($modules as $m){
    echo $m->module_name;
    
    $section = Section::findAll(['module_id' => $m->id]);
    $sub = array();
    
    if($section){
        echo '<ul>';
        foreach($section as $s){
            echo '<li>' . Html::a($s->section_name, ['/content', 's' => $s->id]) . '</li>';
        }
        echo '</ul>';
    }
    
    
    
}
echo '</ul>';

?>
  

