<?php
session_name("login_sched"); session_start();
$output_dir = "../../empresas/".$_SESSION['empresaid']."/imagens/";
if (!file_exists($output_dir)) {
    mkdir($output_dir, 0777, true);
}
if(isset($_FILES["myfile"]))
{
	$ret = array();
	
//	This is for custom errors;	
/*	$custom_error= array();
	$custom_error['jquery-upload-file-error']="File already exists";
	echo json_encode($custom_error);
	die();
*/
	$error =$_FILES["myfile"]["error"];
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{
 	 	$fileName = $_FILES["myfile"]["name"];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
 		move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$_SESSION['user_session'].".".$ext);
    	$ret[]= $fileName;
	}
	else  //Multiple files, file[]
	{
	  $fileCount = count($_FILES["myfile"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {
	  	$fileName = $_FILES["myfile"]["name"][$i];
	  	$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$_SESSION['user_session'].".".$ext);
	  	$ret[]= $fileName;
	  }
	
	}
    echo json_encode($ret);
 }
 ?>