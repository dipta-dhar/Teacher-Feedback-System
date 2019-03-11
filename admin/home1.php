<?php
  require_once("functions.php");
  require_once("common.php");
?>


<html>
    <head>
      <!--Import Google Icon Font-->
      <link href="./icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      
      <!--Let browser know website is optimized for mobile-->
      
      <script type="text/javascript">
        function drawchart(){
          

      </script>
    </head>
    </head>

    <body >
      <!--Import jQuery before materialize.js-->

      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript" src="css/canvasjs.min.js"></script>
      <br>
      <div class='navbar-fixed' >
      <nav class="black">
        <div class='nav-wrapper' >
          <a href='home.php' class='brand-logo center'><img src='logo2.png'></img></a>
          <ul class="left hide-on-med-and-down">
            <li class="active"><a href="home.php">Home</a></li>
            <li ><a href="view_plots.php">View Plots</a></li>
        </div>
      </nav>
      </div>
      <?php
        $dbarray1 = array();
        $dbarray2 = array();
        $dbarray3 = array();
        $count = 0;
        $dps1 = array();
        $dps2 = array();
        $con=DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        $qy="SELECT branch, count(sid) as students_count from student_details GROUP BY branch ORDER BY branch ";
        $con->query($qy);
        $res=$con->result();

        //echo mysqli_num_rows($res);
        if(mysqli_num_rows($res) > 0)
        {

          while($row = $res->fetch_assoc()){
            array_push($dbarray1, $row["branch"]);
            array_push($dbarray2, $row["students_count"]);
          }

        }
        $qy = "SELECT COUNT(student_id) as counting, branch FROM (SELECT student_id, COUNT(feedback_status) as filled FROM student_course WHERE feedback_status = 0 GROUP BY student_id) S1 NATURAL JOIN (SELECT student_id, COUNT(feedback_status) as total FROM student_course GROUP BY student_id) S2 NATURAL JOIN (SELECT sid as student_id, branch FROM student_details) S3 WHERE filled = total GROUP BY branch ORDER BY branch";
        $con->query($qy);
        $res=$con->result();
        if(mysqli_num_rows($res) > 0){
          $i = 0;
          while($row = $res->fetch_assoc()){
            while($row["branch"] != $dbarray1[$i]){
              array_push($dbarray3, 0);
              $i++;
            }
            array_push($dbarray3, $row["counting"]);
          }
        }
        
        // find the number of students who filled all the feedbacks
        

      ?>
      <div class="row">
      <div class="container" class="col s12 m8 l6 offset-m2 offset-l3">
      <div id="chartContainer" style="height: 300px; width: 100%;" >
        
        <script type="text/javascript">
        var dps1 = <?php echo json_encode($dbarray1); ?>;
        var dps2 = <?php echo json_encode($dbarray2); ?>;
        var dps3 = <?php echo json_encode($dbarray3); ?>;
        //document.write(dps3);
        var dps = [{y: ((parseInt(dps3[0]))/parseInt(dps2[0])*100), label: dps1[0]}];
        for(var i=1; i<dps1.length; i++)
          dps.push({y: ((parseInt(dps3[i]))/parseInt(dps2[i])*100), label: dps1[i] })
        //document.write(dps)

        var chart = new CanvasJS.Chart("chartContainer", {
            title: { text: "% of students filled feedbacks"},
            axisY: {title: "Percentage"},
            axisX: {title: "Branches"},
            data: [{
              type: "column",
              
              dataPoints: dps
            }]
          })

          chart.render();

        </script>
      </div> 
      </div> 
      </div>
    </body>
</html>

<?php
  require_once("footer.php");
  ?>