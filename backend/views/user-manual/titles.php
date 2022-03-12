<?php



use yii\helpers\Html;

$this->title = $section->section_name;
$this->params['breadcrumbs'][] = ['label' => 'List Manual', 'url' => ['/user-manual']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div> 
<ul> 
<li><?=Html::a($section->module->module_name, ['/user-manual/module-sections', 'm' => $section->module_id])?>


</li>
</ul>

</div>

<h3><?=$section->section_name?></h3>

<?php
echo '<ol>';
foreach($titles as $t){
    echo '<li>' . Html::a($t->title_text, ['/user-manual/item-steps', 't' => $t->id]) . '</li>';
}
echo '</ol>';

?>
  

