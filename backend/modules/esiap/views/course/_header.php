<?php 
if(!isset($version)){
    $version = $course->developmentVersion;
}

?>


<h4><?=$course->course_code . ' ' . $course->course_name ?></h4>
<h5>VERSION: <?=$version->version_name?></h5>
<h5>STANDARD:<?=$version->versionType->type_name?>  &nbsp;  STATUS: <?=$version->labelStatus?>  </h5>