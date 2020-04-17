<?php
    require_once("session.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Sched Administração | Profissionais </title>
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

<script type="text/javascript">
    var classe = 'profissionais';
    var divresposta = '#resposta';
    var campos = 'profissionaiid, nome, empresas.nomefantasia as empresa, profissionais.cgc as cgc';
    var alias = '';
    var inner = 'empresas';
    var campoI = 'empresaid';

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
                        Profissionais
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
                                        <input type="hidden" id="profissionaiid" name="profissionaiid" class="classeid" value="0">
                                        Empresa <select name="empresaid" id="empresaid" class="">

                                        </select>
                                        Nome <input type="text" name="nome" id="nome" maxlength="55" placeholder="Nome" required=""><br>
                                        CGC <input type="text" name="cgc" id="cgc" maxlength="11" placeholder="CGC" required=""><br>
                                        Email <input type="email" name="email" id="email" maxlength="55" placeholder="Email" required=""><br>
                                        Senha <input type="password" name="senha" id="senha" maxlength="8" placeholder="Senha" required=""><br>
                                        Número de sessões <input type="number" name="numsessoes" id="numsessoes" maxlength="55" placeholder="Número de sessões" required=""><br>
                                        Descrição <textarea name="descricao" id="descricao" maxlength="5000" placeholder="Descrição" required=""></textarea><br>
                                        Bloqueado? <select name="bloqueado" id="bloqueado" class="">
                                            <option value="S">Sim</option>
                                            <option value="N">Não</option>
                                        </select>
                                        Admin empresa? <select name="adminempresa" id="adminempresa" class="">
                                            <option value="S">Sim</option>
                                            <option value="N">Não</option>
                                        </select>
                                        Admin Grupo? <select name="admingrupo" id="admingrupo" class="">
                                            <option value="S">Sim</option>
                                            <option value="N">Não</option>
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
                                    <th data-bSortable="true">Nome</th>
                                    <th data-bSortable="true">Empresa</th>
                                    <th data-bSortable="true">CGC</th>
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
    preencher('empresaid','empresas','empresaid','nomefantasia');
</script>
<!-- mother grid end here-->
</body>
</html>                     