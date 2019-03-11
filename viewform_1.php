<?php

echo "<link href='bootstrap.min.css' rel='stylesheet' />";

echo"
<script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/js/materialize.min.js'></script>
<link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
";
$ques_subject=array("The objectives of the course were made clear?",
	"Level at which the course was taught?",
	"Was the homework adequate?",
	"Were the test/exams conducted at appropriate level of difficulty?",
	"Do you seriously believe you learned something useful in the course?",
	"Was the prescribed textbook helpful?",
	"Give your overall rating for the course?");

$options_subject=array("1 for no/ too low",
	"3 for appropriate",
	"5 for definite yes/ too high");

$options_teach=array("1 for no",
	"5 for definite yes");

$ques_teacher=array("Did the instructor come well prepared to the class?",
	"Did the instructor introduce each new topic properly?",
	"Was the instructor punctual in starting the class?",
	"Did the instructor encourage discussion/question in the class?",
	"Did the instructor use board and other teaching aids effectively?",
	"Was the instructor approachable outside the class?",
	"Give your overall opinion of the instructor?");


$ques_tutor=array("Did the tutor encourage discussion in the class?",
	"Did the tutor use board and other teaching aids effectively?",
	"Was the tutor punctual in starting the class?",
	"Did the tutor hold all the scheduled classes?",
	"Was the tutor approachable outside the class?",
	"Give your overall opinion about the tutor?");



function feed_subject()
{
	global $ques_subject;
	global $options_subject;
	//echo "<div class='container-fluid'>";
	//echo "<div class='row'>\n";
	//echo "<div class='col-md-6 col-sm-6'>\n";

	echo "<div style='background-color:0288d1;color:white;padding:5px;'> <h2 style='text-align:center;'>About the course</h2>Key:<br></div>";

	foreach($options_subject as $opt)
	{
		echo "<div style='background-color:#0288d1;padding:5px;color:white;'><i>{$opt}</i><br>\n</div>";
	}
	$i=0;
	foreach($ques_subject as $ques)
	{
		$i++;
		$j=0;
		echo "<h3 style='vertical-align:middle; '><i style='color:#0288d1;vertical-align:middle;' class='material-icons'>question_answer</i>  {$ques}</h3>\n";
		for($j=1;$j<=5;$j++)
		{
			echo "<input  type='radio' name='o{$i}' value='{$j}' required='required' />{$j} \n";
		}
	}

	//echo "</div>\n";
}

function feed_teacher()
{
	global $ques_teacher;
	global $options_teach;
	//echo "<div class='col-md-6 col-sm-6'>";
	echo "<div style='background-color:#e53935;color:white;padding:5px;'><h2 style='text-align:center;'>About the teacher</h2>Key:<br></div>";
	
	foreach($options_teach as $opt)
	{
		echo "<div style='background-color:#e53935;padding:5px;color:white;'><i>{$opt}</i><br>\n</div>";
	}
	$i=0;
	foreach($ques_teacher as $ques)
	{
		$i++;
		echo "<h3 style='vertical-align:middle; '><i style='color:#e53935;vertical-align:middle;' class='material-icons'>question_answer</i>{$ques}</h3>\n";
		for($j=1;$j<=5;$j++)
		{
			echo "<input type='radio' name='o{$i}' value='{$j}'required='required' />{$j} \n";
		}
	}	
	//echo "</div>\n";
	//echo "</div>\n";
}

function feed_tutor()
{
	global $ques_tutor;
	global $options_teach;
	echo "<div style='background-color:#0097a7;color:white;padding:5px;'><h2 style='text-align:center;'>About the tutor</h2>Key:<br></div>";
	
	foreach($options_teach as $opt)
	{
		echo "<div style='background-color:#0097a7;padding:5px;color:white;'><i>{$opt}</i><br>\n</div>";
	}
	$i=0;
	
	foreach($ques_tutor as $ques)
	{
		echo '<div style="border: 1px solid; padding: 20px;">';
		$i++;
		echo "<h3 style='vertical-align:middle; '><i style='color:#0097a7;vertical-align:middle;' class='material-icons'>question_answer</i>{$ques}</h3>\n";
		for($j=1;$j<=5;$j++)
		{
			echo "<input type='radio' name='o{$i}' value='{$j}' required='required' />{$j} \n";
		}
		echo "</div>";
	}
	
}

echo "<div class='container'>";
echo "<div class='row'>";
echo "<div class='col-md-6'>";
feed_subject();
echo "</div>";
echo "<div class='col-md-6'>";
feed_teacher();
echo "</div>";
echo "</div>";
echo "<div class='row' style='margin-top: 20px;'>";
echo "<div class='col-md-6'>";
feed_tutor();
echo "</div>";
echo "</div>";
?>

