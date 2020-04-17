<?php

require_once("session.php");

require_once("classes/class.usuarios.php");
$auth_user = new usuarios();


$user_id = $_SESSION['user_session'];

$stmt = $auth_user->runQuery("SELECT * FROM usuarios WHERE usuarioid=:user_id");
$stmt->execute(array(":user_id"=>$user_id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

$st = $auth_user->runQuery("SELECT count(empresaid) as conta FROM empresas WHERE excluido = 'N' and tipocontrato = 'C'");
$st->execute();
$contaEmpresas=$st->fetch(PDO::FETCH_ASSOC);

$st = $auth_user->runQuery("SELECT count(clienteid) as conta FROM clientes WHERE excluido = 'N' and confirmada = 'S'");
$st->execute();
$contacli=$st->fetch(PDO::FETCH_ASSOC);

$st = $auth_user->runQuery("SELECT count(contatositeid) as conta FROM contatosite WHERE excluido = 'N' and retorno = 'N' and comoconheceu is not null");
$st->execute();
$contato=$st->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Sched Administração | Home </title>
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
    <script type="text/javascript">
        jQuery(function ($) {
			$('#menu').load('menu.php', function () {
                $('#sidebaricon').click();
            });
        });
    </script>

<!--skycons-icons-->
<script src="js/skycons.js"></script>
<!--//skycons-icons-->
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
													<p><?php echo $userRow['nome']; ?></p>
													<span><?php echo $userRow['grupo']; ?></span>
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
	 <div class="market-updates">
			<div class="col-md-4 market-update-gd">
				<div class="market-update-block clr-block-1">
					<div class="col-md-8 market-update-left">
						<h3><?php echo $contaEmpresas['conta']; ?></h3>
						<h4>contratos</h4>
						<p>cadastrados no sistema</p>
					</div>
					<div class="col-md-4 market-update-right">
						<i class="fa fa-file-text-o"> </i class="fa fa-file-text-o">
					</div>
				  <div class="clearfix"> </div>
				</div>
			</div>
			<div class="col-md-4 market-update-gd">
				<div class="market-update-block clr-block-2">
				 <div class="col-md-8 market-update-left">
                     <h3><?php echo $contacli['conta']; ?></h3>
					<h4>Usuários</h4>
					<p>do App</p>
				  </div>
					<div class="col-md-4 market-update-right">
						<i class=""><img src="images/visit.png" class="img-responsive"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
			</div>
			<div class="col-md-4 market-update-gd">
				<div class="market-update-block clr-block-3" alt="Assembléia com data maior que hoje">
					<div class="col-md-8 market-update-left">
                        <h3><?php echo $contato['conta']; ?></h3>
						<h4>Cadastros <br> agendados</h4>

					</div>
					<div class="col-md-4 market-update-right">
						<i class=""><img src="images/reg.png" class="img-responsive"> </i>
					</div>
				  <div class="clearfix"> </div>
				</div>
			</div>
		   <div class="clearfix"> </div>
		</div>
<!--market updates end here-->
<!--mainpage chit-chating-->
<div class="chit-chat-layer1">
	<div class=" chit-chat-layer1-left">
               <div class="work-progres">
                            <div class="chit-chat-heading">
                                  Chamados recentes
                            </div>
                   <div id="divtable" class="table-responsive">
                       <table id="tabela_dados" class="table table-hover">
                           <thead>
                           <tr>
                               <th data-bSortable="true">#</th>
                               <th data-bSortable="true">Empresa - Profssional</th>
                               <th data-bSortable="true">Assunto</th>
                               <th data-bSortable="true">Tipo</th>
                               <th data-bSortable="true">Data de cadastro</th>
                           </tr>
                           </thead>
                           <tbody>

                           <?php
                           $stmt = $auth_user->runQuery("SELECT chamadoid, concat(empresas.nomefantasia, ' - ',profissionais.nome) as empresa, assunto, tipo, chamados.datacadastro FROM chamados, empresas, profissionais WHERE chamados.profissionaiid = profissionais.profissionaiid and profissionais.empresaid = empresas.empresaid and chamados.excluido = 'N' and situacao = 'A' order by chamados.datacadastro DESC");
                           $stmt->execute();
                           while($row = $stmt->fetch()) {
                               $date = new DateTime($row['datacadastro']);
                               if($row['tipo'] == 'E'){
                                   $tipo = "<span class='label label-danger'>Erro</span>";
                               }
                               else if($row['tipo'] == 'S'){
                                   $tipo = "<span class='label label-success'>Sugestão</span>";
                               }
                               else{
                                   $tipo = "<span class='label label-info'>Dúvida</span>";
                               }

                               echo '
                                    <tr>
                                      <td>'.$row['chamadoid'].'</td>
                                      <td>'.$row['empresa'].'</td>                               
                                      <td>'.$row['assunto'].'</td>
                                      <td>'.$tipo.'</td>
                                      <td>'.$date->format('d/m/Y H:i:s').'</td>
                                    </tr>
                                  ';
                           }
                           ?>

                           </tbody>
                       </table>
                   </div>
             </div>
      </div>

     <div class="clearfix"> </div>
</div>



</div>
<!--inner block end here-->
<!--copy rights start here-->
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
<!--COPY rights end here-->
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
<!--scrolling js-->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!--//scrolling js-->
<script src="js/bootstrap.js"> </script>

<!-- mother grid end here-->
</body>
</html>                     