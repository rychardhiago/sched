<?php
    require_once("../session.php");
    if(!$auth_user->is_loggedin()) {
        $auth_user->redirect('../index.php');
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<title> SCHED | Perfil</title>
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
                                                            echo '<div class="user_img"><img class="imgper" src="'.$imagem.'"></div>';
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

                                        <h1>Perfil</h1>

                            <div class="perfil" align="center" class="center-block">
                                <?php
                                $imagem = "../clientes/imagens/".$_SESSION['user_session'].".jpg";
                                if(file_exists($imagem)){
                                    echo '<a><img id="imgperfil" class="imgper" src="'.$imagem.'" style="max-height:70px;"></a>';
                                }
                                else{
                                    echo '<i class="glyphicon glyphicon-user" style="font-size: 60px;color: #FDA30E;"></i></h1>';
                                }
                                ?>
                                <br><br>
                                <div align="center" class="center-block">
                                    <div id="fileuploads1">Foto</div>
                                    <div id="message"></div>
                                </div>

                            </div>

                            <div id="carregando" class="center-block" align="center"><img src="../images/carregando.gif"></div>
                            <div id="divresposta"></div>
                            <form id="formcad" action="#" method="post" class="">
                                <div class="sign-up">
                                    <h4>Nome</h4>
                                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" maxlength="100" required autofocus>
                                </div>
                                <div class="sign-up">
                                    <h4>Endereço</h4>
                                    <input type="text" class="form-control" name="endereco" id="endereco" placeholder="Endereço" maxlength="250" required>
                                </div>
                                <div class="sign-up">
                                    <h4>Telefone</h4>
                                    <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Telefone" maxlength="20" required>
                                </div>
                                <div class="sign-up">
                                    <h4>Email</h4>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Email" maxlength="100" required>
                                </div>
                                <div class="sign-up">
                                    <h4>Senha</h4>
                                    <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" maxlength="10" minlength="6" required>
                                </div>
                                <div class="sign-up">
                                    <input id="salvar" class="form-control" type="submit" value="Salvar">
                                </div>

                            </form>
                            <br><br>


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

							$('#carregando').hide();

                            var uid = <?php echo $_SESSION['user_session']; ?>;
                            var dados = 'classe=clientes&acao=consulta&valor=' + uid;

                            $('#carregando').show();
                            $.post("../acoes.php", dados, function (json) {
                                var resposta = jQuery.parseJSON(json);
                                if(!resposta .retorno[0].retorno){
                                    $('#resposta').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
                                }
                                else {
                                    var dados = resposta.dados[0].dados[0];
                                    $.each(dados,function(index, value){
                                        $('#' + index).val(value);
                                    });
                                    if($('#senha').length > 0) {
                                        $('#senha').val('');
                                    }
                                    $('#carregando').hide();
                                }
                            });

                            $('form').on('submit', function() {
                                $('#carregando').show();
                                var inputs = $(this).serialize();
                                $('#salvar').hide();

                                var dados = 'classe=clientes&acao=editar&valor=R&' + inputs+'&clienteid=<?php echo $_SESSION['user_session']; ?>';
                                $.post("../acoes.php", dados, function (json) {
                                    var resposta = jQuery.parseJSON(json);
                                    if (!resposta.retorno[0].retorno) {
                                        $('#divresposta').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> ' + resposta.mensagem[0].mensagem + '  </div>');
                                    }
                                    else{
                                        $('#divresposta').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> ' + resposta.mensagem[0].mensagem + '</div>');
                                    }
                                });
                                $('#salvar').show();
                                $('#carregando').hide();
                                return false;
                            });

							</script>


   <link href="up/uploadfile.css" rel="stylesheet">
   <script src="up/jquery.uploadfile.min.js"></script>

   <script>
       var ret= $("#fileuploads1").uploadFile(
           {
               url:"up/php/upload.php",
               uploadStr: "Foto",
               fileName:"myfile",
               allowedTypes:"jpg,png,gif,jpeg",
               multiple:false,
               maxFileSize: 2048,
               formData:{ key1: 'value1', key2: 'value2' },
               returnType:'json',
               dragDropStr: '',
               onSuccess:function(files,data,xhr)
               {
                   $("#message").html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-check-circle"></i> &nbsp;Comando executado com sucesso.</div>');
                   var src = $("#imgperfil").attr("src");
                   $('img.imgper').removeAttr("src").attr('src', src+'?'+Math.random());
               },
               onError: function(files,status,errMsg)
               {
                   $("#message").html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-check-circle"></i> &nbsp;Erro ao enviar imagem.'+JSON.stringify(files)+'</div>');
               },
               afterUploadAll:function(obj)
               {
                   $(".ajax-file-upload-green").click();
               },
               autoSubmit:true,
               showCancel:true,
               showAbort:true,
               showDone:true,
               statusBarWidth: 'auto',
               dragdropWidth: 'auto',
               showStatusAfterSuccess:true
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