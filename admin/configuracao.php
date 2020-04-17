<?php

require_once("session.php");

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Sched Administração | Configuração </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
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
<script src="js/amcharts.js"></script>	
<script src="js/serial.js"></script>	
<script src="js/light.js"></script>	
<script src="js/radar.js"></script>
<link href="css/fabochart.css" rel='stylesheet' type='text/css' />
<!--clock init-->
<script src="js/css3clock.js"></script>
<!--Easy Pie Chart-->
<!--skycons-icons-->
<script src="js/skycons.js"></script>
<script type="text/javascript" language="javascript" src="js/moment.min.js"></script>
    <script>
        var classe = 'empresas';
        var divresposta = '#resposta';
    </script>
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
											<a href="#" title="Mensagens" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-envelope-o"></i> <span id="nummensagem" class="badge"></span></a>
                                                <ul id="ulmsg" class="dropdown-menu two first">
                                                </ul>
										    </li>







                            <?php
                            if(($_SESSION['admingrupo'] == 'S') ||  ($_SESSION['adminempresa'] == 'S')){
							echo '<li class="dropdown note">
								<a href="#" title="Chamados" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-tasks"></i> <span id="numchamados" class="badge"></span></a>

									<ul id="ulchamados" class="dropdown-menu two">
										<li>
											<div class="notification_header">
												<h3>Chamados em aberto</h3>
											</div>
										</li>
										
										 
										 <li>
											<div class="notification_bottom">
												<a href="chamados.php">Ver todos chamados</a>
											</div> 
										</li>
									</ul>
							</li>';

                            echo '
						';
                            }
                            ?>
                                        <li class="dropdown note">
                                            <a href="ajuda.php" target="_blank" title="Ajuda">
                                                <span style="font-size: 1.2em; font-weight: bold; color: #FFFFFF">?</span>
                                            </a>
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
						<!--
						************CONTEDUO AQUII **********
								-->
                            <h1>Configuração</h1>

                            <div id="resposta">

                            </div>

                            <div id="carregando" class="center-block" align="center">
                                <img src="images/carregando.gif">
                            </div>

                            <div class="panel-body">
                                <form id="formcadastro" class="com-mail">
                                    <select name="empresaid" id="empresaid" class="form-control"></select><br>

                                    Hrs cancelamento <input type="number" class="form-control"  name="hrscancelamento" id="hrscancelamento"  placeholder="Hrs cancelamento" required=""><br>
                                    Hrs abertura <input type="time" class="form-control" name="hrsabertura" id="hrsabertura"  placeholder="Hrs abertura" required=""><br>
                                    Hrs fechamento <input type="time" class="form-control" name="hrsfechamento" id="hrsfechamento"  placeholder="Hrs fechamento" required=""><br>
                                    Dias da semana<br>
                                    <select id="diassemanas" class="form-control" name="diassemanas" data-placeholder='Selecione o(s) dia(s)' multiple required>
                                        <option value="2">Segunda</option>
                                        <option value="3">Terça</option>
                                        <option value="4">Quarta</option>
                                        <option value="5">Quinta</option>
                                        <option value="6">Sexta</option>
                                        <option value="7">Sábado</option>
                                        <option value="1">Domingo</option>
                                    </select><br><br>
                                    Usa bloqueio automático? <select class="form-control" name="bloqueioautomatico" id="bloqueioautomatico" class="">
                                        <option value="S">Sim</option>
                                        <option value="N">Não</option>
                                    </select><br>
                                    Número de faltas <input  class="form-control" type="number" name="numfaltas" id="numfaltas"  placeholder="Número de faltas" required=""><br>
                                    Latitude <input type="number" class="form-control" step='any' min='1' name="latitude" id="latitude"  placeholder="Latitude" required=""><br>
                                    Longitude <input type="number" class="form-control" step='any' min='1' name="longitude" id="longitude"  placeholder="Longitude" required=""><br>
                                    Matriz? <select name="matriz" id="matriz" class="form-control">
                                        <option value="S">Sim</option>
                                        <option value="N">Não</option>
                                    </select><br>
                                    Endereço <textarea name="endereco" id="endereco" placeholder="Endereço" class="form-control"></textarea><br>
                                    Cidade <select name="cidadeid" id="cidadeid" class="form-control"></select><br>
                                    CEP <input type="number" name="cep" id="cep"  placeholder="CEP" required="" class="form-control"><br>
                                    Sobre <textarea name="sobre" id="sobre" placeholder="Sobre a empresa" class="form-control" maxlength="5000" rows="10"></textarea><br>
                                    Intervalo agendamentos <input type="time" class="form-control" name="intervalo" id="intervalo"  placeholder="Intervalo" required><br>

                                    <h4>Parâmetros</h4>
                                    Usa comissão? <select class="form-control" name="usacomissao" id="usacomissao" class="">
                                        <option value="S">Sim</option>
                                        <option value="N">Não</option>
                                    </select><br>

                                    <input type="submit" value="enviar">
                                </form>
                            </div>

                        <!--//outer-wp-->
                        </div>
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
					<a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> <a href="home.php"> <span id="logo"> <h1>Sched</h1></span>
					<!--<img id="logo" src="" alt="Logo"/>--> 
				  </a> 
				</header>
			<div style="border-top:1px solid rgba(69, 74, 84, 0.7)"></div>
			<!--/down-->
							<div class="down">	
                                <?php
                                    $imagem = "empresas/".$_SESSION['empresaid']."/imagens/".$_SESSION['user_session'].".jpg";
                                    if(file_exists($imagem)){
                                        echo '<a href="perfil.php"><img src="'.$imagem.'"></a>';
                                    }
                                    else{
                                      echo '<a href="perfil.php"><h1><i class="glyphicon glyphicon-user"></i></h1></a>';
                                    }
                                ?>
									  <a href="perfil.php"><span class=" name-caret"><?php echo $_SESSION['nome']; ?></span></a>
                                      <?php
                                        if($_SESSION['admingrupo'] == 'S'){
                                            echo '<p>Administrador no grupo '.$_SESSION['grupo'].'</p>';
                                        }
                                        else if($_SESSION['adminempresa'] == 'S'){
                                            echo '<p>Administrador em '.$_SESSION['empresa'].'</p>';
                                        }
                                        else {
                                            echo '<p>Profissional em '.$_SESSION['empresa'].'</p>';
                                        }
                                      ?>
									<ul>
									<li><a class="tooltips" href="perfil.php"><span>Perfil</span><i class="lnr lnr-user"></i></a></li>
                                        <?php

                                        if(($_SESSION['admingrupo'] == 'S') || ($_SESSION['adminempresa'] == 'S')){
                                            echo '<li><a class="tooltips" href="configuracao.php"><span>Configuração</span><i class="lnr lnr-cog"></i></a></li>';
                                        }

                                        ?>
										<li><a class="tooltips" href="logout.php"><span>Sair</span><i class="lnr lnr-power-switch"></i></a></li>
										</ul>
									</div>
							   <!--//down-->
                           <div class="menu">
									<ul id="menu" >

								  </ul>
								</div>
							  </div>
							  <div class="clearfix"></div>		
							</div>

