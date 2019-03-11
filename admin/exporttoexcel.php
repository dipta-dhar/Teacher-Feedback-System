    <?php  
    header('Content-Type: application/force-download');  
    if(isset($_POST['fname']) && isset($_POST['cname']))
    	$file = $_POST['fname'] + '_' + $_POST['cname'];
    else $file =$_POST['cname'];
    header('Content-disposition: attachment; filename='.$file);  
    // Fix for crappy IE bug in download.  
    header("Pragma: ");  
    header("Cache-Control: ");  
    echo $_POST['datatodisplay'];  
    ?>  