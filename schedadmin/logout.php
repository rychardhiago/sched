<?php
	require_once('session.php');
	require_once('classes/class.usuarios.php');
	$user_logout = new usuarios();

    $user_logout->doLogout();
    $user_logout->redirect('index.php');

?>
