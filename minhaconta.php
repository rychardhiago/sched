<?php
session_name("login_user_sched"); session_start();
require_once("classes/class.clientes.php.php");
$cliente = new clientes();

if(!$cliente->is_loggedin()){
    $cliente->redirect('index.php');
}

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Sched | Minha conta </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Augment Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'>
<!-- lined-icons -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
<!-- //lined-icons -->
    <script src="js/jquery-2.1.1.min.js"></script>
<!--clock init-->
</head> 
<body>

								
	   <div class="error_page">
           	<div class="error-top">
				<div class="login">
					<img src="images/logo_site.png" style="max-height: 10em;"><br><br>
					<h3 class="inner-tittle t-inner">Sched - Login</h3>
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
					<form name="login" method="post">
						<input name="email" type="email" class="text" placeholder="Email" >
						<input name="senha" type="password" placeholder="Senha">
						<div class="submit"><input name="btn-login" type="submit" value="Entrar" ></div>
						<div class="clearfix"></div>

						<div class="new">
							<p><a href="#">Esqueceu sua senha ?</a></p>
							<div class="clearfix"></div>
						</div>
					</form>
				</div>
			</div>
	   </div>
	   <br>

		<div class="footer">
		   <p>&copy 2017 SCHEDAPP - Todos os direitos reservados | Desenvolvido por <a href="#" data-toggle="modal" data-target="#myModal">Rychard Hiago</a></p>

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

<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
</body>
</html>