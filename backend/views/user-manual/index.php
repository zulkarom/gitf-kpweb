<?php


use backend\modules\manual\models\Module;
use backend\modules\manual\models\Section;
use yii\helpers\Html;

$this->title = 'FKP PORTAL';


$modules = Module::find()->where(['is_published' => 1])->all();

echo '<ul>';
foreach($modules as $m){
    echo '<li>' . Html::a($m->module_name, ['/user-manual/module-sections', 'm' => $m->id]) . '</li>';
    
    $section = Section::findAll(['module_id' => $m->id]);
    $sub = array();
    
    if($section){
        echo '<ul>';
        foreach($section as $s){
            echo '<li style="font-size:16px"><i>' . Html::a($s->section_name, ['titles', 's' => $s->id]) . '</i></li>';
        }
        echo '</ul>';
    }
    
    
    
}
echo '</ul>';

?>
  

