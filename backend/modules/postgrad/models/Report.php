<?php

namespace backend\modules\postgrad\models;

use Yii;
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Themes;

class Report
{
	public static function BarChart($data, $tofile = false){
        $data= json_decode($data);
        $data1y = [];
        $label = [];
        if($data){
            foreach($data as $k=>$v){
                $data1y[] = $v[2];
                $label[] = $v[0];
            }
        }

        
        // Create the graph. These two calls are always required
        $graph = new Graph\Graph(590,400,'auto');
        $graph->SetScale("textlin");
        $graph->yaxis->scale->SetGrace(10,10);

        


        $theme_class=new Themes\UniversalTheme;
        $graph->SetTheme($theme_class);

        
        $graph->SetBox(false);

        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($label);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false,false);

        // Create the bar plots
        $b1plot = new Plot\BarPlot($data1y);

        // Create the grouped bar plot
        $gbplot = new Plot\GroupBarPlot(array($b1plot));
        // ...and add it to the graPH
        $graph->Add($gbplot);


        $b1plot->SetColor("white");
        $b1plot->SetFillColor("#6380c8");

        $graph->img->SetMargin(50,50,50,50);
        //$graph->title->Set("Grade Analysis");
        $graph->xaxis->SetTitle('GRADE','center');
        $graph->xaxis->SetTitleMargin(15);
        $graph->yaxis->title->Set("TOTAL");
        $graph->yaxis->SetTitleMargin(30);
        //$graph->yaxis->SetWeight(2);
        $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
 
        if($tofile){
            // image to the browser
            $gdImgHandler = $graph->Stroke(_IMG_HANDLER);
            
            // Stroke image to a file and browser
            
            // Default is PNG so use ".png" as suffix
            $fileName = "images/temp/mark/bar.png";
            $graph->img->Stream($fileName);
            
          /*   // Send it back to browser
            $graph->img->Headers();
            $graph->img->Stream(); */
        }else{
            // Display the graph
            $graph->Stroke();
        }
    }
}
