<?php

require_once("session.php");
require_once("classes/class.agendamentos.php");

$agendamento = new agendamentos();

//Variaveis

$meses[0] = "Jan";
$meses[1] = "Fev";
$meses[2] = "Mar";
$meses[3] = "Abr";
$meses[4] = "Mai";
$meses[5] = "Jun";
$meses[6] = "Jul";
$meses[7] = "Ago";
$meses[8] = "Set";
$meses[9] = "Out";
$meses[10] = "Nov";
$meses[11] = "Dec";

/**
 * Agendamentos para hoje
 */
$datafim = date('Y-m-d');
$datainicio = date('Y-m-d') ;
$sql   = "SELECT count(agendamentos.agendamentoid) contador, sum(precototal) precototal ";
$sql  .= "FROM agendamentos, profissionais, empresas ";
$sql  .= "WHERE agendamentos.profissionaiid = profissionais.profissionaiid and agendamentos.empresaid = empresas.empresaid ";

$sql  .= "and ((datainicio BETWEEN '".$datainicio." 00:00:00' and '".$datafim." 23:59:59' or datafim BETWEEN '".$datainicio." 00:00:00' and '".$datafim." 23:59:59') or ";
$sql  .= "(datainicio <= '".$datainicio." 00:00:00' and datafim >='".$datafim." 23:59:59')) ";

if($_SESSION['admingrupo'] == 'S'){
    $sql .= " AND empresas.empresaid in (select empresaid from empresas where grupoid = " . $_SESSION['grupoid']. ")";
}
else if($_SESSION['adminempresa'] == 'S'){
    $sql .= " AND empresas.empresaid=" . $_SESSION['empresaid'];
}
else {
    $sql .= " AND empresas.empresaid=" . $_SESSION['empresaid'] . " AND profissionais.profissionaiid = ".$_SESSION['user_session'];
}

$sql  .= " and agendamentos.cancelado = 'N'";
$stmt = $agendamento->runQuery($sql);
$stmt->execute();
$hoje = $stmt->fetch();

/**
 * fiim hoje
 */

/**
 * Agendamentos para mes
 */
$datafim = date('Y-m-31');
$datainicio = date('Y-m-01');
$sql   = "SELECT count(agendamentos.agendamentoid) contador, sum(precototal) precototal ";
$sql  .= "FROM agendamentos, profissionais, empresas ";
$sql  .= "WHERE agendamentos.profissionaiid = profissionais.profissionaiid and agendamentos.empresaid = empresas.empresaid ";

$sql  .= "and ((datainicio BETWEEN '".$datainicio." 00:00:00' and '".$datafim." 23:59:59' or datafim BETWEEN '".$datainicio." 00:00:00' and '".$datafim." 23:59:59') or ";
$sql  .= "(datainicio <= '".$datainicio." 00:00:00' and datafim >='".$datafim." 23:59:59')) ";

if($_SESSION['admingrupo'] == 'S'){
    $sql .= " AND empresas.empresaid in (select empresaid from empresas where grupoid = " . $_SESSION['grupoid']. ")";
}
else if($_SESSION['adminempresa'] == 'S'){
    $sql .= " AND empresas.empresaid=" . $_SESSION['empresaid'];
}
else {
    $sql .= " AND empresas.empresaid=" . $_SESSION['empresaid'] . " AND profissionais.profissionaiid = ".$_SESSION['user_session'];
}

$sql  .= " and agendamentos.cancelado = 'N'";
$stmt = $agendamento->runQuery($sql);
$stmt->execute();
$mes = $stmt->fetch();

/**
 * fiim mes
 */


/**
 * Agendamentos X Cancelamentos
 */

$datainicio = date("Y-m-01", strtotime("-6 months"));

$sql   = "SELECT count(agendamentoid) contador, month(datainicio) mes    ";
$sql  .= "FROM agendamentos, profissionais, empresas ";
$sql  .= "WHERE agendamentos.profissionaiid = profissionais.profissionaiid and agendamentos.empresaid = empresas.empresaid ";

$sql  .= "and datainicio >= '".$datainicio." 00:00:00'";