<!--js -->
<link rel="stylesheet" href="css/vroom.css">
<script type="text/javascript" src="js/vroom.js"></script>
<script type="text/javascript" src="js/TweenLite.min.js"></script>
<script type="text/javascript" src="js/CSSPlugin.min.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<script src="js/funcoes.js"></script>
<script src="js/bootstrap.min.js"></script>
   <script type="text/javascript" src="dist/js/select2.min.js"></script>
   <link rel="stylesheet" href="dist/css/select2.min.css">
   <script type="text/javascript">

       function atualizadados(uid) {

           var dados = 'classe=empresas&acao=consulta&valor=' + uid;

           $('#carregando').show();
           $.post("acoes.php", dados, function (json) {

               var resposta = jQuery.parseJSON(json);
               if(!resposta .retorno[0].retorno){
                   $('#resposta').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
               }
               else {
                   var dados = resposta.dados[0].dados[0];
                   $.each(dados,function(index, value){
                       $('#' + index).val(value);
                   });

                   $("#diassemanas").select2("destroy");
                   $("#diassemanas").val('');
                   var values = dados['diassemana'];
                   $.each(values.split(","), function(i,e){
                       $("#diassemanas option[value='" + e + "']").prop("selected", true);
                   });
                   $('#diassemanas').select2();

                   var empresa = 'empresa='+dados['nomefantasia']+'&cidadeid='+dados['cidadeid']+'&usacomissao='+dados['usacomissao']+'&empresaid=' + uid;
                   $.post("atualiza.php", empresa);

                   $('#carregando').hide();
               }
           });
       }

       preencher('empresaid', 'empresas','empresaid','nomefantasia',2,1,<?php echo $_SESSION['empresaid']; ?>);
       preencher('cidadeid','cidades','cidadeid','nome',0,0,<?php echo $_SESSION['cidadeid']; ?>);

       $('#diassemanas').select2();

       $('#empresaid').change(function () {
           atualizadados($(this).val());
       });

       atualizadados(<?php echo $_SESSION['empresaid']; ?>);

   </script>
</body>
</html>