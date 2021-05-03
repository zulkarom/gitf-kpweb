<?php

namespace backend\modules\courseFiles\views\admin;

use Yii;
use backend\modules\courseFiles\models\Common;
use yii\helpers\Html;
use yii\helpers\Url;

class Show
{
   public static function scriptLink($offer, $type){
	$html = '';
	for($s=1;$s<=3;$s++){
		$sc = 'script'.$type. $s;
		$col = $sc . '_file';
		if($offer->$col){
			$html .= '<li><a href="' . Url::to(['/course-files/coordinator-upload/download-file', 'attr' => $sc, 'id' => $offer->id]) . '" target="_blank">SCRIPT '.$s.' '.Common::ptick().'</a></li>';
		}else{
			$html .= '<li>SCRIPT '.$s.' '.Common::ptick(false).'</li>';
		}
		
	}
	return $html;
}

public static function showCoor($offer, $method, $link, $progress){
	$html = '';
	$boo = true;
	$na = 'na_' . $progress;
	$prg = 'prg_' . $progress;
	if($offer->$na == 1){
		$html .= '<ul>
				<li><a href="'.Url::to('@web/doc/na.pdf').'" target="_blank">N/A</a> '.Common::ptick().'</li>
			</ul>
			';
	}else{
		if($offer->$prg == 1){
			$boo = true;
		}else{
			$boo = false;
		}
		if($offer->$method){
			$i=1;
			$html .=  '<ul>';
			foreach ($offer->$method as $file) {
				if($file->path_file){
					$html .=  '<li>' . Html::a(strtoupper(Html::encode($file->file_name)), [$link . '/download-file', 'attr' => 'path','id'=> $file->id],['target' => '_blank']);
					$html .=  '</li>';
				}else{
					$html .=  '<li>' . strtoupper(Html::encode($file->file_name)) . ' '.Common::ptick(false).'</li>';
				}
			  
			  $i++;
			}
			$html .=  '</ul>';
		  }else{
			  $html .= '<ul>
				<li>'.Common::ptick(false).'</li>
			</ul>
			';
		  }
	}
	
	$html .= '</td><td>';
	$html .= Common::ptick($boo);
    $html .= '</td>';
	return $html;
}

public static function showLecTut($offer, $lec_method, $tut_method, $link, $progress){
	$html = '';
	$na = 'na_' . $progress;
	$prg = 'prg_' . $progress;
	$boo = true;
	if($offer->lectures){
	  $i=1;
	  $html .=  '<ul>';
	  foreach ($offer->lectures as $lecture) {
		$html .=  '<li>';
		
		if($lecture->$na == 1){
			if($link == 'cancel'){
				$html .= $lecture->lec_name . ' - <a href="'.Url::to('@web/doc/FK4.pdf').'" target="_blank">FKP04 (N/A)</a> ' . Common::ptick(); 
			}else{
				$html .= $lecture->lec_name . ' - <a href="'.Url::to('@web/doc/na.pdf').'" target="_blank">N/A</a> ' . Common::ptick(); 
			}
			
		}else{
			if($lecture->$prg == 1){
				$boo_lec = true;
				$boo = $boo == false ? false : true;
			}else{
				$boo_lec = false;
				$boo = false;
			}
			$html .= $lecture->lec_name . ' ' . Common::ptick($boo_lec); 
			if($lecture->$lec_method){
				$html .=  '<ul>';
				$j=1;
			  foreach ($lecture->$lec_method as $file) {
				if($link == 'exempt'){
					$file_name = $file->matric_no . '-' . date('d/m/Y', strtotime($file->ex_date));
				}else if($link == 'cancel'){
						$file_name = date('d/m/Y', strtotime($file->date_old)). ' by ' . date('d/m/Y', strtotime($file->date_new));
				}else{
					$file_name = 'File ' . $j;
				}
				
				if($file->path_file){
					$html .=  '<li>' . Html::a($file_name . ' ' . Common::ptick(), ['lecture-'.$link.'-file/download-file', 'attr' => 'path','id'=> $file->id],['target' => '_blank']) . '</li>';
				}else{
					$html .= '<li>'.$file_name.' '.Common::ptick(false).'</li>';
				}
				
				$j++;
			  }
			  $html .=  '</ul>';
			} 
		}
		
		$html .=  '</li>';
		$i++;
	  }
	  $html .=  '</ul>';
	}else{
				$boo = false;
				echo'<ul><li>'.Common::pTick(false).'</li></ul>';
			}


	if($offer->lectures){
		$html .=  '<ul>';
	  $i=1;
	  foreach ($offer->lectures as $lecture) {
		if($lecture->tutorials){
		  foreach ($lecture->tutorials as $tutorial) {
			$html .=  '<li>';
			if($tutorial->$na == 1){
				if($link == 'cancel'){
					$html .= $lecture->lec_name . $tutorial->tutorial_name . ' - <a href="'.Url::to('@web/doc/FK4.pdf').'" target="_blank">FKP04 (N/A)</a> ' . Common::ptick(); 
				}else{
					$html .= $lecture->lec_name . $tutorial->tutorial_name . ' - <a href="'.Url::to('@web/doc/na.pdf').'" target="_blank">N/A</a> ' . Common::ptick(); 
				}
				
			}else{
				if($tutorial->$prg == 1){
					$boo_tut = true;
					$boo = $boo == false ? false : true;
					
				}else{
					$boo_tut = false;
					$boo = false;
				}
				$html .= $lecture->lec_name . $tutorial->tutorial_name . ' ' . Common::ptick($boo_tut); 
				if($tutorial->$tut_method){
				$html .=  '<ul>';
					$j=1;
				  foreach ($tutorial->$tut_method as $file) {
					 if($link == 'exempt'){
						$file_name = $file->matric_no . '-' . date('d/m/Y', strtotime($file->ex_date));
					}else if($link == 'cancel'){
						$file_name = date('d/m/Y', strtotime($file->date_old)). ' by ' . date('d/m/Y', strtotime($file->date_new));
					}else{
						$file_name = 'File ' . $j;
					}
					if($file->path_file){
						$html .=  '<li>' . Html::a($file_name .' '.Common::pTick(), ['tutorial-'.$link.'-file/download-file', 'attr' => 'path','id'=> $file->id],['target' => '_blank']) . '</li>';
					}else{
						$html .=  '<li>'.$file_name. ' '.Common::pTick(false).'</li>';
					}
					
					$j++;
				  }
				  $html .=  '</ul>';
				}
			}
			
			$i++;
			$html .=  '</li>';
		  }
		} 
	  }
	$html .=  '</ul>';
	}
	
	$html .= '</td><td>';
	$html .= Common::ptick($boo);
    $html .= '</td>';
	
	return $html;
}
}
