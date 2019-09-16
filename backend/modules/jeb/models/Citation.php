<?php

namespace backend\modules\jeb\models;

use Yii;
use backend\modules\jeb\models\Article;

class Citation
{
	public static function bibtext($id){
		$model = Article::findOne($id);
		$str = $model->authorString('-');
		$firstau = explode(' ', $str);
		$firstau = strtolower($firstau[0]);
		$first_title = explode(' ', $model->title);
		$first_title = strtolower($first_title[0]);
		$year = $model->year;
		$ref = $firstau.$year.$first_title;
		
		//authors
		$list = $model->articleAuthors;
		$str = '';
		if($list){
			$total = count($list);
			$i = 1;
			foreach($list as $au){
				$sep = $i == $total ? '' : ' and ';
				$str .= $au->lastname . ', ' . $au->firstname . $sep;
			$i++;
			}
		}
		
		$authors = $str;
		
		$name = "cite.bib"; 
		
$text = "@article{".$ref.",
	title={".ucfirst($model->title_sc) ."},
	author={" . $authors . "},
	journal={Journal of Entrepreneurship and Business},
	volume={".$model->journal->volume ."},
	number={".$model->journal->issue."},
	pages={".$model->page_from ."--".$model->page_to ."},
	year={".$year."}
}"; 
		
	
		

header('Content-Disposition: attachment; filename="' . $name . '"');
header('Expires: 0'); 
$fp = fopen($name, 'a');
fwrite($fp, $text);
fclose($fp);   // don't forget to close file for saving newly added data
readfile($name);   // readfile takes a filename, not a handler.
unlink($name);
	   
	}
	
}
