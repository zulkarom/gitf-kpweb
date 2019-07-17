<?php
$lec ="";
$pubm ="";
if(isset($_REQUEST['t']) and $_REQUEST['t'] =="adminlect"){
	
	$lec ="class='active'";
}else{
	$pubm ="class='active'";
}
?>

<br />
<ul class="nav nav-tabs" role="tablist">

        <li <?php echo $pubm;?>><a href="index.php?p=res&t=admin&ad=1"><h6>ALL RESEARCH</h6></a></li>

<li <?php echo $lec;?>>
    <a href="index.php?p=res&t=adminlect&ad=1" >
     <h6>LECTURER</h6>
    </a>

  </li>




   
      </ul>
<br/>