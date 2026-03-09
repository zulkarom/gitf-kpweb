<?php 
 
 use yii\helpers\Url;
 use common\widgets\MenuAdminLte;
 
$studentLevel = Yii::$app->session->get('studentLevel');
$isPostgrad = $studentLevel === 'PG';

$menuItems = [
        ['label' => 'Dashboard', 'level' => 1, 'url' => ['/site/index'], 'icon' => 'fas fa-tachometer-alt', 'children' => []],
        ['label' => 'My Profile', 'level' => 1, 'url' => ['/profile/view'], 'icon' => 'fas fa-user', 'children' => []],
        ['label' => 'Change Password', 'level' => 1, 'url' => ['/site/request-password'], 'icon' => 'fas fa-key', 'children' => []],
        ['label' => 'Logout', 'level' => 1, 'url' => ['/site/logout'], 'icon' => 'fas fa-sign-out-alt', 'children' => []],
];

if ($isPostgrad) {
    $menuItems[] = ['label' => 'ACADEMIC', 'level' => 0];
    $menuItems[] = ['label' => 'Semester Registration', 'level' => 1, 'url' => ['/site/semester-registration'], 'icon' => 'fas fa-calendar-check', 'children' => []];
    $menuItems[] = ['label' => 'Research Progress', 'level' => 1, 'url' => ['/site/index#research-progress'], 'icon' => 'fas fa-flask', 'children' => []];
} else {
    $menuItems[] = ['label' => 'ACADEMIC', 'level' => 0];
    $menuItems[] = ['label' => 'Course Registration', 'level' => 1, 'url' => ['/kursus-peserta/index'], 'icon' => 'fas fa-book', 'children' => []];
}

?> 
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                

    <?=MenuAdminLte::widget(
    $menuItems
     
     )?>

                    
                    
                    
<br /><br /><br /><br /><br /><br />
                                  
    </ul>
</nav>