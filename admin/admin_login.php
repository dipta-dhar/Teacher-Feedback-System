<?php

require_once("functions.php");
require_once("common.php");


secure_session_start();
if(isset($_GET['action'])){
  //print_r($_SESSION);
  if($_GET['action']=='logout'){

      if(isset($_SESSION['login'])) {
        $id=(int)$_SESSION['login'];
        $con=DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        $qy="UPDATE logs set logout=NOW() where id={$id};"; 
        $con->query($qy);
        $con->close();
      }
    $_SESSION=array();
    @session_destroy();
  }
  if($_GET['action']=='expire') {
    $_SESSION=array();
    @session_destroy(); 
  }
}

if(isset($_POST['btn_sub'])) {
  checkFields();
}

function checkFields()
{
  $user=$_POST['username'];
  $pass=$_POST['pass'];
  $error=0;

  $user=(string)htmlspecialchars($user);
  $pass=htmlspecialchars($pass);
  
  // Error checking 

  if(empty($user))
    errRedirect(1);

  if(empty($pass))
    errRedirect(2);
  
  $con=DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  
  $qy="SELECT * from admin where uname='$user' and password='$pass'"; 
  
  $con->query($qy);
  
  $res=$con->result();
  //$pass=$pass; // encryption pending

  /*$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Error connecting to MySQL server.');
  
  
  $qy="SELECT * from admin where uname='$user' and password='$pass'"; 
  $res = mysqli_query($dbc, $qy)
      or die ('Data not read.');*/
  if(mysqli_num_rows($res)==1) {
    $row=mysqli_fetch_array($res,MYSQLI_ASSOC);
    
    $_SESSION=$row;
    $_SESSION['valid']='ad_yes';
    $qy="INSERT into logs set user='$user', login=NOW();";
    $con->query($qy);
    
    if(mysqli_affected_rows($con->link())) {
      $login=mysqli_insert_id($con->link());
      $_SESSION['login']=$login;
    }
    $_SESSION['login_id'] = $row['uname'];
    //$_SESSION['email'] = $row['email'];
    $_SESSION['role'] = 'admin';
    $_SESSION['id'] = $row['id'];
    $con->close();
    header("Location: home.php");
  } 
}

function errRedirect($error) {
  header("Location: index.php?err={$error}");
    exit();

  }
?>

<html>
    <head>
      <!--Import Google Icon Font-->
      <link href="icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      
    </head>
    </head>

    <body >
      <!--Import jQuery before materialize.js-->
      
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
    <br>
    <div class='navbar-fixed' >
      <nav class="black">
        <div class='nav-wrapper' >
          <a href='admin_login.php' class='brand-logo center'><img src='logo2.png'></img></a>
        </div>
      </nav>
    </div>
    
    <br> <br>
    <div class="row" >
      
      <div class="col s12 m8 l6 offset-m2 offset-l3"  class="container" class="black">
        
          <div class="card-panel col s10 m10 l10 offset-m1 offset-l1 offset-s1 white" >
            <div class="row">
            <div class="col s6 m6 l6" ><span class="flow-text"><h4>&nbspAdmin Login</h4></span></div>
            <div class="right" ><span class="flow-text"><nav>
              <div class="nav-wrapper"><a href="#" class="brand-logo right"><img src="logo.jpg"></a></div></nav></span></div>
            </div>

            <div class='row'>    
            <form name='form1' method='post' action='admin_login.php'>
            <div class='row'>
              <div class='input-field col s12'>
                <input name='username'  id='username' type='text' class='validate' required='' aria-required='true'>
                <label id='username_label' for='username'>Username</label>
              </div>
            </div>
          
            <div class='row'>
              <div class='input-field col s12'>
                <input name='pass'  id='pass'  type='password' class='validate' required='' aria-required='true'>
                <label id='pass_label' for='password'>Password</label>
              </div>
            </div>    
            <div class="container"><button class='btn waves-effect waves-light right' type='submit' id='btn_sub' name='btn_sub' >Submit </button>  </div>
                     
            <input type='hidden' value='1' name='identity' id='identity' />
            </form>
          </div>
          </div>
          </div>
        </div>
      </div>
    </div>
    
    </body>
  </html>
  
  <?php
      require_once('footer.php');
      ?>
