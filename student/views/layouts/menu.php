<?php 

use yii\helpers\Url;
use common\widgets\MenuAdminLte;

?> 
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                

    <?=MenuAdminLte::widget(
    [
            
            ['label' => 'Dashboard', 'level' => 1, 'url' => ['/site/index'], 'icon' => 'fas fa-tachometer-alt', 'children' => []],

            ['label' => 'My Profile', 'level' => 1, 'url' => ['/profile/view'], 'icon' => 'fas fa-tachometer-alt', 'children' => []],

            ['label' => 'Course Registration', 'level' => 1, 'url' => ['/kursus-peserta/index'], 'icon' => 'fas fa-tachometer-alt', 'children' => []],
            
            
            ['label' => 'EXAMPLES', 'level' => 0],
            
            ['label' => 'Example', 'level' => 2 , 'icon' => 'fas fa-th', 'children' => [
                ['label' => 'Example 1', 'url' => ['/account/invoice'], 'icon' => 'far fa-circle'],
                ['label' => 'Example 2', 'url' => ['/account/receipt'], 'icon' => 'far fa-circle'],
                
            
            ]],
        ]
    
    )?>

                    
                    
                    
<br /><br /><br /><br /><br /><br />
                                  
    </ul>
</nav>