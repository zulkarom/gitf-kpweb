<?php 

use yii\helpers\Url;
use common\widgets\MenuAdminLte;

$me = Yii::$app->user->identity->id;
$user = Yii::$app->user;

$items[] = ['label' => 'Dashboard', 'level' => 1, 'url' => ['/site/index'], 'icon' => 'fas fa-tachometer-alt', 'children' => []];




if($user->can('manage-view')){
    $items[] = ['label' => 'Participants', 'level' => 1, 'url' => ['/answer/index'], 'icon' => 'fas fa-users', 'children' => []];
}

if($user->can('manage-admin')){
    $items[] =  ['label' => 'Batches', 'level' => 1, 'url' => ['/batch/index'], 'icon' => 'fas fa-columns', 'children' => []];
    
    $items[] =  ['label' => 'Questions', 'level' => 1, 'url' => ['/question/index'], 'icon' => 'fas fa-list', 'children' => []];

   /*  $items[] =  ['label' => 'Setting', 'level' => 1, 'url' => ['/setting/index'], 'icon' => 'fas fa-cog', 'children' => []]; */

/*     $items[] =  ['label' => 'System Management', 'level' => 2 , 'icon' => 'fas fa-th', 'children' => [
                    ['label' => 'User Assignment', 'url' => ['/admin/assignment/index'], 'icon' => 'far fa-circle'],
                    ['label' => 'Role List', 'url' => ['/admin/role/index'], 'icon' => 'far fa-circle'],
                    ['label' => 'Route List', 'url' => ['/admin/route/index'], 'icon' => 'far fa-circle'],
                        
                ]]; */
}
$items[] = ['label' => 'Change Password', 'level' => 1, 'url' => ['/candidate/change-password'], 'icon' => 'fas fa-unlock-alt', 'children' => []];

$items[] = ['label' => 'Logout', 'level' => 1, 'url' => ['/site/logout'], ['data-method' => 'post'], 'icon' => 'fas fa-times', 'children' => []];


?> 
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                

    <?=MenuAdminLte::widget($items)?>
            

        <!-- ['label' => 'All Candidate', 'level' => 1, 'url' => ['/candidate/index'], 'icon' => 'fas fa-users', 'children' => []],
            
        ['label' => 'EXAMPLES', 'level' => 0],
            
        ['label' => 'Example', 'level' => 2 , 'icon' => 'fas fa-th', 'children' => [
            ['label' => 'Example 1', 'url' => ['/account/invoice'], 'icon' => 'far fa-circle'],
            ['label' => 'Example 2', 'url' => ['/account/receipt'], 'icon' => 'far fa-circle'],
                
        ]], -->
    
    

                    
                    
                    
<br /><br /><br /><br /><br /><br />
                                  
    </ul>
</nav>