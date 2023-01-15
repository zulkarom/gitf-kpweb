<?php

use common\models\Grade;
use yii\helpers\Html;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
$this->title = 'Course Page';
$this->params['breadcrumbs'][] = ['label' => 'Coursework', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$course = $offer->course;
$assessment = $offer->assessment;
?>

<div class="row">

<div class="col-md-4">
<h4><?=$course->course_code . ' ' . $course->course_name?></h4>
<h4><?=$offer->semester->longFormat()?></h4>

</div>

<div class="col-md-8" align="right">

<?php 
if($assessment){
?>
<br />
 <div class="form-group"> 
<a href=<?=Url::to(['hai', 'id' => 1])?> class="btn btn-danger btn-sm" target="_blank"><span class="glyphicon glyphicon-download-alt"></span> DOWNLOAD RESULT</a> 

</div>

<?php 

}else{
	echo '<p style="color:red">No Assessment Set</p>';
}

?>



</div>

</div>


<div class="course-files-view">

  <div class="box box-solid">
<div class="box-body">

<table class="table">
    <thead>
      <tr>
 
        <th>#</th>
        <th width="10%">Groups</th>
        <th>Instructors</th>
      </tr>
    </thead>
    <tbody>
      
	  <?php 
	  
	  if($offer->lectures){
		  $i = 1;
		 foreach($offer->lectures as $lec){
			 echo '<tr>';
			echo '
			 <td>'.$i.'. </td> 

		   <td>';
			  echo $lec->lec_name;  
		  echo '</td>
		  <td >';
		  
		  if($lec->lecturers){
			  $str_lec = '';
			$n=1;
			foreach($lec->lecturers as $lecturer){
				$slash = $n==1 ? '':' / ';
				$str_lec .= $slash.$lecturer->staff->niceName;
			$n++;
			}

			  echo $str_lec;  
			
		}
		
		
		
					
		     echo'</td>';
			 
	  
	  echo '</tr>';
	  
	
	 
      $i++;
		 }
	  }
	  
	  
	  
	  ?>
      
    </tbody>
  </table>


</div>
    </div>



      <div class="box">
    <div class="box-header">
    </div>      
<div class="box-body">

<div class="table-responsive">
   <table class="table">
    <tbody>
        <tr><th>#</th><th>Matric No.</th><th>Students' Name</th><th>Group</th>
        <?php 
            foreach ($assessment as $assess) {
                echo'<th style="text-align:center">'.$assess->assess_name_bi.' 
                <br />('.$assess->assessmentPercentage.'%)
                </th>
                
                ';

            }
        ?>
        <th style="text-align:center">Total<br />(100%)</th>
        <th style="text-align:center">Grade</th>
        </tr>
        <?php 

if($students){
    $i = 1;
    $mark_arr = [];
    foreach($students as $st){
        echo '<tr><td>'.$i.'. </td><td>'.$st->student->matric_no.'</td><td>'.strtoupper($st->student->st_name).'</td><td>'.$st->courseLecture->lec_name.'</td>';
        
        $result = json_decode($st->assess_result);
        $c = count($assessment);

        if($assessment)
        {
            $x = 0;
            $sum = 0;
            
            foreach ($assessment as $assess) {
            
            if($result){
                if(array_key_exists($x, $result)){
                $mark = $result[$x];
                $sum += $mark;
                echo'<td align="center">'.number_format($mark,2).'</td>';
                }
                else{
                echo'<td></td>';
                }
                
            }
            else{
                echo'<td></td>';
            }
            
            $x++;
            }
        }
        $mark_arr[] = $sum;
        echo '<td><b>'.number_format($sum,2).'</b></td><td><b>'.Grade::showGrade($sum).'</b></td>';
        echo '</tr>';
$i++;
    }
    $spn = $c + 4;
    echo '<tr><td colspan="'.$spn.'" style="text-align:right">Average</td><td><b>
    '. number_format(Grade::average($mark_arr),2) .'</b></td><td></td></tr>';
    echo '<tr><td colspan="'.$spn.'" style="text-align:right">St. Dev.</td><td><b>'. number_format(Grade::stdev($mark_arr),2) .'</b></td><td></td></tr>';
}

?>
        
    </tbody>
</table> 
</div>



</div>
    </div>


    <div class="row">
    <div class="col-md-8">
<div class="box box-solid">
<div class="box-body" style="text-align:center">
<?php
 $list = Grade::analyse($mark_arr);

echo Html::img(Url::to(['bar', 'data' => json_encode($list)]));


?>
<br /><br />
</div></div>



    </div>
    <div class="col-md-4">

<div class="box box-solid">
<div class="box-body">


<table class="table">
    <thead><tr style="text-align:center">
    <th style="text-align:center">Grade</th><th style="text-align:center">Range</th><th style="text-align:center">Count</th>
    </tr></thead>
    <tbody>
        
        <?php
       
        foreach($list as $min=>$v){
            echo '<tr style="text-align:center"><td>'.$v[0].'</td><td>'.$min.' - '.$v[1].'</td><td>'.$v[2].'</td></tr>';
        }
       
        ?>
        
    </tbody>
</table>

</div></div>
    
        
    </div>
</div>
  

</div>