if($_SESSION['admingrupo'] == 'S'){
    $sql .= " AND empresas.empresaid in (select empresaid from empresas where grupoid = " . $_SESSION['grupoid']. ")";
}
else if($_SESSION['adminempresa'] == 'S'){
    $sql .= " AND empresas.empresaid=" . $_SESSION['empresaid'];
}
else {
    $sql .= " AND empresas.empresaid=" . $_SESSION['empresaid'] . " AND profissionais.profissionaiid = ".$_SESSION['user_session'];
}

$sql  .= " and agendamentos.cancelado = 'N' GROUP BY MONTH(datainicio)";

$stmt = $agendamento->runQuery($sql);
$stmt->execute();

$meses6[0] = 0;
$meses6[1] = 0;
$meses6[2] = 0;
$meses6[3] = 0;
$meses6[4] = 0;
$meses6[5] = 0;
$meses6[6] = 0;
$meses6[7] = 0;
$meses6[8] = 0;
$meses6[9] = 0;
$meses6[10] = 0;
$meses6[11] = 0;

while($mes6 = $stmt->fetch()){
    $x = $mes6['mes'] - 1;
    $meses6[$x] = $mes6['contador'];
}

// *********************** cancelados *************************

$datainicio = date("Y-m-01", strtotime("-6 months"));

$sql   = "SELECT count(agendamentoid) contador, month(datainicio) mes    ";
$sql  .= "FROM agendamentos, profissionais, empresas ";
$sql  .= "WHERE agendamentos.profissionaiid = profissionais.profissionaiid and agendamentos.empresaid = empresas.empresaid ";

$sql  .= "and datainicio >= '".$datainicio." 00:00:00'";

if($_SESSION['admingrupo'] == 'S'){
    $sql .= " AND empresas.empresaid in (select empresaid from empresas where grupoid = " . $_SESSION['grupoid']. ")";
}
else if($_SESSION['adminempresa'] == 'S'){
    $sql .= " AND empresas.empresaid=" . $_SESSION['empresaid'];
}
else {
    $sql .= " AND empresas.empresaid=" . $_SESSION['empresaid'] . " AND profissionais.profissionaiid = ".$_SESSION['user_session'];
}

$sql  .= " and agendamentos.cancelado = 'S' GROUP BY MONTH(datainicio)";

$stmt = $agendamento->runQuery($sql);
$stmt->execute();

$meses6canc[0] = 0;
$meses6canc[1] = 0;
$meses6canc[2] = 0;
$meses6canc[3] = 0;
$meses6canc[4] = 0;
$meses6canc[5] = 0;
$meses6canc[6] = 0;
$meses6canc[7] = 0;
$meses6canc[8] = 0;
$meses6canc[9] = 0;
$meses6canc[10] = 0;
$meses6canc[11] = 0;

while($mes6canc = $stmt->fetch()){
    $x = $mes6canc['mes'] - 1;
    $meses6canc[$x] = $mes6canc['contador'];
}

/**
 * Agendamentos X Cancelamentos
 */


/**
 * Evolução
 */

$datainicio = date("Y-01-01");
$datafim = date("Y-12-31");

$sql   = "SELECT count(agendamentoid) contador, month(datainicio) mes, agendamentos.profissionaiid, profissionais.nome   ";
$sql  .= "FROM agendamentos, profissionais, empresas ";
$sql  .= "WHERE agendamentos.profissionaiid = profissionais.profissionaiid and agendamentos.empresaid = empresas.empresaid ";

$sql  .= "and datainicio >= '".$datainicio." 00:00:00' and datainicio <= '".$datafim." 00:00:00'";

if($_SESSION['admingrupo'] == 'S'){
    $sql .= " AND empresas.empresaid in (select empresaid from empresas where grupoid = " . $_SESSION['grupoid']. ")";
}
else if($_SESSION['adminempresa'] == 'S'){
    $sql .= " AND empresas.empresaid=" . $_SESSION['empresaid'];
}
else {
    $sql .= " AND empresas.empresaid=" . $_SESSION['empresaid'] . " AND profissionais.profissionaiid = ".$_SESSION['user_session'];
}

$sql  .= " and agendamentos.cancelado = 'N' GROUP BY MONTH(datainicio), profissionais.nome, agendamentos.profissionaiid order by profissionais.nome";

