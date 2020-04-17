<?php
session_name("login_user_sched");
session_start();
date_default_timezone_set('America/Sao_Paulo');

require_once("classes/class.clientes.php");
$auth_user = new clientes();

//if(!$auth_user->is_loggedin()){
  //  $auth_user->redirect('index.php');
//}

?>