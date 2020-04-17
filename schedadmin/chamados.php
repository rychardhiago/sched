<?php
    require_once("session.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Sched Administração | Chamados </title>
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
<script src="js/Chart.min.js"></script>
<script src="js/chartinator.js" ></script>
<script type="text/javascript" language="javascript" src="js/dataTables.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="js/moment.min.js"></script>

<script type="text/javascript">
    var classe = 'chamados';
    var divresposta = '#resposta';
    var campos = 'chamadoid, concat(profissionais.empresaid , " - " , profissionais.nome) as Empresa2Profissional, assunto, situacao, chamados.datacadastro';
    var alias = '';
    var inner = 'profissionais';
    var campoI = 'profissionaiid';

</script>
<script src="js/skycons.js"></script>

</head>
<body>	
<div class="page-container">	
   <div class="left-content">
	   <div class="mother-grid-inner">
            <!--header start here-->
				<div class="header-main">
					<div class="header-left">
                        <div class="logo-name">
                            <a href="index.php">   <h1 class="hidden-mobile"><img src="images/logo_site.png" class="float-left"> Sched Administração</h1>
                            </a>
                        </div>

							<div class="clearfix"> </div>
						 </div>
						 <div class="header-right">

							<div class="profile_details">		
								<ul>
									<li class="dropdown profile_details_drop">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											<div class="profile_img">	

												<div class="user-name">
													<p><?php echo $_SESSION['nome']; ?></p>
													<span><?php echo $_SESSION['grupo']; ?></span>
												</div>
												<i class="fa fa-angle-down lnr"></i>
												<i class="fa fa-angle-up lnr"></i>
												<div class="clearfix"></div>	
											</div>	
										</a>
										<ul class="dropdown-menu drp-mnu">
											<!--<li> <a href="#"><i class="fa fa-cog"></i> Settings</a> </li>
											<li> <a href="#"><i class="fa fa-user"></i> Profile</a> </li> -->
											<li> <a href="logout.php"><i class="fa fa-sign-out"></i> Sair</a> </li>
										</ul>
									</li>
								</ul>
							</div>
							<div class="clearfix"> </div>				
						</div>
				     <div class="clearfix"> </div>	
				</div>

<div class="inner-block">
<!--market updates updates-->

<div class="chit-chat-layer1">
	<div class=" chit-chat-layer1-left">
               <div class="work-progres">
                    <div class="chit-chat-heading">
                          Chamados
                        <a href="#" id="btn-add" data-toggle="modal" data-target="#myModal2" class="btn btn-success"><i class="fa fa-plus"></i> </a>

                        <!-- Cadastro -->

                    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="images\close.png"></button>
                                    <h2 class="modal-title" id="modal-title">Adicionar</h2>
                                </div>
                                <div class="modal-body signup-block">
                                    <form id="cadastro" method="post">
                                        <input type="hidden" id="chamadoid" name="chamadoid" value="0">
                                        Profissional <select name="profissionaiid" id="profissionaiid" class="">

                                        </select><br>
                                        Tipo: <select type="text" class="form-control1 control3 " name="tipo" id="tipo" required>
                                            <option value="D">Dúvida</option>
                                            <option value="E">Erro</option>
                                            <option value="S">Sugestão</option>
                                        </select>
                                        Assunto: <input type="text" class="form-control1 control3 " name="assunto" id="assunto" placeholder="Assunto" required>
                                        Mensagem: <textarea rows="6" class="form-control1 control2 " name="mensagem" id="mensagem" placeholder="Mensagem" required></textarea>

                                        <span class="soedicao">
                                         <textarea rows="3" class="form-control1 control2" name="addmensagem" id="addmensagem" placeholder="Adicionar mensagem"></textarea>
                                        </span>

                                        Situação: <select type="text" class="form-control1 control3 " name="situacao" id="situacao" required>
                                            <option value="A">Aberto</option>
                                            <option value="F">Fechado</option>
                                            <option value="P">Pausado</option>
                                        </select>

                                        <div class="modal-footer">
                                            <input type="submit" name="btn-adduser" class="btn btn-success">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                                <!-- FIM Cadastro -->
                    </div>
                    <br><br>
                    <div id="resposta">
                    </div>
                    <img id="carregando" class="center-block" src="images/carregando.gif">
                    <div id="divtable" class="table-responsive">
                        <table id="tabela_dados" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-bSortable="true">#</th>
                                    <th data-bSortable="true">Empresa - Profssional</th>
                                    <th data-bSortable="true">Assunto</th>
                                    <th data-bSortable="true">Tipo</th>
                                    <th data-bSortable="true">Situação</th>
                                    <th class="noprint">Ações</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
             </div>
      </div>
     <div class="clearfix"> </div>
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

</div>
</div>
<!--slider menu-->
    <div class="sidebar-menu">
		  	<div class="logo">
				<a id="sidebaricon" href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a>
			</div>
		    <div class="menu">
		      <ul id="menu" >


		      </ul>
		    </div>
	 </div>
	<div class="clearfix"> </div>
</div>
<!--slide bar menu end here-->
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
            });
</script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<script src="js/bootstrap.js"> </script>
<script src="js/funcoes.js"></script>
<script>
    preencher('profissionaiid','profissionais','profissionaiid','nome');
</script>
<!-- mother grid end here-->
</body>
</html>                     