<?php
session_name("login_sched"); session_start();
$_SESSION['empresaid'] = $_POST['empresaid'];
$_SESSION['empresa'] = $_POST['empresa'];
$_SESSION['cidadeid'] = $_POST['cidadeid'];
$_SESSION['usacomissao'] = $_POST['usacomissao'];
?>