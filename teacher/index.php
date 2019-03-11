<?php

require_once('../functions.php');
require_once('../common.php');

secure_session_start();

if(isset($_SESSION['id']) and isset($_SESSION['name']) and isset($_SESSION['role']) and $_SESSION['role']=='teacher') {
	body_main();
}
else {
	header("Location: ../index.php?action=expire");
	exit();
}

function body_main() {
	
	$name=$_SESSION['name'];
	main_header("{$name} home",1);
	nav_teacher();
	echo "</head><body>

	<div class='container'>
		<div class='know_my_depth_style'>
			<a class='a_style' href='index.php'>Home</a>
		</div>
		<div class='row'>
		<div class='hide-on-med-and-down'>
			 <div class='col l12 z-depth-3' id='personal_details_style'>
				 <h3>Personal Details</h3>
				  
				 <p>Name:<span class='details_style_blue' id='input_name'></span></p>
				 <p>Department:<span class='details_style_blue' id='input_dept'></span></p>
				 
			 </div>
			 <div class = 'row'>
				<table class='highlight responsive-table hoverable' style='background-color:#ffffcc;'>
				<thead>
				  <tr>
					  <th class='details_style_green' data-field='id'>Course Id</th>
					  <th class='details_style_green' data-field='name'>Course Name</th>
					  <th class='details_style_green' data-field='status'>Feedback</th>
				  </tr>
				</thead>";


			$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			$var = $_SESSION['id'];
			$display_query = "SELECT t.course_id,m.cname from teacher_course as t,course_master as m where t.course_id=m.cid and t.teacher_id='$_SESSION[id]'";
			$result = mysqli_query($conn, $display_query);
			if(mysqli_num_rows($result)>0)
			{
				
				while($row = mysqli_fetch_assoc($result)) 
				{ 
					echo '<tr>';
					echo '<td>'  . $row['course_id'] . '</td>';
					echo '<td>'  . $row['cname'] . '</td>';
					$cid = $row['course_id'];
					echo '<td>'  . "<a href = 'stats.php?id=$row[course_id]'> Feedback </a>" . '</td>';
				}					
				echo '</tr>';
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
				 <p>Deaprtment:<span id='input_dept'></span></p>
		 
			 </div>
				</div>
			</div>
         </div> 
		</div>	

		
		</div>
		</div>
	</div>";
function parse_id($s)
{
	$info = array();
	$b = "NO BRANCH O_o";
	switch($s[0])
	{
		case 1:
		{
			$b = "AERO";
			break;
		}
		case 2:
		{
			$b = "CIVIL";
			break;
		}
		case 3:
		{
			$b = "CSE";
			break;
		}
		case 4:
		{
			$b = "ELECTRICAL";
			break;
		}
		case 5:
		{
			$b = "E & EC";
			break;
		}
		case 6:
		{
			$b = "MECHANICAL";
			break;
		}
		case 7:
		{
			$b = "METALLURGY";
			break;
		}
		case 8:
		{
			$b = "PRODUCTION";
			break;
		}
		default:
			$b = "NO BRANCH O_o";
	}
	$info["branch"] = $b;
	return $info;
}
	$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$sql = "Select * from faculty_details where fid = '$_SESSION[id]';";
	$result = $conn->query($sql);
	$count = $result->num_rows;
	if($count==1)
	{
		$row = $result->fetch_assoc();
		$sid = $row["fid"];
		$name = $row["name"];
	}
	$info = parse_id($sid);
	$branch = $info["branch"];

	echo "<script type='text/javascript'>;
	var a='$name';
	document.getElementById('input_name').innerHTML=a;
	var b = '$branch';
	document.getElementById('input_dept').innerHTML=b;
	</script>";
				
	echo "</body>";
	echo "</html>";

}
require_once("../footer.php");
?>
