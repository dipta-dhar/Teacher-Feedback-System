<?php

$ques_subject=array("The content of the course was up-to-date?",
	"The organisation & structure of the course was adequate?",
	"Sufficient weightage was given to tutorial / assignments / practicals /case studies / projects?",
	"Course objectives and course outcomes were clear?",
	"The course is important for this degree programme?");

$options_subject=array("1 for Strongly Disagree",
	"2 for DisAgree",
	"3 for Neutral",
	"4 for Agree",
	"5 for Strongly Agree");

$options_teach=array("1 for Strongly Disagree",
					"2 for DisAgree",
					"3 for Neutral",
					"4 for Agree",
					"5 for Strongly Agree");

$ques_teacher=array("Objectives, organisation and outcomes of the course were made clear in first two weeks of the course?",
	"Instructor was punctual and classes were held regularly?",
	"The method of the evaluation and the evaluation criteria were consistent and clear?",
	"Instructor encouraged discussion / questions in the class room ?",
	"Instructor treated all students equally and fairly and was approachable?",
	"Conduct of tutorials / practicals was encouraged to solve problems effectively?",
	"Quality of questions raised in examination /classes by the instructor   was   excellent?",
	"Instructor’s communication and explanation were clear?",
	"Use of modern teaching tools was very effective?",
	"The instructor’s effectiveness in teaching  and punctuality in grading the exam was excellent?");


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
	
	
	echo "<div style='background-color:#3e6276;color:white;padding:5px;font-family:Open Sans Condensed, sans-serif;'> <h2 style='text-align:center;font-family:Oswald,sans-serif;'>About the course</h2>Key:</div>";
	echo"<div class='enclosed_question_options_style' style='background-color:#3e6276;'>";
	foreach($options_subject as $opt)
	{
		echo "<div class='container left' class= 'col s12 m3 l3' style='padding:2px;color:white;font-family:Open Sans Condensed, sans-serif;'><i>{$opt}</i><br>\n</div>";
	}
	echo "<div class='row'>"; 
	echo" <div  class='col s12 m5 l5 offset-m6 offset-l6' style='padding:2px;color:white;font-family:Open Sans Condensed, sans-serif;'> Feedback for course : <br/>". $_SESSION['cname'] ."</div></div>";
	$i=0;
	echo"</div>";
	foreach($ques_subject as $ques)
	{
		$i++;
		$j=0;
		
		echo "<h5 style='vertical-align:middle;font-family: Raleway, sans-serif; '><i style='color:#3e6276;vertical-align:middle;' class='material-icons'>question_answer</i>  {$ques}</h5>\n";
		for($j=1;$j<=5;$j++)
		{
			
			if(isset($_POST["s{$i}"]) && $_POST["s{$i}"] == 'point'.$j)
				echo "<input  type='radio' name='s{$i}' value='point{$j}' id = 'r{$i}{$j}' checked /> <label for='r{$i}{$j}'>{$j}</label> \n";
			else 
				echo "<input  type='radio' name='s{$i}' value='point{$j}' id = 'r{$i}{$j}' /> <label for='r{$i}{$j}'>{$j}</label> \n";
		}
		
	}
	
}

function feed_teacher()
{
	global $ques_teacher;
	global $options_teach;
	
	echo "<div style='background-color:#c34c4a;color:white;padding:5px;font-family:Open Sans Condensed, sans-serif;'><h2 style='text-align:center;font-family:Oswald,sans-serif;'>About the teacher</h2>Key:</div>";
	echo"<div class='enclosed_question_options_style' style='background-color:#c34c4a;'>";
	foreach($options_teach as $opt)
	{
		echo "<div style='padding:2px;color:white;font-family:Open Sans Condensed, sans-serif;'><i>{$opt}</i><br>\n</div>";
	}
	echo "<div class='row'>";
	echo" <div  class='col s12 m5 l5 offset-m6 offset-l6' style='padding:2px;color:white;font-family:Open Sans Condensed, sans-serif;'> Feedback for Faculty : <br>". $_SESSION['t_name'] ."<br></div>";
	

	echo"</div></div>";
	$i=0;
	foreach($ques_teacher as $ques)
	{

		$i++;

		echo "<h5 style='vertical-align:middle;font-family: Raleway, sans-serif; ' '><i style='color:#c34c4a;vertical-align:middle;' class='material-icons'>question_answer</i>{$ques}</h5>\n";
		for($j=1;$j<=5;$j++)
		{
			if(isset($_POST["t{$i}"]) && $_POST["t{$i}"] == 'point'.$j)
				echo "<input type='radio' name='t{$i}' value='point{$j}' id = 't{$i}{$j}' checked/> <label for='t{$i}{$j}'>{$j}</label>\n";
			else echo "<input type='radio' name='t{$i}' value='point{$j}' id = 't{$i}{$j}' /> <label for='t{$i}{$j}'>{$j}</label>\n";
		}
		
	}	
}

function feed_tutor()
{
	
	global $ques_tutor;
	global $options_teach;
	
	echo "<div style='background-color:#0097a7;color:white;padding:2px;font-family:Open Sans Condensed, sans-serif;'><h2 style='text-align:center;font-family:Oswald,sans-serif;'>About the tutor</h2>Key:<br></div>";
	echo"<div class='enclosed_question_options_style' style='background-color:#0097a7;'>";
	foreach($options_teach as $opt)
	{
		echo "<div style='padding:2px;color:white;font-family:Open Sans Condensed, sans-serif;'><i>{$opt}</i><br>\n</div>";
	}
	echo"</div>";
	$i=0;
	foreach($ques_tutor as $ques)
	{
		$i++;
		echo "<h5 style='vertical-align:middle; font-family: Raleway, sans-serif; ''><i style='color:#0097a7;vertical-align:middle;' class='material-icons'>question_answer</i>{$ques}</h5>\n";
		for($j=1;$j<=5;$j++)
		{

			echo "<input type='radio' name='tu{$i}' value='point{$j}' id = 'tu{$i}{$j}' /> <label for='tu{$i}{$j}'>{$j}</label>\n";
		}
	}
	
}




	// echo"<div class='container-fluid'>";
	// echo "<div class='row'>";
	// 	echo "<div class='col-md-6'>";
	// 	feed_subject();
	// 	echo "</div>";//col ends
	// 	echo "<div class='col-md-6'>";
	// 	feed_teacher();
	// 	echo "</div>";// col ends
	// echo" </div>"; //row1 ends
	
	// echo "<div class='row'>";
	// 	echo"<div class='col-md-6'>";
	// 	feed_tutor();
	// 	echo"</div>";//col ends
	// echo"</div>";//row 2 ends
	// echo"</div>";//container ends
?>

