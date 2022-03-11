<?php



use yii\helpers\Html;

$this->title = $section->section_name;
$this->params['breadcrumbs'][] = ['label' => 'List Manual', 'url' => ['/user-manual']];
$this->params['breadcrumbs'][] = $this->title;



echo '<ol>';
foreach($titles as $t){
    echo '<li>' . Html::a($t->title_text, ['/user-manual/item-steps', 't' => $t->id]) . '</li>';
}
echo '</ol>';

?>
  

