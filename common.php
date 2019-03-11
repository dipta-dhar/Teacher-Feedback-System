<?php

function main_header($title,$level=0) {

$str='';
while($level>0) {
	$str=$str.'../';
	$level--;
}
echo<<<_END

<!DOCTYPE html>
<html>
<head>
<title>{$title}</title>
<script src="{$str}js/jquery.js"></script>
<script src="{$str}js/jquery-ui.js" type="text/javascript"></script>
<script src="{$str}js/materialize.min.js" type="text/javascript"></script>


<link  href="{$str}css/jquery-ui.css" rel="stylesheet">
<link  href="{$str}css/materialize.min.css" rel="stylesheet">
<link  href="{$str}css/main.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
_END;

}

function nav_student() {
	echo <<<_END
	 <div class="navbar-fixed">
	<nav>
	<div class='nav-wrapper'>
	 <a href='#!' class='brand-logo center'><img id='logo_image' src='logo2.png'></img></a>
		  <ul class="hide-on-med-and-down">
			<li id='tab_home'><a href="index.php">Home</a></li>
		  </ul>
		  
		   <a class="btn-flat waves-effect waves-light btn" style="float:right;color:white; margin-top:12px;" href='../logout.php' name='logout_button'>Logout</a>
	</div>	   
    </nav>
	</div>
_END;
}

function nav_teacher() {
	echo <<<_END
	<div class="navbar-fixed">
	<nav>
	<div class='nav-wrapper'>
		  <a href='#!' class='brand-logo center'><img id='logo_image' src='logo2.png'></img></a>
		  <ul class="hide-on-med-and-down">
			<li id='tab_home'><a href="index.php">Home</a></li>
		  </ul>
		  
		   <a class="btn-flat waves-effect waves-light btn" style="float:right; margin-top:12px; color:white;" href='../logout.php' name='logout_button'>Logout</a>
	</div>		   
	</nav>
	</div>
_END;
}

$branches=array(
	"1"=>"Aeronautical Engineering",
	"2"=>"Civil Engineering",
	"3"=>"Computer Science & Engineering",
	"4"=>"Electrical Engineering",
	"5"=>"Electronics & Electrical Communication Engineering",
	"6"=>"Mechanical Engineering",
	"7"=>"Metallurgical Engineering",
	"8"=>"Production Engineering",
	"9"=>"Information Technology",
	"10"=>"Aerospace Engineering",
	"11"=>"Materials & Metallurgical Engineering",
	"12"=>"Computer Science &  Engineering (Information Security)",
	"13"=>"Industrial Design",
	"14"=>"Total Quality Engineering & Management",
	"15"=>"Electronics (VLSI Design)",
	"16"=>"Production & Industrial Engineering",
	"17"=>"Civil Engineering (Structures)",
	"18"=>"Civil Engineering (Transportation)",
	"19"=>"Electronics Engineering",
	"20"=>"Industrial Materials & Metallurgy Engineering",
	"21"=>"Environmental  Engineering",
	"22"=>"Civil Engineering (Irrigation & Hydraulics)",
	"23"=>"Electronic Product Design & Technology",
	"24"=>"Computer Integrated Manufacturing",
	"26"=>"Civil Engineering (Water Resources)",
	"27"=>"Electronics & Communication Engineering"
	);

$ques_subject=array("The objectives of the course were made clear?",
	"Level at which the course was taught?",
	"Was the homework adequate?",
	"Were the test/exams conducted at appropriate level of difficulty?",
	"Do you seriously believe you learned something useful in the course?",
	"Was the prescribed textbook helpful?",
	"Give your overall rating for the course?");

$ques_teacher=array("Did the instructor come well prepared to the class?",
	"Did the instructor introduce each new topic properly?",
	"Was the instructor punctual in starting the class?",
	"Did the instructor encourage discussion/question in the class?",
	"Did the instructor use board and other teaching aids effectively?",
	"Was the instructor approachable outside the class?",
	"Give your overall opinion of the instructor?");

?>