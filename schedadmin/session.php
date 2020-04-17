<?php

	session_start();

    require_once("classes/class.usuarios.php");
    $auth_user = new usuarios();

	if(!$auth_user->is_loggedin()){
        $auth_user->redirect('index.php');
	}

?>