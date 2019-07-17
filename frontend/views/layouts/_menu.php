<?php 
use yii\helpers\Url;
?>
<div style="background-color:#020031;">	
	<div class="container">
<a href="#" class="nav-button">Menu</a>

<nav class="nav">

    <ul>
        <li><a href="<?=Url::to(['/site'])?>"><i class="fa fa-home"></i> HOME</a></li>
        <li class="nav-submenu"><a href="#">FACULTY</a>
            <ul>
                <li><a href="<?=Url::to(['/faculty'])?>">ABOUT FACULTY</a></li>
                <li><a href="<?=Url::to(['/faculty/dean-desk'])?>">FROM DEAN'S DESK</a></li>
               
            </ul>
        </li>
		<li class="nav-submenu"><a href="#">STUDENTS</a>
            <ul>
                <li><a href="<?=Url::to(['/student'])?>">FUTURE STUDENTS</a></li>
                <li><a href="<?=Url::to(['/student/current'])?>">CURRENT STUDENTS</a></li>
				<!-- <li><a href="#">LIFELONG LEARNING</a></li> -->
            </ul>
        </li>
		<li class="nav-submenu"><a href="#">ACADEMIC PROGRAMMES</a>
            <ul>
                <li><a href="<?=Url::to(['/academic'])?>">UNDERGRADUATE</a></li>
                <li><a href="<?=Url::to(['/academic/post-graduate'])?>">POSTGRADUATE</a></li>
            
            </ul>
        </li>
		<li class="nav-submenu"><a href="#">RESEARCH & INNOVATION</a>
            <ul>
				<li><a target="_blank" href="http://jeb.umk.edu.my">JEB JOURNAL</a></li>
                <li><a href="<?=Url::to(['/research/caknawan'])?>">CAKNAWAN</a></li>
            </ul>
        </li>
        
        <!-- <li class="nav-submenu"><a href="#">STAFF</a>
            <ul>
                <li><a href="academician.php">ACADEMIC STAFF</a></li>
                <li><a href="admin.php">ADMINISTRATION STAFF</a></li>
				<li><a href="/portal.php">FKP STAFF PORTAL</a></li>
            </ul>
        </li> -->
        <li><a href="<?=Url::to(['/site/contact'])?>">CONTACT US</a></li>
    </ul>
</nav>

<a href="#" class="nav-close">Close Menu</a>
</div>
</div>