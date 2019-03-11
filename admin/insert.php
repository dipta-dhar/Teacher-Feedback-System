<?php

require_once("functions.php");
  require_once("common.php");

	$con=DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	$con2 = DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	$con3 = DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

	$qy = "SELECT course_id, student_id, feedback_status FROM `student_course` WHERE `course_id` LIKE '%_____H' ";
	$con->query($qy);
	$res=$con->result();
	//echo $res;
	if(mysqli_num_rows($res) > 0){
		echo mysqli_num_rows($res);
		while($row = $res->fetch_assoc() ){
			
			/*$course_id = substr($row['course_id'], 0, -1);
			$student_id = $row['student_id'];
			$feedback_status = $row['feedback_status'];
			//echo $course_id;
			$qy2 = "INSERT INTO teacher_course VALUES ('') ";
			$con2->query($qy2);
			$res3 = $con2->result();
			if (mysqli_num_rows($res3) == 0 )
				{
					$qy2 = "INSERT INTO temp1 values ('$student_id', '$course_id', '$feedback_status') ";
					$con3->query($qy2);
					$res4 = $con3->result();
				}
			*/
			
		}
	}


	?>
