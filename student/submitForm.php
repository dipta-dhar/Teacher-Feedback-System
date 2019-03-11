<?php
include("../functions.php");
include("../common.php");
include("viewform.php");
secure_session_start();
if(!isset($_SESSION["id"])){
	header("Location:../index.php");
}
main_header("Feedback",1);
	nav_student();




if(isset($_POST['fill_feedback'])){

	$i = $_POST['fill_feedback'];
	
	$_SESSION["course"] = $i;
	$conn = DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	$qy = "SELECT tutor,teacher_id,cname FROM teacher_course NATURAL JOIN (SELECT cname, cid as course_id FROM course_master) T where course_id = '$i' ";

	$conn->query($qy);
	$res = $conn->result();


	{
		$row = $res->fetch_assoc();
		$_SESSION["tutor"] = $row['tutor'];
		$_SESSION["teacher"] = $row['teacher_id'];
		$_SESSION["cname"] = $row['cname'];
		
	}
	$i = $_SESSION["teacher"];
	
	$qy = "SELECT name FROM faculty_details where fid = '$i ' ";
	$conn->query($qy);
	$res = $conn->result();
	{
		$row = $res->fetch_assoc();
		$_SESSION['t_name'] = $row['name'];

	}

	$conn->close();

	
	
}
?>
	<html>
<head>
	<title>FeedBack Form</title>
	
	
</head>
<body>
	<?

if(isset($_POST['submit'])){
	


	$db=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if(!$db){
		die("Unable to connect to the database");
	}
	$cid=htmlspecialchars($_SESSION["course"]);
	$fid=htmlspecialchars($_SESSION["teacher"]);	

	$count = 0;
	for($i=1; $i<=5; $i++){
		if(isset($_POST["s{$i}"] ))	
			$count++;
	}
	for($i=1; $i<=10; $i++){
		if(isset( $_POST["t{$i}"] ))
				$count++;
	}
	if($count == 15){

		for($i=1;$i<=10;$i++){	
		$option=$_POST["t{$i}"];
		$ques=$i;
		$qy = "SELECT * FROM feedback_faculty where fid='$fid' and cid='$cid' and q_no='$ques' ";
		$res = mysqli_query($db, $qy);

		if(mysqli_num_rows($res) == 0){
			//echo "'$fid'  '$cid'    ";
			$qy = "INSERT INTO feedback_faculty(fid, cid, q_no, point1, point2, point3, point4, point5, tutor) VALUES ('$fid','$cid', '$ques', 0, 0, 0, 0, 0, 0)";
			mysqli_query($db, $qy);
		}
		
		$sql="UPDATE feedback_faculty set $option=$option+1 where q_no='$ques' and fid='$fid' and cid='$cid' ";
		// echo $sql;
		// echo "<br>";
		if(mysqli_query($db,$sql)){

		}
		else{
			//error
		}
	}
	//course response
	for($i=1;$i<=5;$i++){	
		$option=$_POST["s{$i}"];
		$ques=$i;
		$qy = "SELECT * FROM feedback_course where cid = '$cid' and q_no = '$ques' ";
		$res = mysqli_query($db, $qy);
		if(mysqli_num_rows($res) == 0)
		{
			$qy = "INSERT INTO feedback_course VALUES ('$cid', '$ques', 0, 0, 0, 0, 0) ";
			mysqli_query($db, $qy);
		}
		$sql="UPDATE feedback_course  set $option=$option+1 where q_no={$ques} and cid='{$cid}'";
		// echo $sql;
		// echo "<br>";
		if(mysqli_query($db,$sql)){
			
		}
		else{
			//error
		}
	}
	if($_SESSION["type"]==1){
		//tutor response
		for($i=1;$i<=6;$i++){	
			$option=$_POST["tu{$i}"];
			$ques=$i;
			$sql="UPDATE feedback_faculty set $option=$option+1,tutor=1 where q_no={$ques} and cid='{$cid}' and fid={$fid} ";
			// echo $sql;
			// echo "<br>";
			if(mysqli_query($db,$sql)){
				
			}
			else{
				//error
			}
		}
	}
	$sql="UPDATE student_course set feedback_status=1 where student_id=".$_SESSION["id"]." and course_id='{$cid}'";
	mysqli_query($db,$sql);

	header("Location: index.php" );
	}
	else {
		$left_blank = 14-$count;
		echo "<div class='container center'>
				<h4> ".$left_blank." of 15 fields left blank !! </h4> </div>";

	}



	//inserting the responses to the required tables:feedback_course,feedback_faculty
	//teacher response
	
	//echo $sql;
	
}

?>
<!DOCTYPE html>

	
<script LANGUAGE="javascript" type="text/javascript">
		function ValidateForm(form){
			
			var error = 0;
			var i;
			for(i=1; i<=10; i++){
				if(form.t{i}.value == '')
					alert("Please fill out the Form Completely !!");
					error= 1;
					break;
			}
			if(error == 0) 
				alert("jlskdjfkls");
		}
		</script>

	
	<div class="container_fluid_style">
		<div class='know_my_depth_style'>
			<a class='a_style' href='index.php'>Home</a><i class="material-icons">trending_flat</i><a class='a_style_diff' href='#!'>Fill Feedback</a>
		</div>
		<form method=post action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			<div class="row">
				<div class="col m6">
					<?php feed_teacher(); ?>
				</div>
				<div class="col m6">
					<?php feed_subject(); ?>
				</div>
			</div>
			<?php if($_SESSION["type"]==1){
				?>
				<div class="row">
					<div class="col m6">
						<?php feed_tutor(); ?>
					</div>
				</div>
			<?php
			}
			?>
			<div class='row'>
				<div class="col m8 l8 offset-m2 offset-l2">
				<button  class="waves-effect waves-light btn" type="submit" name="submit" onClick="validateForm(this.form)">Submit</button>
				</div>
			</div>
			
		</form>
	</div>

</body>
</html>
<?php
require_once("../footer.php");
?>