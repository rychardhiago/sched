<?php
	require_once('session.php');
	require_once('classes/class.profissionais.php');
	$user_logout = new profissionais();

    $user_logout->doLogout();
    $user_logout->redirect('index.php');

?>
