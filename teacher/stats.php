<?php

require_once('../functions.php');
require_once('../common.php');

secure_session_start();

if(isset($_SESSION['id']) and isset($_SESSION['name']) and isset($_SESSION['role']) and $_SESSION['role']=='teacher') {
	$res=fetchValues();
	body_main($res);
}
else {
	header("Location: ../index.php?action=expire");
	exit();
}

function body_main($res) {
	$name=$_SESSION['name'];
	main_header("{$name} home",1);
	nav_teacher();
	echo<<<_END

<!--Load the AJAX API-->
    
_END;
	echo "</head><body>";
	if(empty($res)){
		echo "<h3>No records found!</h3>";
	}
	else {
		displayValues($res);
	}
	/* Teacher main profile here 

	*/

	echo "</body>";
	echo "</html>";
}

function fetchValues() {

	$rows=array();
	$con=DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if(isset($_GET['id']))
	$ref=mysqli_real_escape_string($con->link(),htmlspecialchars($_GET['id']));
	else 
		return $rows;

	$qy="SELECT * from feedback_faculty where cid='{$ref}';";
	$con->query($qy);
	$res=$con->result();
	if(mysqli_num_rows($res)>0) {
		while($row=mysqli_fetch_array($res,MYSQLI_ASSOC)) {
			$rows['teacher'][]=$row;
		}
	}
	else {
		return $rows;
	}

	$qy="SELECT * from feedback_course where cid='{$ref}';";
	$con->query($qy);
	$res=$con->result();
	if(mysqli_num_rows($res)>0) {
		while($row=mysqli_fetch_array($res,MYSQLI_ASSOC)) {
			$rows['course'][]=$row;
		}
	}
	
	$con->close();
	return $rows;
}

function displayValues($rows) {

	global $ques_subject;
	global $ques_teacher;
	if(empty($rows)) {
		return;
	}


$res=array();
$array=array();

$col1=array(
  'id'=>'',
  'label'=>'Points',
  'pattern'=>'',
  'type'=>'string');

$col2=array(
  'id'=>'',
  'label'=>'No of students',
  'pattern'=>'',
  'type'=>'number');

$array['cols'][]=$col1;
$array['cols'][]=$col2;

foreach($rows['course'] as $row) {
	$array['rows']=array();
	for($i=1;$i<=5;$i++) {
	    $v3=array();
	    $v1['v']='P'.$i;
	    $v2['v']=(int)$row['point'.$i];
	    $v3['c'][]=$v1;
	    $v3['c'][]=$v2;

	  $array['rows'][]=$v3;
	}
$res['course'][]=json_encode($array);
}

foreach($rows['teacher'] as $row) {
	$array['rows']=array();
	for($i=1;$i<=5;$i++) {
	    $v3=array();
	    $v1['v']='P'.$i;
	    $v2['v']=(int)$row['point'.$i];
	    $v3['c'][]=$v1;
	    $v3['c'][]=$v2;

	  $array['rows'][]=$v3;
	}
$res['teacher'][]=json_encode($array);
}
echo "<div class='container'>";
echo"
<button class='waves-effect waves-light btn' id='generate_pdf' type='button' >Generate PDF</button>
";
echo"<div class='know_my_depth_style'>
			<a class='a_style' href='index.php'>Home</a><i class='material-icons'>trending_flat</i><a class='a_style_diff' href='#!'>View Feedback</a>
		</div>";
		
		echo "<div id='newp' style='color: #fff;'>Stuff</div>";
		
		
echo"<div id='render_me'>";		
echo "<h3>Course:$_GET[id]</h3>\n";
$i=1;
foreach($ques_subject as $q) {
	if($i%2==1)
		echo "<div class='row'>";
echo "<div class='set col m6'>\n";
echo "<div class='ques'>{$q}</div>\n";
echo "<div id='chart_div_c{$i}' class='chart'></div>\n";
echo "</div>\n";
	if($i%2==0)
	echo "</div>";
$i++;
}

echo "</div>";

echo "<h4>Teacher</h4>\n";
$i=1;
foreach($ques_teacher as $q) {
	if($i%2==1)
		echo "<div class='row'>";
echo "<div class='set col m6'>\n";
echo "<div class='ques'>{$q}</div>\n";
echo "<div id='chart_div_t{$i}' class='chart'></div>\n";
echo "</div>\n";
	if($i%2==0)
		echo "</div>";
$i++;
}
echo "</div>";
echo "</div>";
echo"</div>";

echo "<script>";

$str='';
foreach($res['course'] as $r) {
$str=$str.','.$r;
}
echo "var crows=[{$str}];\n";
$str='';
foreach($res['teacher'] as $r) {
$str=$str.','.$r;
}
echo "var trows=[{$str}];\n";
echo "</script>";

echo<<<_END

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    function drawChart(val,id) {
      var jsonData = val;
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div_'+id));
      chart.draw(data, {width: 400, height: 240});
}


function drawCharts() {
	//alert('yes');
var clen=crows.length;
for(var i=0;i<clen;i++) {
	if(crows[i]) {
		//alert(JSON.stringify(crows[i]));
		drawChart(crows[i],'c'+i);
	}
}

var rlen=trows.length;
for(var i=0;i<rlen;i++) {
	if(trows[i]) {
		drawChart(trows[i],'t'+i);
	}
}
}

google.setOnLoadCallback(drawCharts);

</script>
_END;
echo"

	<script src='../pdf/jspdf.js'></script>
	<script src='../pdf/jspdf.plugin.from_html.js'></script>
	<script src='../pdf/jspdf.plugin.split_text_to_size.js'></script>
	<script src='../pdf/jspdf.plugin.standard_fonts_metrics.js'></script>
	<script src='../pdf/Blob.js'></script>
	<script src='../pdf/filesaver.js'></script>
	<script src='http://mrrio.github.io/jsPDF/dist/jspdf.debug.js'></script>";		
echo"<script>
	
	$('#generate_pdf').click(function(){
		
		var doc = new jsPDF();
		//alert('opent');
			// We'll make our own renderer to skip this editor

			// All units are in the set measurement for the document
			// This can be changed to 'pt' (points), 'mm' (Default), 'cm', 'in'
			var source=document.getElementById('render_me');
			alert(source.innerHTML);
			doc.fromHTML(source, 15, 15, {
				'width': 170
			});
			doc.save('Feedback.pdf');
			doc.output('dataurlnewwindow');
		
	});
			

</script>";


}
require_once("../footer.php");
?>