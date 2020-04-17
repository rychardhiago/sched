<?php
    require_once("session.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Sched Administração | Empresas </title>
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
<link rel="stylesheet" type="text/css" href="css/bootstrap-select.css">
<!--static chart-->
<script src="js/Chart.min.js"></script>
<script src="js/chartinator.js" ></script>
<script type="text/javascript" language="javascript" src="js/dataTables.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="js/bootstrap-select.js"></script>
<script type="text/javascript">
    var classe = 'empresas';
    var divresposta = '#resposta';
    var campos = 'empresaid, empresas.nomefantasia as nome, grupos.nomefantasia as grupo, empresaid as pasta';
    var alias = '';
    var inner = 'grupos';
    var campoI = 'grupoid';
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
                          Empresas
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
                                        <input type="hidden" id="empresaid" name="empresaid" class="classeid" value="0">
                                        Grupo <select name="grupoid" id="grupoid" class=""></select>
                                        Razão social <input type="text" name="razaosocial" id="razaosocial" maxlength="55" placeholder="Razão social" required=""><br>
                                        Nome fantasia <input type="text" name="nomefantasia" id="nomefantasia" maxlength="55" placeholder="Nome fantasia" required=""><br>
                                        CGC <input type="text" name="cgc" id="cgc" maxlength="20" placeholder="CGC" required=""><br>
                                        Bloqueado? <select name="bloqueio" id="bloqueio" class="">
                                            <option value="S">Sim</option>
                                            <option value="N">Não</option>
                                        </select><br>
                                        Motivo Bloqueio<textarea name="motivobloqueio" id="motivobloqueio" placeholder="Motivo bloqueio"></textarea>
                                        Hrs cancelamento <input type="number"  name="hrscancelamento" id="hrscancelamento"  placeholder="Hrs cancelamento" required=""><br>
                                        Hrs abertura <input type="time" name="hrsabertura" id="hrsabertura"  placeholder="Hrs abertura" required=""><br>
                                        Hrs fechamento <input type="time" name="hrsfechamento" id="hrsfechamento"  placeholder="Hrs fechamento" required=""><br>
                                        Intervalo <input type="time" name="intervalo" id="intervalo"  placeholder="Intervalo" required><br>
                                        Dias da semana<br>
                                        <select id="diassemanas" name="diassemanas" class="selectpicker" title='Selecione o(s) dia(s)' multiple required>
                                            <option value="2">Segunda</option>
                                            <option value="3">Terça</option>
                                            <option value="4">Quarta</option>
                                            <option value="5">Quinta</option>
                                            <option value="6">Sexta</option>
                                            <option value="7">Sábado</option>
                                            <option value="1">Domingo</option>
                                        </select><br><br>
                                        Usa bloqueio automático? <select name="bloqueioautomatico" id="bloqueioautomatico" class="">
                                            <option value="S">Sim</option>
                                            <option value="N">Não</option>
                                        </select><br>
                                        Número de faltas <input type="number" name="numfaltas" id="numfaltas"  placeholder="Número de faltas" required=""><br>
                                        Latitude <input type="number" step='any' min='1' name="latitude" id="latitude"  placeholder="Latitude" required=""><br>
                                        Longitude <input type="number" step='any' min='1' name="longitude" id="longitude"  placeholder="Longitude" required=""><br>
                                        Matriz? <select name="matriz" id="matriz" class="">
                                            <option value="S">Sim</option>
                                            <option value="N">Não</option>
                                        </select><br>
                                        Endereço <textarea name="endereco" id="endereco" placeholder="Endereço"></textarea>
                                        CEP <input type="number" name="cep" id="cep"  placeholder="CEP" required=""><br>
                                        Cidade <select name="cidadeid" id="cidadeid" class=""></select><br>
                                        Sobre <textarea name="sobre" id="sobre" placeholder="Sobre" rows="5"></textarea><br>
                                        Tipo contrato? <select name="tipocontrato" id="tipocontrato" class="">
                                            <option value="C">Cliente</option>
                                            <option value="P">Parceiro</option>
                                        </select><br>
                                        Usa comissão? <select name="usacomissao" id="usacomissao" class="">
                                            <option value="S">Sim</option>
                                            <option value="N">Não</option>
                                        </select><br>
                                        Apenas agendamento interno? <select name="apenasint" id="apenasint" class="">
                                            <option value="S">Sim</option>
                                            <option value="N">Não</option>
                                        </select><br>
                                        <div align="center" class="center-block">
                                            <div id="fileuploads1">Documento</div>
                                            <div id="message"></div>
                                        </div>
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
                                    <th data-bSortable="true">Grupo</th>
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
    preencher('grupoid','grupos','grupoid','nomefantasia');
    preencher('cidadeid','cidades','cidadeid','nome');
    /**
     * Select multiplos
     */
    $('.selectpicker').selectpicker();
</script>

<link href="up/uploadfile.css" rel="stylesheet">
<script src="up/jquery.uploadfile.min.js"></script>

<script>
    var ret= $("#fileuploads1").uploadFile(
        {
            url:"up/php/upload.php",
            uploadStr: "Documento",
            fileName:"myfile",
            allowedTypes:"*",
            multiple:true,
            dynamicFormData: function(){
                            var data ={ empresaid:$("#empresaid").val()};
                            return data;
            },
            returnType:'json',
            dragDropStr: '',
            onSuccess:function(files,data,xhr)
            {
                $("#message").html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-check-circle"></i> &nbsp;Comando executado com sucesso.</div>');
                var src = $(".down a img").attr("src");
                $('img').removeAttr("src").attr('src', src+'?'+Math.random());
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
<!-- mother grid end here-->
</body>
</html>                     