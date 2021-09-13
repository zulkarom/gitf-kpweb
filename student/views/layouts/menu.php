<?php 

use yii\helpers\Url;
use common\widgets\MenuAdminLte;

?> 
 <div class="sidebar">
            <nav class="mt-2">
     <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                

    <?=MenuAdminLte::widget(
    [
            
            ['label' => 'Dashboard', 'level' => 1, 'url' => ['/site/index'], 'icon' => 'fa fa-chart-pie', 'children' => []],
            
            
            ['label' => 'ACCOUNT', 'level' => 0],
            
            ['label' => 'Income', 'level' => 2 , 'icon' => 'fa fa-dollar-sign', 'children' => [
                ['label' => 'Invoices', 'url' => ['/account/invoice'], 'icon' => 'fa fa-circle'],
                ['label' => 'Receipt', 'url' => ['/account/receipt'], 'icon' => 'fa fa-circle'],
                
            
            ]],
            
            ['label' => 'Expenses', 'level' => 2 , 'icon' => 'fa fa-dollar-sign', 'children' => [
                ['label' => 'New Expense', 'url' => ['/account/expense/create'], 'icon' => 'fa fa-plus'],
                ['label' => 'List of Expenses', 'url' => ['/account/expense'], 'icon' => 'fa fa-list'],
                
            
            ]],
            
            ['label' => 'Reports', 'level' => 2 , 'icon' => 'fa fa-dollar-sign', 'children' => [
                ['label' => 'Chart of Account', 'url' => ['/account/chart'], 'icon' => 'fa fa-plus'],
                ['label' => 'Income Statement', 'url' => ['/account/income-statement'], 'icon' => 'fa fa-list'],
                ['label' => 'Financial Position', 'url' => ['/account/financial-position'], 'icon' => 'fa fa-list'],
            
            ]],
            
            
            
        
        ]
    
    )?>

                    
                    
                    
<br /><br /><br /><br /><br /><br />
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
<?php 
/* 
$this->registerJs('

$(".has-treeview").click(function(){
    
    if($(this.hasClass("menu-open") == false){
        $(".has-treeview").each(function(i, obj) {
            $(this).removeClass("menu-open");
        });
    }
    
    
});

');


 */
?>