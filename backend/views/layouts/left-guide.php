<?php 
use backend\modules\manual\models\Module;
use backend\modules\manual\models\Section;

?>
<aside class="main-sidebar">

    <section class="sidebar">


		
		<?php 

		
		
		
$menuItems = array();


$modules = Module::find()->all();

foreach($modules as $m){
    
    $section = Section::findAll(['module_id' => $m->id]);
    $sub = array();
    
    if($section){
        foreach($section as $s){
            $sub[] = ['label' => strtoupper($s->section_name), 'icon' => 'book', 'url' => ['/content', 's' => $s->id]];
        }
    }
    
    $menuItems[] = [
        'label' => strtoupper($m->module_name),
        'icon' => 'book',
        'url' => '#',
        'items' => $sub,
    ];

}




$top[] = ['label' => 'MAIN MENU', 'options' => ['class' => 'header']];

$top[] = ['label' => 'HOME', 'icon' => 'dashboard', 'url' => ['/user-manual']];



// TODO: display menu
echo common\widgets\Menu::widget([
    'items' => \yii\helpers\ArrayHelper::merge($top, $menuItems),
]);
		
		
		?>

    </section>

</aside>
