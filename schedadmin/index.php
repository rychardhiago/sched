<?php
session_start();
require_once("classes/class.usuarios.php");
$login = new usuarios();

if($login->is_loggedin()!=""){
    $login->redirect('home.php');
}

if(isset($_POST['btn-login'])) {
    $umail = strip_tags($_POST['txt_uname_email']);
    $upass = strip_tags($_POST['txt_password']);

    if($login->doLogin($umail,$upass)){
        $login->redirect('home.php');
    }
    else{
        $error = "Dados incorretos!";
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Teste Facilita - Administração | Login </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!--js-->
<script src="js/jquery-2.1.1.min.js"></script> 
<!--icons-css-->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!--Google Fonts-->
<link href='//fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Work+Sans:400,500,600' rel='stylesheet' type='text/css'>
<!--static chart-->
</head>
<body>	
<div class="login-page">
    <div class="login-main">  	

            <img src="images/logo_site.png" class="img-responsive center-block">
            <h1 class="text-center text-muted"> Sched - Administração </h1>

            <div id="error">
                <?php
                if(isset($error))
                {
                    ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                    <?php
                }
                ?>
            </div>
			<div class="login-block">
				<form method="post" id="login-form">
					<input type="text" name="txt_uname_email" placeholder="Email" required="">
					<input type="password" name="txt_password" class="lock" placeholder="Senha">
					<input type="submit" name="btn-login" value="Login">
				</form>

			</div>
      </div>
</div>

<div class="copyrights">
	<p>© 2017 SchedApp. Todos os direitos reservados | Desenvolvido por <a href="#" data-toggle="modal" data-target="#myModal">Rychard Hiago</a> </p><br>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="images\close.png"></button>
                    <h2 class="modal-title">Rychard Hiago - Desenvolvedor Web</h2>
                </div>
                <div class="modal-body">
                    (62) 9 8425-8554 <br>
                    rychardhiago@gmail.com

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

</div>	


<!--scrolling js-->
		<script src="js/jquery.nicescroll.js"></script>
		<script src="js/scripts.js"></script>
		<!--//scrolling js-->
<script src="js/bootstrap.js"> </script>
<!-- mother grid end here-->
</body>
</html>


                      
						
