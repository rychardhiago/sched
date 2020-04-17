<?php
    require_once("../session.php");
    if(!$auth_user->is_loggedin()) {
        $auth_user->redirect('../index.php');
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<title> SCHED | Estabelecimentos</title>
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
<script src="js/jquery-1.10.2.min.js"></script>

<!--clock init-->
<script src="js/css3clock.js"></script>
<!--Easy Pie Chart-->
<!--skycons-icons-->
<script src="js/skycons.js"></script>


<!--//skycons-icons-->
</head> 
<body>
   <div class="page-container">
   <!--/content-inner-->
	<div class="left-content">
	   <div class="inner-content">
		<!-- header-starts -->
			<div class="header-section">
						<!--menu-right-->
						<div class="top_menu">


							<!--/profile_details-->
								<div class="profile_details_left">
									<ul class="nofitications-dropdown">



                                        <li class="dropdown note">
                                            <a href="ajuda.php" target="_blank" title="Ajuda">
                                                <span style="font-size: 1.2em; font-weight: bold; color: #FFFFFF">?</span>
                                            </a>
                                        </li>

                                        <li class="dropdown note">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" >
                                                <span style="font-size: 1.2em; font-weight: bold; color: #FFFFFF"><i class="lnr lnr-user"></i></span>
                                            </a>

                                            <ul class="dropdown-menu two first">
                                                <li>
                                                    <div class="notification_header">
                                                        <h3 class="text-center">Minha conta </h3>
                                                    </div>
                                                </li>

                                                <li class="">
                                                    <a href="#">
                                                        <?php
                                                        $imagem = "../clientes/imagens/".$_SESSION['user_session'].".jpg";
                                                        if(file_exists($imagem)){
                                                            echo '<div class="user_img"><img src="'.$imagem.'"></div>';
                                                        }
                                                        else{
                                                            echo '<div class="user_img"><h1><i style="color: #00A4E4" class="glyphicon glyphicon-user"></i></h1></div>';
                                                        }
                                                        ?>

                                                        <div class="notification_desc">
                                                            <p><?php echo $_SESSION['nome']; ?></p>
                                                            <p><span>Último login: <?php echo $_SESSION['data']; ?></span></p>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="logout.php" title="Sair" class="text-center">
                                                        <div class="user_img"> </div>
                                                        <div class="notification_desc">
                                                            <p><i class="glyphicon glyphicon-log-out" style="color: #000000"></i> Sair</p>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>
							<div class="clearfix"></div>	
								</ul>
							</div>
							<div class="clearfix"></div>	
							<!--//profile_details-->
						</div>
						<!--//menu-right-->
					<div class="clearfix"></div>
				</div>
					<!-- //header-ends -->
						<div class="outter-wp">
							<h1>Todos estabelecimentos</h1>

                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    Estabelecimentos
                                </div>
                                <div class="panel-body">
                                    <div class="list-group">
                                        <?php
                                        $stmt = $auth_user->runQuery("SELECT pasta, nomefantasia FROM empresas WHERE excluido = 'N' and bloqueio = 'N' order by datacadastro ");
                                        $stmt->execute();
                                        while($row = $stmt->fetch()) {
                                            echo '<a href="../'.$row['pasta'].'" target="_blank" class="list-group-item"> <img src="../'.$row['pasta'].'/logo.png" height="30px"> '.$row['nomefantasia'].'</a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="panel-footer" style="font-style: italic"> © Todos os diretios reservados - SchedApp 2017</div>
                            </div>

										<!--//outer-wp-->
									</div>
									 <!--footer section start-->
           <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
               <div class="modal-dialog">
                   <div class="modal-content">
                       <div class="modal-header">
                           <button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
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
           <!--footer section start-->
           <footer>
               <p>&copy 2017 SCHEDAPP - Todos os direitos reservados | Desenvolvido por <a href="#" data-toggle="modal" data-target="#myModal">Rychard Hiago</a></p>
           </footer>
									<!--footer section end-->
								</div>
							</div>
				<!--//content-inner-->
			<!--/sidebar-menu-->
				<div class="sidebar-menu">
					<header class="logo">
					<a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> <a href="index.php"> <span id="logo"> <h1 style="color: #008DE7">.</h1></span>
					<!--<img id="logo" src="" alt="Logo"/>--> 
				  </a> 
				</header>
			<div style="border-top:1px solid rgba(69, 74, 84, 0.7)"></div>
			<!--/down-->
							<div class="down">
                                    <img src="../../images/pic1.png" height="100"><br>
                                    <a href="index.php"><h1 style="color: #FDA30E">SCHED</h1></a>
                                    <p>Versão 1.0.0</p>
									</div>
							   <!--//down-->
                           <div class="menu">
									<ul id="menu" >
										<li><a href="index.php" title="Dahsboard"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
										<li><a href="agendamentos.php" title="Meus agendamentos"><i class="glyphicon glyphicon-time"></i> <span>Meus agendamentos</span></a></li>
                                        <li><a href="estabelecimentos.php" title="Estabelecimentos"><i class="glyphicon glyphicon-th-list"></i> <span>Estabelecimentos</span></a></li>
                                        <li><a href="perfil.php" title="Configurações"><i class="glyphicon glyphicon-cog"></i> <span>Configurações</span></a></li>
								  </ul>
								</div>
							  </div>
							  <div class="clearfix"></div>		
							</div>
							<script>
							var toggle = true;
										
							$(".sidebar-icon").click(function() {                
							  if (toggle)
							  {
								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
								$("#menu span").css({"position":"absolute"});
							  }
							  else
							  {
								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
								setTimeout(function() {
								  $("#menu span").css({"position":"relative"});
								}, 400);
							  }
											
											toggle = !toggle;
							  return false;
										});
							</script>
<!--js -->
<link rel="stylesheet" href="css/vroom.css">
<script type="text/javascript" src="js/vroom.js"></script>
<script type="text/javascript" src="js/TweenLite.min.js"></script>
<script type="text/javascript" src="js/CSSPlugin.min.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>

<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
</body>
</html>