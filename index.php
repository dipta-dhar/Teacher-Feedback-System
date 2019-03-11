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
				$con->query("update logs set logout=NOW() where id={$id};");
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

displayForm();

function displayForm()
{

main_header("Login page",0);
echo "<script>
 $(document).ready(function(){
      $('.slider').slider({full_width: true});
    });
</script></head><body>";
echo "
			<div class='navbar-fixed'>
			<nav>
				<div class='nav-wrapper'>
				  <a href='#!' class='brand-logo center'><img id='logo_image' src='logo2.png'></img></a>
				  <a href='#' data-activates='mobile-demo' class='button-collapse'><i class='material-icons'>menu</i></a>
				  <!--<ul class='right hide-on-med-and-down'>				
						<li class='active tumble_identity'><a   href='#' onclick='change_identity_s()'>Student</a></li>
						<li class='tumble_identity'> <a   href='#' onclick='change_identity_t()'>Teacher</a></li>						
				  </ul>
				  <ul class='side-nav' id='mobile-demo'>
						<li class='active tumble_identity '><a   href='#' onclick='change_identity_s()'>Student</a></li>
						<li class='tumble_identity'><a   href='#' onclick='change_identity_t()'>Teacher</a></li>					
				  </ul>-->
				</div>
			</nav>
			</div>
			
			<div class='slider hoverable' id='slider_1'>
				<ul class='slides'>
				  <li>
					<img src='feedback1.jpg'> <!-- random image -->
					<div class='caption left-align'>
					 <h3 style='color:black'> Time to share your thoughts!</h3>
					 <h5 style='color:white'>Contribute in making the college a better place to be!!.</h5>
					</div>
				  </li>
				  <li>
					<img src='feedback2.jpg'> <!-- random image -->
					<div class='caption left-align'>
					  <h3 style='color:black'> Say Goodbye to Pen and Paper!</h3>
					  <h5 style='color:white'>Time to save Mother Earth!!</h5>
					</div>
				  </li>
				  <li>
					<img src='feedback3.jpg'> <!-- random image -->
					<div class='caption left-align'>
					<br><br><br><br><br><br>
					  <h3 style='color:#1e88e5;font-style:italic;'>Time Folks!!</h3>
					</div>
				  </li>
				</ul>
			</div>
			
			<div class='login_box_style'>  
			<div class='row'><div class='col s12 m5 offset-m3 l5 offset-l3'><h4>&nbspLogin Here</h4></div></div>
			<div class='row'>		 
				<form class='col s12 m5 offset-m3 l5 offset-l3 ' name='form1' method='post' action='index.php'>
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
					
					";
					/*<div class='row'>
					  <img class='responsive-img' src='recaptcha.php?q=".rand()."' id='captchaimg' />
					  <a href='javascript: refreshCaptcha()'>Click</a> to refresh
					</div>
					
					<div class='row'>
						<div class='input-field col s12'>
						  <input name='captcha'  id='captcha' type='text' class='validate' required='' aria-required='true'>
						  <label id='captcha_label' for='captcha'>Enter Captcha code</label>
						</div>
					</div>*/
					  
					echo "<button class='btn waves-effect waves-light ' type='submit' id='btn_sub' name='btn_sub' >Submit </button>					  
					<input type='hidden' value='1' name='identity' id='identity' />
				</form>
		    </div>
			<br>
			</div>
		    <script src='http://code.jquery.com/jquery-1.11.3.min.js'></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/js/materialize.min.js'></script>
<link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
			<div class='breaker_style'>
			<div class='container'>
			<div class='row'><h4 style='text-align:center;'>Teacher Feedback Made Easy!! </h4></div>
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
			
			</div>

<script>

/*
$( document ).ready(function(){
	  $('.button-collapse').sideNav();
	  find_errcode();
	  $('.tooltipped').tooltip({delay: 50});
});
function check_validity()
{
	var name=document.getElementById('username').value;
	var pattern_username=/^[\w]{8}$/
	if(!pattern_username.test(name))
	{
		alert('Username incorrect');
		return false;
	}
	else
	{
		var pwd=document.getElementById('pass').value;
		var pattern_pwd=/^{5,}$/
		if(!pattern_pwd.test(pwd))
		{
			alert('Password incorrect');
			return false;
		}
		
	}
	
}
function find_errcode()
{
	console.log('heya');
	var pathArray = window.location.href.split( '=' );
	console.log('PA:'+pathArray[1]);
	if(pathArray[1]===undefined)
	{
		console.log('exit');
		return;
	}
	else{
		var choice=pathArray[1];
		choice=parseInt(choice);
		console.log('enters');
		console.log(choice);
		switch(choice)
		{
			
			case 1:
				console.log('username entered');
				$('#username_label').addClass('active');
				break;
			case 2:
			    console.log('pwd entered');
				$('#pass_label').addClass('active');
				break;
			case 3:
				console.log('username entered');
				$('#username_label').addClass('active');
				break;
			case 4:
			{
				console.log('username entered');
				//$('#username_label').addClass('active');
				document.getElementById('username_label').className = 'active';
				console.log('over');
				break;
			}
			case 5:
				console.log('pwd entered');
				$('#pass_label').addClass('active');
				break;
			
			default:
			break;
		}
	}
	
}

*/

var link=location.href;
var ind=2;

if((ind=link.indexOf('err=')))
{
	
	var err=link.substring(ind+4);
	//alert(err);
	
	errCode(err);
	//alert('yes');
}

function errCode(err)
{
	if(err==5)
	{
		document.getElementById('pass').focus();
		$('#pass_label').toggleClass('active');
		alert('yes');
	}
}


function change_identity_s()
{
	document.getElementById('identity').value=1;
	var identity=document.getElementById('identity').value;
	console.log(identity);
	$('li.tumble_identity').toggleClass('active');
}

function change_identity_t()
{
	document.getElementById('identity').value=2;
	var identity=document.getElementById('identity').value;
	console.log(identity);
	$('li.tumble_identity').toggleClass('active');
}

</script>


<script type='text/javascript'>
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf('?'))+'?rand='+Math.random()*1000;
}
</script>
</body>
</html>
";
}

