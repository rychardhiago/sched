<?php
require_once('../session.php');
require_once('../classes/class.clientes.php');
$user_logout = new clientes();

$user_logout->doLogout();
$user_logout->redirect('../index.php');

?>