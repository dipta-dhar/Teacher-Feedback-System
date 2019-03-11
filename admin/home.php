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

function logout()
{
echo "<a href='admin_login.php?action=logout'>Logout</a>";
}



function fetchForms()
{
	echo "
<html>
    <head>
      <link href='icon?family=Material+Icons' rel='stylesheet'/>

      <script type='text/javascript' src='js/jquery-2.1.1.min.js'></script>
      <!--Import materialize.css-->
      <link type='text/css' rel='stylesheet' href='css/materialize.min.css'  media='screen,projection'/>
      
      <!--Let browser know website is optimized for mobile-->
      
      <script type='text/javascript'>
      $(document).ready(function() {
    $('select').material_select();
  });
        
          

      </script>
    </head>
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
      </div>";
      echo "
      <div class='container'>
      <div class='row'><h4 style='text-align:center; class'>Branch-wise Feedback Filling Status!! </h4></div>
      </div>


      ";

      $con = DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
      $qy='SELECT dept_name, dept_id FROM department';
      $con->query($qy);
      $res=$con->result();
      if(mysqli_num_rows($res) > 0){
      echo "<div class='row' class='flow-text'>

              <form id='form1' action= " . $_SERVER['PHP_SELF'] ." class = 'container ' method ='post'>
                <div class='input-field col s10 m8 l8 offset-l2 offset-m2'>

                  <select name = 'dept' >
                    <option value='0' >Choose Department </option> ";

      while($row = $res->fetch_assoc()){
          if(isset($_POST['submit']) && $_POST['dept']!=0 && $_POST['dept'] == $row['dept_id'])
              echo "<option value='".$row['dept_id']. "' selected > ". $row['dept_name'] ." </option>" ;
          else echo "<option value='".$row['dept_id']. "'> ". $row['dept_name'] ." </option>" ;
      }
      echo "</select> <label> Select Department </label>";

      echo "    </div>
                <div class='col offset-l7 offset-m7 offset-s5' class='flow-text'><button class='btn waves-effect waves-light centre' type='submit' id='submit' name='submit' >Submit </button>  </div>
                          
            </form>
            </div>
      ";
    }
     
    if(isset($_POST['submit']) && $_POST['dept'] != 0)
        {
          ; 
          display_chart($_POST['dept']);
        }

    echo "
<br/></br/>
    <div class='breaker_style'>
      <div class='container'>
      <div class='row'><h5 style='text-align:center; class'>Teacher Feedback Made Easy </h4></div>
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
          </div>";
    require_once("footer.php");
  }

  function display_chart($dept){

        
        $filled = [0, 0, 0, 0];
        $total =[0, 0, 0, 0];

        
        $con = DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        

        $qy = 'SELECT student_id FROM (SELECT student_id, COUNT(feedback_status) as filled FROM student_course WHERE feedback_status = 1 GROUP BY student_id) S1 NATURAL JOIN (SELECT student_id, COUNT(feedback_status) as total FROM student_course GROUP BY student_id) S2 NATURAL JOIN (SELECT sid as student_id, dept_id FROM student_details) S3 WHERE filled = total and dept_id = '.$dept;
        

        $con->query($qy);
       
        $res=$con->result();
       
        if(mysqli_num_rows($res) > 0 ){
          
          while($row = $res->fetch_assoc()){
            
            $yr = 15 - intval ($row['student_id']/1000000);
            
           $filled[$yr]++;
          }
        }

        $qy = 'SELECT student_id FROM (SELECT student_id FROM student_course GROUP BY student_id)S1 NATURAL JOIN (SELECT sid as student_id,dept_id FROM student_details)S2 WHERE dept_id = '.$dept;
        $con->query($qy);
       
        $res=$con->result();
       
        if(mysqli_num_rows($res) > 0 ){
          echo "\n";
          while($row = $res->fetch_assoc()){
            $yr = 15 - intval ($row['student_id']/1000000);
            $total[$yr]++;
          }
        }
        

        $con->close();
        

      echo "

      <br><br>
      

      <div class='row'>
      
      <div class='container' class='col s12 m8 l6 offset-m2 offset-l3'>
      <div id='chartContainer' style='height:60%; width: 100%;' >
        
        <script type='text/javascript'>
        var dps1 = ". json_encode($filled) . ";
        var dps2 = ". json_encode($total) . ";



        //document.write(dps1);
        //document.write(dps2);

        

        var chart = new CanvasJS.Chart('chartContainer', {
            title: { text: 'Feedback Filling Status'},
            axisY: {title: 'No. of students' },
            axisX: {title: 'Branches'},
            data: [{
              type: 'column',
              
              dataPoints: [
              {label: '1st Year', y: dps1[0] },
              {label: '2nd Year', y: dps1[1] },
              {label: '3rd Year', y: dps1[2] },
              {label: '4th Year', y: dps1[3] }

              ]
            }]
          })

          chart.render();

        </script>
      </div> 
      </div> 
      </div>
    </body>
</html>";

  
}

?>