function checkFields() {
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

	if(preg_match("/[^0-9]/",$user))
		errRedirect(3);

	if(strlen($user)>8)
		errRedirect(4);
	
	/*if(!isset($_SESSION['captcha']) || $_SESSION['captcha']!=$_POST['captcha'])
		errRedirect(6);*/
	
	if(strlen($user)>7)
		$_POST['identity']=1;
	else
		$_POST['identity']=2;
	
	

	$con=DBConnection::connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	
	if($_POST['identity']=='1') {
		$qy="SELECT * from records_1 where id={$user} and password='{$pass}';";	
	}
	else if($_POST['identity']=='2') {
		$qy="SELECT * from t_records where id={$user} and password='{$pass}';";
	}
	else {
		return;
	}
	$con->query($qy);
	
	$res=$con->result();
	if(mysqli_num_rows($res)==1) {
		$row=mysqli_fetch_array($res,MYSQLI_ASSOC);
		
		$_SESSION=$row;
		$_SESSION['valid']='yes';
		$qy="INSERT into logs set user={$user}, login=NOW();";
		$con->query($qy);
		
		if(mysqli_affected_rows($con->link())) {
			$login=mysqli_insert_id($con->link());
			$_SESSION['login']=$login;
		}

		$con->close();
		if($_POST['identity']=='1') {
			$_SESSION['role']='student';
			header("Location: student/");
			exit();
		}
		if($_POST['identity']=='2') {
			$_SESSION['role']='teacher';
			header("Location: teacher/");
			exit();
		}
	}	
}

function errRedirect($error) {
	header("Location: index.php?err={$error}");
		exit();

}
require_once("footer.php");
?>
