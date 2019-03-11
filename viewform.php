<?php

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
	echo "<h2>About the course</h2>\n";
	
	echo "Key:<br>\n";
	foreach($options_subject as $opt)
	{
		echo "<i>{$opt}</i><br>\n";
	}
	$i=0;
	foreach($ques_subject as $ques)
	{
		$i++;
		$j=0;
		echo "<h3>{$ques}</h3>\n";
		for($j=1;$j<=5;$j++)
		{
			echo "<input type='radio' name='o{$i}' value='{$j}' />{$j} \n";
		}
	}
}

function feed_teacher()
{
	global $ques_teacher;
	global $options_teach;
	echo "<h2>About the teacher</h2>\n";
	echo "Key:<br>\n";
	foreach($options_teach as $opt)
	{
		echo "<i>{$opt}</i><br>\n";
	}
	$i=0;
	foreach($ques_teacher as $ques)
	{
		$i++;
		echo "<h3>{$ques}</h3>\n";
		for($j=1;$j<=5;$j++)
		{
			echo "<input type='radio' name='o{$i}' value='{$j}' />{$j} \n";
		}
	}	
}

function feed_tutor()
{
	global $ques_tutor;
	global $options_teach;
	echo "<h2>About the tutor</h2>\n";
	echo "Key:<br>\n";
	foreach($options_teach as $opt)
	{
		echo "<i>{$opt}</i><br>\n";
	}
	$i=0;
	foreach($ques_tutor as $ques)
	{
		$i++;
		echo "<h3>{$ques}</h3>\n";
		for($j=1;$j<=5;$j++)
		{
			echo "<input type='radio' name='o{$i}' value='{$j}' />{$j} \n";
		}
	}
}

feed_subject();
feed_teacher();
feed_tutor();
?>