$stmt = $agendamento->runQuery($sql);
$stmt->execute();

$evolucao[0] = '"year": '."'Jan', ";
$evolucao[1] = '"year": '."'Fev', ";
$evolucao[2] = '"year": '."'Mar', ";
$evolucao[3] = '"year": '."'Abr', ";
$evolucao[4] = '"year": '."'Mai', ";
$evolucao[5] = '"year": '."'Jun', ";
$evolucao[6] = '"year": '."'Jul', ";
$evolucao[7] = '"year": '."'Ago', ";
$evolucao[8] = '"year": '."'Set', ";
$evolucao[9] = '"year": '."'Out', ";
$evolucao[10] = '"year": '."'Nov', ";
$evolucao[11] = '"year": '."'Dez', ";

$nomes = array();
$max = 0;
while($evo = $stmt->fetch()){
    $x = $evo['mes'] - 1;
    $evolucao[$x] .= '"'.$evo['nome'].'": '.$evo['contador'].',';
    if(!in_array($evo['nome'],$nomes)){
        $nomes[] = $evo['nome'];
    }
    $max = $max + $evo['contador'];
}

for($i=0;$i<12;$i++){
    for($j=0;$j<count($nomes);$j++){
        if(!strpos($evolucao[$i], $nomes[$j])) {
            $evolucao[$i] .= '"' . $nomes[$j] . '": 0,';
        }
    }
    $evolucao[$i] = substr($evolucao[$i],0,(strlen($evolucao[$i]) - 1));
}

//print_r($evolucao);

