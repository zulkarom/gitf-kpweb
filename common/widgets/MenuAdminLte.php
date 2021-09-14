<?php
namespace common\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
/**
 * Class Menu
 * Theme menu widget.
 */
class MenuAdminLte 
{
	public $items;
	public $tree = false;
	
	public function __construct($items = [])
	{
		$this->items = $items;
	}

   public static function widget($items){
	   
	   $widget =  new self($items);
	   return $widget->menus();
		
	}
   
   public function menus(){
	   $html = '';  
	   foreach($this->items as $item){
			   switch($item['level']){
				   case 0:
				   $html .= '<li class="nav-header">'.$item['label'].'</li>';
				   break;
				   
				   case 1:
				   $html .= $this->item1($item);
				   break;
				   
				   case 2:
				   $html .= $this->item2($item);
				   
			   }
	   }
			   
	return $html;
   }
   
   protected function item1($item){
	   $active = $this->isItemActive($item) ? 'active' : '';
	   return '<li class="nav-item">
				   <a href="'. Url::to($item['url']) .' " class="nav-link '.$active.'">
				   <i class="nav-icon '.$item['icon'].'"></i>
				   <p>'.$item['label'].'</p>
				   </a></li>';
   }
   
   protected function item2($item){
	   $this->tree = false;
	   $anak = '';
	   $children = $item['children'];
			if($children){
				foreach($children as $child){
					$anak .= $this->item1($child);
				}
			}
	   $active =  '';
	   $open = '';
	   $block = 'none';
	   if($this->tree){
		  $active =  'active';
		   $open = 'menu-open';
		   $block = 'block'; 
	   }
	   $html =  '<li class="nav-item '.$open.'">
			<a href="#" class="nav-link '.$active.'">
				<i class="nav-icon '.$item['icon'].'"></i>
				<p>
					'.$item['label'].'
					<i class="right fa fa-angle-left"></i>
				</p>
			</a>
			<ul class="nav nav-treeview '.$block.'">';
			
			$html .= $anak;
						
                            
      $html .= '</ul></li>';
	  return $html;
   }
   
    protected function isItemActive($item)
    {
		if(array_key_exists('url', $item)){
			
			$arr = explode('/', $item['url'][0]);
			
			/* echo $arr[1]; echo Yii::$app->controller->id;
			
			echo $arr[2]; echo  Yii::$app->controller->action->id;
			
			die(); */
			
			if($arr[1] == Yii::$app->controller->id && 
			$arr[2] == Yii::$app->controller->action->id){
				$this->tree = true;
				return true;
			}
			
			if($arr[1] == Yii::$app->controller->module->id && 
			$arr[2] == Yii::$app->controller->id &&
			$arr[3] == Yii::$app->controller->action->id){
				$this->tree = true;
				return true;
			}
		}
		
	
        return false;
    }
}
