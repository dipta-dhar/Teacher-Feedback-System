<?php

require_once('../functions.php');
require_once('../common.php');

secure_session_start();

if(isset($_SESSION['id']) and isset($_SESSION['name']) and isset($_SESSION['role']) and $_SESSION['role']=='student') {
	body_main();
}
else {
	header("Location: ../index.php?action=expire");
	exit();
}

function body_main() {
	main_header("Student home",1);
	nav_student();
	echo "
	<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
	<script type='text/javascript'>
	function link_click(){

				window.location.href = 'submitForm.php?tutor=' + tut + '&course_id=' + cid + '&teacher_id=' + fid  ;
	}
	</script>

	</head><body id='student_index_body_style'>

	<div class='container'>
		<div class='know_my_depth_style'>
			<a class='a_style' href='index.php'>Home</a>
		</div>
		<div class='row'>
		<div class='hide-on-med-and-down'>
			 <div class='col l12 z-depth-3' id='personal_details_style'>
				 <h3>Personal Details</h3>
				 <p>Name:<span class='details_style_blue' id='input_name'></span></p>
				 <p>Branch:<span class='details_style_blue' id='input_branch'></span></p>
				 <p>Year:<span class='details_style_blue' id='input_year'></span></p>
		 
				 
			 
			 </div>
			 <div class = 'row'>
				<table class='highlight responsive-table hoverable' style='background-color:#ffffcc;'>
				<thead>
				  <tr>
					  <th class='details_style_green' data-field='id'>Course Id</th>
					  <th class='details_style_green' data-field='name'>Course Name</th>
					  <!--th data-field='price'>Instructor Name</th!-->
					  <th class='details_style_green' data-field='status'>Feedback Status</th>
				  </tr>
				</thead>";


			$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			$var = $_SESSION['id'];
			$dep = $var[4];

			$s = array();
			$curryr = 16;
			$fno = $var[0];
			$sno = $var[1];
			$stuyr = $var[0]*10 + $var[1];
			$year = $curryr - $stuyr ;
			if($year == 4 )
			{
				if($dep == 6)
					$dep = 9;
				else if($dep > 6)
					$dep--;
			}
			if($var[2] == 2)
			{
				$dep = $var[3]*10 + $var[4];
			}
				
			//echo $dep;

			$display_query = "SELECT * FROM (student_course s1 NATURAL JOIN teacher_course s2) NATURAL JOIN (SELECT cid as course_id, cname FROM course_master) s3 WHERE student_id = '{$var}' and dept_id = '$dep'";
			$result = mysqli_query($conn, $display_query);
			if(mysqli_num_rows($result)>0)
			{
				echo "<form method='post' action='submitForm.php' ";
				while($row = mysqli_fetch_assoc($result)) 
				{ 
					$_SESSION['type'] = 2;
					echo '<tr>';
					echo '<td>'  . $row['course_id'] . '</td>';
					echo '<td>'  . $row['cname'] . '</td>';
					$i = 0;
					if($row['feedback_status']==0){
						
						echo "<td> <button class='btn waves-effect waves-light' type = 'submit' id='fill_feedback' name='fill_feedback' value = ".$row['course_id']. ">Fill Feedback </button> </td>";
						echo "<td> <input type='hidden' id='tutor".$i."' name='tutor".$i."' value=".$row['tutor'] ." </td>";
						echo "<td> <input type='hidden' id='course_id".$i."' name='course_id".$i."' value=".$row['course_id'] ." </td>";
						echo "<td> <input type='hidden' id='teacher_id".$i."' name='teacher_id".$i."' value=".$row['teacher_id'] ." </td>";
						$i++;
					}
				else
					echo '<td>'  .  'Feedback Filled' . '</td>';
				echo '</tr>';
				}
			}

		mysqli_close($conn);

		echo"
		</table>
		</div>
		</div>
		<div class='hide-on-large-only'>
		<div class='row'>
		<div class='col s12 m7 offset-m3'>
		 <div class='card'>
				
				<div class='card-content'>
				  <!--span class='card-title activator grey-text text-darken-4'>Card Title<i class='material-icons right'>more_vert</i></span>
				  <!--p><a href='#'>This is a link</a></p!-->
				  <span class='card-title activator grey-text text-darken-4'>Name<i class='material-icons right'>more_vert</i></span>
				</div>
				<div class='card-reveal'>
				  <span class='card-title grey-text text-darken-4'>Personal Details<i class='material-icons right'>close</i></span>
				   <div class='col l6 offset-l1'>
				
				 <p>Name:<span id='input_name'>Name</span></p>
				 <p>Branch:<span id='input_branch'></span></p>
				 <p>Year:<span id='input_year'></span></p>
		 
			 </div>
				</div>
			</div>
         </div> 
		</div>	

		
		</div>
		</div>
	</div>";
function parse_sid($s)
{
	$info = array();
	$con = DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	$dep = $s[3]*10 + $s[4];

	$curryr = 16;
	$fno = $s[0];
	$sno = $s[1];
	$stuyr = $s[0]*10 + $s[1];
	$year = $curryr - $stuyr ;
	$info["year"] = $year;
	$b = "NO BRANCH ";
	if($s[2] == 1)
	{
		if($year == 4 && $curryr == 16 ){
			if($dep == 6)
				$dep = 9;
			else if($dep > 6)
				$dep--;
		}
	}
	$qy = "SELECT dept_name FROM department where dept_id = '$dep'";
	echo $dept_name;
	$con->query($qy);
    $res=$con->result();
    if(mysqli_num_rows($res) == 1)
    while($row = $res->fetch_assoc() ){
    	$b = $row['dept_name'];
    }
    $con->close();
	$info["branch"] = $b;
	return $info;
}

	$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$sql = "Select * from student_details where sid = '$_SESSION[id]';";
	$result = $conn->query($sql);
	$count = $result->num_rows;
	if($count==1)
	{
		$row = $result->fetch_assoc();
		$sid = $row["sid"];
		$name = $row["name"];
	}
	$info = parse_sid($sid);
	$year = $info["year"];
	$branch = $info["branch"];

	echo "<script type='text/javascript'>;
	var a='$name';

	document.getElementById('input_name').innerHTML=a;
	var b = '$branch';
	document.getElementById('input_branch').innerHTML=b;
	var c = '$year';
	document.getElementById('input_year').innerHTML=c;
	</script>";
				
	echo "</body>";
	echo "</html>";

}
require_once("../footer.php");
?>