/**
 * Fiiim evolução
 */

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Sched Administração | Home </title>
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
								<!--custom-widgets-->
												<div class="custom-widgets">
												   <div class="row-one">
														<div class="col-md-3 widget">
															<div class="stats-left ">
																<h5>Agendamentos</h5>
																<h4>Hoje</h4>
															</div>
															<div class="stats-right">
																<label><?php echo $hoje['contador']; ?></label>
															</div>
															<div class="clearfix"> </div>	
														</div>
														<div class="col-md-3 widget states-mdl">
															<div class="stats-left">
																<h5>Faturamento</h5>
																<h4>Hoje</h4>
															</div>
															<div class="stats-right">
																<label class="fat">R$ <?php echo number_format($hoje['precototal'], 2, ',', '.'); ?></label><br>
															</div>
															<div class="clearfix"> </div>	
														</div>
														<div class="col-md-3 widget states-thrd">
															<div class="stats-left">
																<h5>Agendamentos</h5>
																<h4>Mês</h4>
															</div>
															<div class="stats-right">
																<label><?php echo $mes['contador']; ?></label>
															</div>
															<div class="clearfix"> </div>	
														</div>
														<div class="col-md-3 widget states-last">
															<div class="stats-left">
																<h5>Faturamento</h5>
																<h4>Mês</h4>
															</div>
															<div class="stats-right">
																<label class="fat">R$ <?php echo number_format($mes['precototal'], 2, ',', '.'); ?></label>
															</div>
															<div class="clearfix"> </div>	
														</div>
														<div class="clearfix"> </div>	
													</div>
												</div>
												<!--//custom-widgets-->
												<!--/candile-->
													<div class="candile">

                                                        <div class="">
                                                            <br>
                                                            <h4 class="sub-tittle"><a id="cadastrocli" href="#" data-toggle="modal" data-target="#cadastromodal"><i class="glyphicon glyphicon-plus-sign"></i> Clientes</a> </h4>
                                                            <br>

                                                            <div class="modal fade" id="cadastromodal" tabindex="-1" role="dialog" >
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content modal-info">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="modal-body modal-spa">
                                                                            <div class="login-grids">
                                                                                <div class="login-bottom">
                                                                                    <h3 id="cadcli">Cadastro de clientes</h3>
                                                                                    <div id="carregandocli" class="center-block carregando" align="center"><img src="../images/carregando.gif"></div>
                                                                                    <div id="divresposta"></div>
                                                                                    <form id="formcad" action="#" method="post">
                                                                                        <div class="sign-up">
                                                                                            <h4>Nome</h4>
                                                                                            <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome" maxlength="100" required autofocus>
                                                                                        </div>
                                                                                        <div class="sign-up">
                                                                                            <h4>Data de nascimento</h4>
                                                                                            <input type="date" name="dtnascimento" class="form-control"  id="dtnascimento" placeholder="Data de nascimento" required>
                                                                                        </div>
                                                                                        <div class="sign-up">
                                                                                            <h4>Endereço</h4>
                                                                                            <input type="text" name="endereco" class="form-control"  id="endereco" placeholder="Endereço Ex.: Rua Silva N02 Q01 L10 Centro" maxlength="250" required>
                                                                                        </div>
                                                                                        <div class="sign-up">
                                                                                            <h4>Telefone</h4>
                                                                                            <input type="text" name="telefone" class="form-control"  id="telefone" placeholder="Telefone Ex.: (XX) XXXXX-XXXX" maxlength="20" required>
                                                                                        </div>
                                                                                        <div class="sign-up">
                                                                                            <h4>Email</h4>
                                                                                            <input type="text" name="emailr" class="form-control"  id="emailr" placeholder="Email" maxlength="100" required>
                                                                                        </div>
                                                                                        <div class="sign-up">
                                                                                            <h4>Senha</h4>
                                                                                            <input type="password" name="senha" class="form-control"  id="senha" placeholder="Senha" maxlength="10" minlength="6" required>
                                                                                        </div>
                                                                                        <div class="sign-up">
                                                                                            <h4>Repita a senha</h4>
                                                                                            <input type="password" name="senhar" class="form-control"  id="senhar" placeholder="Senha" maxlength="10" minlength="6" required>
                                                                                        </div>
                                                                                        <br>
                                                                                        <div class="sign-up">
                                                                                            <input id="cadastrar" type="submit" value="Cadastrar">
                                                                                        </div><br><br>

                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- // cadastro login -->

                                                            <script>
                                                                /*
                                                                 ************** CADASTRE-SE *********************
                                                                 */
                                                                $('#carregandocli').hide();
                                                                $('#formcad').on('submit', function() {
                                                                    $('#carregando').show();
                                                                    var inputs = $(this).serialize();
                                                                    $('#cadastrar').hide();

                                                                    var dados = 'classe=clientes&acao=register&valor=R&' + inputs;
                                                                    $.post("../acoes.php", dados, function (json) {
                                                                        var resposta = jQuery.parseJSON(json);
                                                                        if (!resposta.retorno[0].retorno) {
                                                                            $('#divresposta').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i>' + resposta.mensagem[0].mensagem + '</div>');
                                                                        }
                                                                        else{
                                                                            $('#divresposta').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-check-circle"></i>Cadastro efetuado com sucesso.<br>Acesse seu email e confirme sua conta.<br> Confira sua caixa de entrada e spam(Lixeira). </div>');
                                                                            $('#cadastromodal').scrollTop(0);
                                                                        }
                                                                    });

                                                                    $('#cadastrar').show();
                                                                    $('#formcad')[0].reset();
                                                                    $('#carregando').hide();
                                                                    return false;
                                                                });

                                                                var password = document.getElementById("senha");
                                                                var confirm_password = document.getElementById("senhar");

                                                                function validatePassword(){
                                                                    if(password.value == confirm_password.value) {
                                                                        confirm_password.setCustomValidity('');
                                                                    } else {
                                                                        confirm_password.setCustomValidity("Senhas não são iguais");
                                                                    }
                                                                }

                                                                password.onchange = validatePassword;
                                                                confirm_password.onkeyup = validatePassword;
                                                            </script>

                                                            <h3 class="sub-tittle">Evolução agendamentos por profissional</h3>
                                                            <div id="chartdiv2"></div>
                                                            <script>
                                                                var chart = AmCharts.makeChart("chartdiv2", {
                                                                    "type": "serial",
                                                                    "theme": "patterns",
                                                                    "legend": {
                                                                        "useGraphSettings": true
                                                                    },
                                                                    "dataProvider": [

                                                                        <?php
                                                                            /*
                                                                             * {
                                                                        "year": 1930,
                                                                        "italy": 1,
                                                                        "germany": 5,
                                                                        "uk": 3
                                                                    }, {
                                                                        "year": 1934,
                                                                        "italy": 1,
                                                                        "germany": 2,
                                                                        "uk": 6
                                                                    }, {
                                                                        "year": 1938,
                                                                        "italy": 2,
                                                                        "germany": 3,
                                                                        "uk": 1
                                                                    }, {
                                                                        "year": 1950,
                                                                        "italy": 3,
                                                                        "germany": 4,
                                                                        "uk": 1
                                                                    }, {
                                                                        "year": 1954,
                                                                        "italy": 5,
                                                                        "germany": 1,
                                                                        "uk": 2
                                                                    }, {
                                                                        "year": 1958,
                                                                        "italy": 3,
                                                                        "germany": 2,
                                                                        "uk": 1
                                                                    }, {
                                                                        "year": 1962,
                                                                        "italy": 1,
                                                                        "germany": 2,
                                                                        "uk": 3
                                                                    }, {
                                                                        "year": 1966,
                                                                        "italy": 2,
                                                                        "germany": 1,
                                                                        "uk": 5
                                                                    }, {
                                                                        "year": 1970,
                                                                        "italy": 3,
                                                                        "germany": 5,
                                                                        "uk": 2
                                                                    }, {
                                                                        "year": 1974,
                                                                        "italy": 4,
                                                                        "germany": 3,
                                                                        "uk": 6
                                                                    }, {
                                                                        "year": 1978,
                                                                        "italy": 1,
                                                                        "germany": 2,
                                                                        "uk": 4
                                                                    }
                                                                             */


                                                                        $dados = '';
                                                                        for($i=0;$i <= 11; $i++){
                                                                            $dados .= '{'.$evolucao[$i].'}';
                                                                            if($i<11){
                                                                                $dados .= ' , ';
                                                                            }
                                                                        }
                                                                        echo $dados;


                                                                        ?>

                                                                    ],
                                                                    "valueAxes": [{
                                                                        "integersOnly": true,
                                                                        "maximum": <?php echo $max; ?>,
                                                                        "minimum": 1,
                                                                        "reversed": false,
                                                                        "axisAlpha": 0,
                                                                        "dashLength": 5,
                                                                        "gridCount": 10,
                                                                        "position": "left",
                                                                        "title": "Place taken"
                                                                    }],
                                                                    "startDuration": 0.5,
                                                                    "graphs": [
                                                                        <?php
                                                                        $dados = '';
                                                                        for($j=0;$j<count($nomes);$j++){
                                                                            $dados .= '{
                                                                                        "balloonText": "[[title]]: [[value]]",
                                                                                        "bullet": "round",
                                                                                        "hidden": false,
                                                                                        "title": "'.$nomes[$j].'",
                                                                                        "valueField": "'.$nomes[$j].'",
                                                                                        "fillAlphas": 0
                                                                                        },';
                                                                        }
                                                                        $dados = substr($dados,0,(strlen($dados) - 1));
                                                                        echo $dados;
                                                                        ?>
                                                                    ],
                                                                    "chartCursor": {
                                                                        "cursorAlpha": 0,
                                                                        "zoomable": false
                                                                    },
                                                                    "categoryField": "year",
                                                                    "categoryAxis": {
                                                                        "gridPosition": "start",
                                                                        "axisAlpha": 0,
                                                                        "fillAlpha": 0.05,
                                                                        "fillColor": "#000000",
                                                                        "gridAlpha": 0,
                                                                        "position": "top"
                                                                    },
                                                                    "export": {
                                                                        "enabled": true,
                                                                        "position": "bottom-right"
                                                                    }
                                                                });
                                                            </script>

                                                        </div>
															
                                                    </div>
													<!--/candile-->
													
												<!--/charts-->
												<div class="charts">
												  <div class="chrt-inner">
												    <div class="chrt-bars">
														<div class="col-md-6 chrt-two">
														 <h3 class="sub-tittle">Agendamento últimos 6 meses</h3>
															<div id="chart2"></div>
															<script src="js/fabochart.js"></script>
															<script>
															$(document).ready(function () {
																data = {

                                                                    <?php
                                                                        /*
                                                                         * 'Jan' : 300,
																  'Fev' : 200,
																  'Mar' : 100,
																  'Abr' : 500,
																  'Mai' : 400,
																  'Jun' : 200
                                                                         */
                                                                    $dados = "";
                                                                    for($i=5;$i >= 0; $i--){
                                                                        $m = date("m", strtotime("-".$i." months"));
                                                                        $m--;
                                                                        $dados .= "'".$meses[$m]."'";
                                                                        $dados .= ': '.$meses6[$m];
                                                                        if($i>0){
                                                                            $dados .= ' , ';
                                                                        }
                                                                    }
                                                                    echo $dados;


                                                                    ?>
																};

																$("#chart1").faBoChart({
																  time: 500,
																  animate: true,
																  instantAnimate: true,
																  straight: false,
																  data: data,
																  labelTextColor : "#002561",
																});
																$("#chart2").faBoChart({
																  time: 2500,
																  animate: true,
																  data: data,
																  straight: true,
																  labelTextColor : "#002561",
																});
															});
															</script>
														</div>
															<div class="col-md-6 chrt-three">
															<h3 class="sub-tittle">Agendamentos x Cancelamentos </h3>
																<div id="chartdiv"></div>	
																			<script>
																			   var chart = AmCharts.makeChart( "chartdiv", {
																					  "type": "serial",
																					  "theme": "light",
																					  "dataProvider":
                                                                                   <?php
                                                                                       /*[ {
																						"year": 'Jan',
																						"value": 11.5,
																						"error": 5
																					  }, {
																						"year": 'Fev',
																						"value": 26.2,
																						"error": 5
																					  }, {
																						"year": 'Mar',
																						"value": 30.1,
																						"error": 5
																					  }, {
																						"year": 'Abr',
																						"value": 29.5,
																						"error": 7
																					  }, {
																						"year": 'Mai',
																						"value": 24.6,
																						"error": 10
																					  } ],*/

                                                                                       $dados = '[';
                                                                                       for($i=5;$i >= 0; $i--){
                                                                                           $m = date("m", strtotime("-".$i." months"));
                                                                                           $m--;
                                                                                           $dados .= ' { ';
                                                                                           $dados .= '"year": '."'".$meses[$m]."'";
                                                                                           $dados .= ',"value": '.$meses6[$m];
                                                                                           $dados .= ',"error": '.$meses6canc[$m];
                                                                                           if($i>0){
                                                                                               $dados .= ' }, ';
                                                                                           }else{
                                                                                               $dados .= ' } ';
                                                                                           }
                                                                                       }
                                                                                       $dados .= '],';
                                                                                       echo $dados;


                                                                                       ?>
																					  "balloon": {
																						"textAlign": "left"
																					  },
																					  "valueAxes": [ {
																						"id": "v1",
																						"axisAlpha": 0
																					  } ],
																					  "startDuration": 1,
																					  "graphs": [ {
																						"balloonText": "Agendamentos:<b>[[value]]</b><br>Cancelamento:<b>[[error]]</b>",
																						"bullet": "yError",
																						"bulletSize": 10,
																						"errorField": "error",
																						"lineThickness": 2,
																						"valueField": "value",
																						"bulletAxis": "v1",
																						"fillAlphas": 0
																					  }, {
																						"bullet": "round",
																						"bulletBorderAlpha": 1,
																						"bulletBorderColor": "#FFFFFF",
																						"lineAlpha": 0,
																						"lineThickness": 2,
																						"showBalloon": false,
																						"valueField": "value"

																					  } ],
																					  "chartCursor": {
																						"cursorAlpha": 0,
																						"cursorPosition": "mouse",
																						"graphBulletSize": 1,
																						"zoomable": false
																					  },
																					  "categoryField": "year",
																					  "categoryAxis": {
																						"gridPosition": "start",
																						"axisAlpha": 0
																					  },
																					  "export": {
																						"enabled": true
																					  }
																					} );
																			</script>
															
																	
																</div>
																<div class="clearfix"> </div>
															</div>										

									
									</div>
									<!--/charts-inner-->
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

<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
</body>
</html>