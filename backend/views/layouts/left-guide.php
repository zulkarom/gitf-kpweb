<?php 
use common\models\Todo;
use yii\helpers\Url;
use backend\models\Menu;

?>
<aside class="main-sidebar">

    <section class="sidebar">


		
		<?php 

$menuItems = [

					['label' => 'HOME', 'icon' => 'dashboard', 'url' => ['/user-manual']],
					

					[
                        'label' => 'COURSE FILE',
                        'icon' => 'book',
                        'url' => '#',
                        'items' => [
												
                            ['label' => 'User Manual', 'icon' => 'book', 'url' => ['/user-manual', 'm' => 2, 's' => 1]],
							
                            ['label' => 'FAQ', 'icon' => 'book', 'url' => ['/user-manual', 'm' => 2, 's' => 2]],

                        ],
                    ],
					
             
];

$favouriteMenuItems[] = ['label' => 'MAIN MENU', 'options' => ['class' => 'header']];





// TODO: display menu
echo common\widgets\Menu::widget([
    'items' => \yii\helpers\ArrayHelper::merge($favouriteMenuItems, $menuItems),
]);
		
		
		?>

    </section>

</aside>
