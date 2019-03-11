<?php
  require_once("functions.php");
  require_once("common.php");



secure_session_start();

if($_SESSION['valid']=='ad_yes' and isset($_SESSION['id']) and isset($_SESSION['login_id']))
{
	//print_r($_SESSION);
	fetchForms();
	//logout();
}
else
{
	header("Location: admin_login.php?action=expire");
	exit();
}

function fetchForms(){
	echo "<html>
    <head>
      <!--Import Google Icon Font-->
      <link href='icon?family=Material+Icons' rel='stylesheet'/>
      <script src='js/jquery.min.js'></script>  
      <script type='text/javascript' src='js/jquery-2.1.1.min.js'></script>
      <!--Import materialize.css-->
      <link type='text/css' rel='stylesheet' href='css/materialize.min.css'  media='screen,projection'/>


      <!--Let browser know website is optimized for mobile-->
      <script type='text/javascript'>
      $(document).ready(function() {
    $('select').material_select();   

  });

		

		

		function call_1(form){
			var val1 = form.plot_cat.options[form.plot_cat.options.selectedIndex].value;
			var val2 = form.dept_id.options[form.dept_id.options.selectedIndex].value;
			var url = 'view_plots.php';
			var data = {plot_cat: val1 , dept_id : val2};

			$.post(url, data, function(data){
				$('#plot_faculty').html(data);
			});


		}
	
		function reload(form){
			var val1 = form.plot_cat.options[form.plot_cat.options.selectedIndex].value;
			var val2 = form.dept_id.options[form.dept_id.options.selectedIndex].value;
			
			
			if(val1 && val2 ){
				window.location.href = 'view_plots.php?plot_cat=' + val1 + '&dept_id=' + val2 ;
				
			}


			/*var xhttp = new XMLHttpRequest();
			$.ajax({
				type : 'POST',
				url: 'view_plots.php',
				data: {
					
				},
				success: function(){}
				
			});

			xhttp.open('POST', 'home.php', true);
			xhttp.send(); */
			
		}
		function reload_faculty(form){
			var val1 = form.plot_cat.options[form.plot_cat.options.selectedIndex].value;
			var val2 = form.dept_id.options[form.dept_id.options.selectedIndex].value;
			var val3 = form.plot_faculty.options[form.plot_faculty.options.selectedIndex].value;


			if(val1 && val2 && val3){
				window.location.href = 'view_plots.php?plot_cat=' + val1 + '&dept_id=' + val2 + '&plot_faculty=' + val3;
				
			}
		}

		function reload_faculty_course(form){
			var val1 = form.plot_cat.options[form.plot_cat.options.selectedIndex].value;
			var val2 = form.dept_id.options[form.dept_id.options.selectedIndex].value;
			var val3 = form.plot_faculty.options[form.plot_faculty.options.selectedIndex].value;
			var val4 = form.plot_faculty_course.options[form.plot_faculty_course.options.selectedIndex].value;

			if(val1 && val2 && val3 && val4){
				window.location.href = 'view_plots.php?plot_cat=' + val1 + '&dept_id=' + val2 + '&plot_faculty=' + val3 + '&plot_faculty_course=' + val4; 
				
			}
		}
	</script>
    </head>

    <body >
      <!--Import jQuery before materialize.js-->

	    
	    <script type='text/javascript' src='js/materialize.min.js'></script>
	    <script type='text/javascript' src='css/canvasjs.min.js'></script>
	    <div class='navbar-fixed' >
	    	<nav class='black'>
		        <div class='nav-wrapper' >
		          	<a href='home.php' class='brand-logo center'><img src='logo2.png'></img></a>
			        <ul class='left hide-on-med-and-down'>
			        	<li class='active'><a href='home.php'>Home</a></li>
			            <li ><a href='view_plots.php'>View Plots</a></li>
			        </ul>
			        <ul class='right hide-on-med-and-down'> 
			          	<li><a href='admin_login.php?action=logout'>Logout</a></li>
			        </ul>
		        </div>
	      	</nav>
	    </div>
      	<br><br>";


      	echo "<div class='row'>
      			<p id='demo'></p>
				<form id='form1'   action= " . $_SERVER['PHP_SELF'] ." class = 'container '>
					<div  class='flow-text'>
						
						<div class='input-field col s12 m9 l5' >
							<select name = 'plot_cat' onchange='reload(this.form)'>
								<option value='0' disabled selected> Choose your option </option>
								<option value='1' ";
								if(isset($_GET['plot_cat']) && $_GET['plot_cat']==1) 
									echo "selected";
								echo "> Faculty </option>";
								echo " <option value='2' ";
								 if(isset($_GET['plot_cat']) && $_GET['plot_cat']==2) 
								 	echo "selected";
								 echo "> Course </option>
							</select>
							<label >Plot Category</label>
						</div>
						
					</div>";

					$con=DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
					            $qy='SELECT dept_name, dept_id FROM department';
					            $con->query($qy);
					            $res=$con->result();
					            if(mysqli_num_rows($res) > 0){
					            	echo "<div class='flow-text'> <div class='input-field col s12 m9 l6 offset-l1'> ";
					            	
					              echo "<select name = 'dept_id' onchange='reload(this.form)' >
					              <option value='0'  > Choose your option </option>";
					              while($row = $res->fetch_assoc()){
					              	if(isset($_GET['dept_id']) && $_GET['dept_id'] == $row['dept_id'])
					                   		echo "<option value='".$row['dept_id']. "' selected > ". $row['dept_name'] ." </option>" ;
					                else echo "<option value='".$row['dept_id']. "'> ". $row['dept_name'] ." </option>" ;
					              }
					              
					              echo "</select> <label> Select Department </label>  </div> </div>";
					        }
					            
					            if(isset($_GET['plot_cat']) && isset($_GET['dept_id']) && $_GET['plot_cat']!=0 && $_GET['dept_id']!=0){
					            	
						            $plot_cat = $_GET['plot_cat'];
						            $dept_id = $_GET['dept_id'];
						            if(strlen($plot_cat)>0 && strlen($dept_id)>0 && isset($plot_cat) && isset($dept_id) ){
						  
						              if((int)$plot_cat == 1)
						              {
						                $qy = 'SELECT fid, name FROM faculty_details WHERE dept_id = '. $dept_id ;
						                $con->query($qy);
						                $res=$con->result();
						                if(mysqli_num_rows($res) > 0){
						                	echo "<div class='flow-text'>  <div class='input-field col s12 m9 l5' >";
						                	
						                  echo "<select name = 'plot_faculty'  class='validate' onchange='reload_faculty(this.form)'>
						                  <option value='' > Select Faculty </option>";
						                  while($row = $res->fetch_assoc()){ 
						                  	
						                  	if(isset( $_GET['plot_faculty']) && $row['fid'] == $_GET['plot_faculty'])
						                    	{
						                    		echo "<option value='".$row['fid']."' selected > ". $row['name'] ." </option>" ;
						                    		$fname = $row['name'];
						                    	}
						                    else echo "<option value='".$row['fid']."' > ". $row['name'] ." </option>" ;
						                  }
						                  echo "</select> <label>Select Faculty</label> </div> </div>";
						            }

						            	if(isset($_GET['plot_faculty'])){
						            		$fid = $_GET['plot_faculty'];
						            		$qy = "SELECT DISTINCT cid, cname FROM (SELECT teacher_id, course_id as cid FROM teacher_course)T1 NATURAL JOIN course_master WHERE teacher_id LIKE '$fid' " ;
						            		$con->query($qy);
						            		$res = $con->result();
						            		if(mysqli_num_rows($res) > 0){
						            			echo "<div class='flow-text'>  <div class='input-field col s12 m9 l6 offset-l1' >";
						            			
						            			echo "<select name='plot_faculty_course' class='validate' onchange='reload_faculty_course(this.form)' >  
						            			<option value='' > Select Course</option>";
						            			while($row = $res->fetch_assoc()){ 
						            				if(isset($_GET['plot_faculty_course']) && $row['cid'] == $_GET['plot_faculty_course'])
						                    			{
						                    				echo "<option value='".$row['cid']. "' selected> ". $row['cname'] ." </option>" ;
						                    				$cname = $row['cname'];
						                    			}
						                    		else echo "<option value='".$row['cid']. "' > ". $row['cname'] ." </option>" ; 

						                  }
						                  echo "</select> <label>Select Course</label></div> </div>";
						            		}
						            		else if(mysqli_num_rows($res) == 0)
						            			echo "</div> </div><div class='row' class='container' class='card-panel'><span class='red-text text-darken-2'><h5 style='text-align:center; class'>* Courses not available for Faculty : ". $fname." </h5></span></div>";
								   			else 
								   				echo "</div> </div><div class='row' class='container' class='card-panel'><span class='red-text text-darken-2'><h5 style='text-align:center; class'>* Faculty Not selected</h5></span></div>";
								   			
						            	}
						              }
						              else
						                {
						                  $qy = "SELECT cid, cname FROM (SELECT dept_id, course_id as cid FROM teacher_course)T1 NATURAL JOIN course_master WHERE dept_id = '$dept_id' " ;
						                  $con->query($qy);
						                  $res=$con->result();
						                  if(mysqli_num_rows($res) > 0){
						                  	echo "<div class='flow-text'>  <div class='input-field col s12 m9 l6' >";
						                  	
						                    echo "<select name = 'plot_course'  class='validate'>
						                    <option value='' disabled selected> Select Course </option>";
						                    while($row = $res->fetch_assoc()){
						                      if(isset($_GET['plot_course']) && $_GET['plot_course'] == $row['cid'])
						                      	{
						                      		echo "<option value='".$row['cid']. "' selected> ". $row['cname'] ." </option>" ;
						                      		$cname = $row['cname'];
						                      	}
						                      else 
						                      	echo "<option value='".$row['cid']. "'> ". $row['cname'] ." </option>" ;
						                    }
						                    echo "</select> <label>Select Course</label> </div> </div>";
						            }
						              }
						              echo "<br><br>";
						              echo "<div class='row' ><div class='container col offset-l5 offset-m5 offset-s5'><button class='btn waves-effect waves-light centre' type='submit' id='submit' name='submit' >Submit </button> </div> </div>";
						              
						            }
						            else echo"*Select Plot Category and Department";

						        }
			echo "</form>
			</div>";

			{
					if(isset($_GET['submit']) && ( (isset($_GET['plot_faculty']) && isset($_GET['plot_faculty_course']) ) || isset($_GET['plot_course']))){

						            	$dbarray1 = array();
						            	$dbarray2 = array();
						            	$dbarray3 = array();
						            	$dbarray4 = array();
						            	$dbarray5 = array();
						            	
						            	if(isset($_GET['plot_course'])){
						            		
						            		$id = $_GET['plot_course'];
						            		$plot_for = 2;
						            		
								            $qy="SELECT * FROM feedback_course WHERE cid LIKE '$id' ";
								            
								            
						            	}
						            	else if(isset($_GET['plot_faculty'])){
						            		
						            		$id = $_GET['plot_faculty'];
						            		$cid = $_GET['plot_faculty_course'];

						            		$plot_for = 1;
						            		$qy = "SELECT * FROM feedback_faculty WHERE cid LIKE '$cid' AND fid LIKE '$id' " ;
						            		}

						            		$con->query($qy);
						            		
								            $res=$con->result();
								            
								            
								            if(mysqli_num_rows($res) > 0){
								            	while($row = $res->fetch_assoc()){
														
								            			array_push($dbarray1, $row['point1']);
								            			array_push($dbarray2, $row['point2']);
								            			array_push($dbarray3, $row['point3']);
								            			array_push($dbarray4, $row['point4']);
								            			array_push($dbarray5, $row['point5']);
								            			
								            	}
								            	
								            	
								            	$con->close();

								            	echo "
											      <div class='container'>
											      <div class='row'><h5 style='text-align:center; class'>";
											      if($plot_for == 1)
											        	{	echo "Feedback Status for Faculty : ". $fname  ." <br/>and Course :". $cname;}
											      else
											        	echo "Feedback Filling Status for Course  : " . $cname;
											      echo "</h5></div>
											      </div>


											      ";

											      ?>

								            <br>
											      <div class='row'>

											      <div >
											      

											      		<form action='getXLS.php' method='POST' onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable").eq(0).clone() ).html() )' >
											      		
											      		
      													<div class='container' ><div class='right'><button class='btn waves-effect waves-light centre' type='submit' id='btnExport' name='btnExport' > Export to Excel </button> </div> </div>
						              					<input type="hidden" id="datatodisplay" name="datatodisplay">
						              					<div id='divExport' class='container'>
										            	<table class='highlight' id='ReportTable'>
										            		<thread>
										            			<th data-field='question'> Question </th>
										            			<th data-field='rating_1' > Rating 1 </th>
										            			<th data-field='rating_2' > Rating 2 </th>
										            			<th data-field='rating_3' > Rating 3 </th>
										            			<th data-field='rating_4' > Rating 4</th>
										            			<th data-field='rating_5' > Rating 5 </th>
										            		</thread>

										            		<tbody> 
										           <?php
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


															$ques_subject=array("The content of the course was up-to-date?",
																				"The organisation & structure of the course was adequate?",
																				"Sufficient weightage was given to tutorial / assignments / practicals /case studies / projects?",
																				"Course objectives and course outcomes were clear?",
																				"The course is important for this degree programme?");


										            			if($plot_for == 1){
										            				$iter = 10;
										            			}
										            			else $iter = 5;

										            			for($i=0; $i<$iter; $i++){
										            				
										            				echo "<tr>";
										            				if($plot_for == 1)
										            					echo "<td>".$ques_teacher[$i]."</td>";
										            				else
										            					echo "<td>".$ques_subject[$i]."</td>";
										            				echo "<td>".$dbarray1[$i]."</td>";
										            				echo "<td>".$dbarray2[$i]."</td>";
										            				echo "<td>".$dbarray3[$i]."</td>";
										            				echo "<td>".$dbarray4[$i]."</td>";
										            				echo "<td>".$dbarray5[$i]."</td>";
										            				echo "</tr>";
										            			}
										            			
										            		echo "</tbody>
										            	</table>";

										            	if($plot_for == 1)
										            			echo "<input type='hidden' id='fname' name='fname' value='".$fname."'>";
										            	echo "<input type='hidden' id='cname' name='cname' value='".$cname."'>";


										            	echo "
										            	</div>

										            	</div>
										            	</div>
										            	</form>
										            ";


										            echo " <br><br>
											      <div class='row'>

											      <div class='container' class='col s12 m8 l6 offset-m2 offset-l3'>
											      <div id='chartContainer' style='height:60%; width: 100%;' >";



											echo "<script type='text/javascript'>
											        var dps1 = ". json_encode($dbarray1) . ";
											        var dps2 = ". json_encode($dbarray2) . ";
											        var dps3 = ". json_encode($dbarray3) . ";
											        var dps4 = ". json_encode($dbarray4) . ";
											        var dps5 = ". json_encode($dbarray5) . ";
											        var fname = ". json_encode($fname) . ";
											        var plot_for = ". json_encode($plot_for) . ";
											        var cname = " . json_encode($cname) . " ;
 
											        if(plot_for == 1)
											        	var iter = 10;
											        else var iter = 5;

											        var total = new Array(10);
											        for(var i=0; i<iter; i++){
											        	total[i]=0;
											        	total[i]+= parseInt(dps1[i]) + parseInt(dps2[i]) + parseInt(dps3[i]) +parseInt(dps4[i]) +parseInt(dps5[i]);
											        }parseInt()";



											        echo "
											        document.write(total);
											        

											        var _dps1 = [{y: (((parseInt(dps1[0]))/parseInt(total[0]))*100), label: 1}];
											        for(var i=1; i<iter; i++)
											        	_dps1.push({y: (((parseInt(dps1[i]))/parseInt(total[i]))*100), label: i+1});

											        var _dps2 = [{y: (((parseInt(dps2[0]))/parseInt(total[0]))*100), label: 1}];
											        for(var i=1; i<iter; i++)
											        	_dps2.push({y: (((parseInt(dps2[i]))/parseInt(total[i]))*100), label: i+1});

											        var _dps3 = [{y: (((parseInt(dps3[0]))/parseInt(total[0]))*100), label: 1}];
											        for(var i=1; i<iter; i++)
											        	_dps3.push({y: (((parseInt(dps3[i]))/parseInt(total[i]))*100), label: i+1});

											        var _dps4 = [{y: (((parseInt(dps4[0]))/parseInt(total[0]))*100), label: 1}];
											        for(var i=1; i<iter; i++)
											        	_dps4.push({y: (((parseInt(dps4[i]))/parseInt(total[i]))*100), label: i+1});

											        var _dps5 = [{y: (((parseInt(dps5[0]))/parseInt(total[0]))*100), label: 1}];
											        for(var i=1; i<iter; i++)
											        	_dps5.push({y: (((parseInt(dps5[i]))/parseInt(total[i]))*100), label: i+1});






											        
											        //document.write(dps)
											        if(plot_for == 1)
											        	var text_title = 'Feedback Filling Status for Faculty : ' + fname + ' and Course :' + cname;
											        else
											        	var text_title = 'Feedback Filling Status for Course  : ' + cname;
											        var chart = new CanvasJS.Chart('chartContainer', {
											            title: { fontSize : 16, text: text_title},
											            axisY: {title: 'Percentage', minimum:0, maximum:100},
											            axisX: {title: 'Question Number'},
											            data:[{ 
											            	type: 'stackedColumn100',
											            	legendText : 'Point 1',
											            	showInLegend: 'true',
											            	dataPoints: _dps1
											            },
											            {
											            	type: 'stackedColumn100',
											            	legendText : 'Point 2',
											            	showInLegend: 'true',
											            	dataPoints: _dps2
											            },
											            {
											            	type: 'stackedColumn100',
											            	legendText : 'Point 3',
											            	showInLegend: 'true',
											            	dataPoints: _dps3
											            },
											            {
											            	type: 'stackedColumn100',
											            	legendText : 'Point 4',
											            	showInLegend: 'true',
											            	dataPoints: _dps4
											            },
											            {
											            	type: 'stackedColumn100',
											            	legendText : 'Point 5',
											            	showInLegend: 'true',
											            	dataPoints: _dps5
											            }]

											            });

											          chart.render();

											        </script>
											      </div> 
											      </div> 
											      </div>";
								   
								   			}
								   			else {
								   				if($plot_for == 1)
								   					echo "<div class='row' class='container' class='card-panel'><span class='red-text text-darken-2'><h5 style='text-align:center; class'>* Feedback Not Filled for Faculty : ". $fname." </h5></span></div>";
								   				else 
								   					echo "<div class='row' class= 'container' class='card-panel' ><span class='red-text text-darken-2'><h5 style='text-align:center; class'>* Feedback Not Filled for Course : ". $cname." </h5></span></div>";
								   			}
								   		

								            	

								            }

								            
								            
						            }
						      


						        echo "<br>
				<br>

			<div class='breaker_style'>
			<div class='container'>
			<div class='row'><h4 style='text-align:center; class'>Teacher Feedback Made Easy!! </h4></div>
				<hr>
					<div class='row spaced_style'>
						<div class='col s6 m3'>
						  <div class='card orange hoverable'>
							<div class='card-content white-text'>
							  <span class='card-title'>Time Saving</span>
							  <p>A smooth login ensures that not much effort is needed on the students' part to fill feedback.No lectures wasted!</p>
							</div>
						   </div>
						</div>
						
						
						<div class='col s6 m3'>
						  <div class='card grey hoverable'>
							<div class='card-content white-text'>
							  <span class='card-title'>Customized</span>
							  <p>A uniquely customized interface developed while prioritizing the requirements of end users. Extremely user-friendly </p>
							</div>
							
						  </div>
						</div>
						
						<div class='col s6 m3'>
						  <div class='card blue  hoverable'>
							<div class='card-content white-text'>
							  <span class='card-title'>Eco-Friendly</span>
							  <p>With a single login, a student gets access to fill feedback for each of his courses and instructors.No pen or paper needed :)</p>
							</div>
							
						  </div>
						</div>
						
						<div class='col s6 m3'>
						  <div class='card cyan hoverable'>
							<div class='card-content white-text'>
							  <span class='card-title'>Fair Deal!</span>
							  <p>Anonymity of each student is maintained at all levels. Teachers get an overall report of their performance in a pictorial format.</p>
							</div>
							
						  </div>
						</div>
					  </div>
					</div>
					</body>
</html>";


}


  require_once("footer.php");
  ?>
	
	
	


