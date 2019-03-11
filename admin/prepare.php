<?php

	require_once("functions.php");
  	require_once("common.php");

	$con=DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	$con1=DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	$con2=DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

	$qy = "SELECT teacher_id as fid,course_id as cid FROM teacher_course";
	$con->query($qy);
	$res = $con->result();

	while($row = $res->fetch_assoc()){
		echo "***";
			$fid = $row['fid'];
			$cid = $row['cid']; 
		for($i=1; $i<8; $i++){
			$ques = $i;
			$qy2 = "INSERT INTO feedback_faculty(fid,cid,q_no,point1,point2,point3,point4,point5,tutor) VALUES ('$fid','$cid', '$ques', 0, 0, 0, 0, 0, 0)";
			$con1->query($qy2);
			$res1 = $con1->result();

			$qy3 = "INSERT INTO feedback_course(cid,q_no,point1,point2,point3,point4,point5) VALUES ('$cid', '$ques', 0, 0, 0, 0, 0)";
			$con2->query($qy3);
			$res2 = $con2->result();

			echo "\n";
		}
	}

	?>