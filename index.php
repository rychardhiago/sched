<?php
    require_once("session.php");
    if($auth_user->is_loggedin()) {
        $auth_user->redirect('minhaconta/index.php');
    }
    $numest = $auth_user->contar('empresas');
    $numcli = $auth_user->contar('clientes');
    $numage = $auth_user->contar('agendamentos');
    $numprof = $auth_user->contar('profissionais');

?>
<!DOCTYPE html>
<html>
<head>
<title>.:: SCHED ::.</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="sched, schedapp, agendamento, horario, online, responsivo" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="css/jquery-ui.css" />
<link href="css/popuo-box.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- js -->
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="js/numscroller-1.0.js"></script>

<!-- //js -->


<!-- fonts -->
<link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Viga' rel='stylesheet' type='text/css'>

	<!-- start-smoth-scrolling -->
		<script type="text/javascript" src="js/move-top.js"></script>
		<script type="text/javascript" src="js/easing.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});
		</script>
	<!-- start-smoth-scrolling -->

<!--start-date-piker-->
	<script src="js/jquery-ui.js"></script>
		<script>
			$(function() {
				$( "#datepicker,#datepicker1" ).datepicker();
			});
		</script>
<!--/End-date-piker-->
	<script src="js/responsiveslides.min.js"></script>
			<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
</head>
<body>
<!-- header -->
<div class="header wow zoomIn">
	<div class="container" id="topo">
		<div class="header_left" data-wow-duration="2s" data-wow-delay="0.5s">
			<ul>
				<li><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>62 984258554</li>
				<li><a href="mailto:info@example.com"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>sched@schedapp.com.br</a></li>
			</ul>
		</div>
		<div class="header_right">
			<div id="dadoslogin" class="login">
                <?php
                if((isset($_SESSION['nome'])) &&($_SESSION['nome'] != "")){
                    echo '<ul><li><a href="minhaconta.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Olá, ' . $_SESSION['nome'] . '</a></li></ul>';
                }
                else{
                    echo '<ul>
                        <li><a href="#" data-toggle="modal" data-target="#myModal4"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Login</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#myModal5"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Criar conta</a></li>
                    </ul>';
                }
                ?>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- //header -->
<div class="header-bottom ">
		<div class="container">
			<nav class="navbar navbar-default">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
					<div class="logo grid">
						<div class="grid__item color-3">
							<h1><a class="link link--nukun" href="index.php"><i></i>SCH<span>E</span>D</a></h1>
						</div>
					</div>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
					<nav class="menu menu--horatio">
						<ul class="nav navbar-nav menu__list">
							<li class="menu__item menu__item--current"><a href="#topo" class="menu__link scroll">Home</a></li>
							<li class="menu__item"><a href="#sobre" class="menu__link scroll">Sobre</a></li>
							<li class="menu__item"><a href="#baixeapp" class="menu__link scroll">Baixe agora</a></li>
							<li class="menu__item btn btn-warning"><a href="#book" class="menu__link scroll" style="color: #FFFFFF;">Para empresas</a></li>
							<li class="menu__item"><a href="#contato" class="menu__link scroll">Contato</a></li>
						</ul>
					</nav>
				</div>
			</nav>
		</div>
	</div>

<!-- banner -->
<div class="banner">

				<script>
						// You can also use "$(window).load(function() {"
						$(function () {
						 // Slideshow 4
						$("#slider3").responsiveSlides({
							auto: true,
							pager: true,
							nav: false,
							speed: 500,
							namespace: "callbacks",
							before: function () {
						$('.events').append("<li>before event fired.</li>");
						},
						after: function () {
							$('.events').append("<li>after event fired.</li>");
							}
							});
						});
				</script>
		<div  id="top" class="callbacks_container">
			<ul class="rslides" id="slider3">
				<li>
					<div class="banner1">
						<div class="container">
							<div class="banner-info">
								<h3>Sched<span> Agendamento online</span> na palma da sua mão</h3>
								<p>Reserve um horário nos melhores estabelecimentos da sua região.<br>
								Com o sched fica mais fácil procurar aquele serviço que você precisa.<br>
								Veja a agenda completa do seu profissional de confiança<br>
								e agende o seu horário de acordo com sua preferência.</p>
								<a href="#baixeapp" class="hvr-outline-out button2 scroll">Escolha seu app</a>
							</div>
						</div>
					</div>
				</li> 
				<li>
					<div class="banner2">
						<div class="container">
							<div class="banner-info2">
								<h3>Responsivo <span>Acesse de qualquer dispositivo</span></h3>
								<p>Sched é uma aplicação totalmente responsiva.<br>
								Acessando via smartphone,tablet ou PC, pelo aplicativo ou navegador<br>
								Você terá as mesmas funcionalidades.</p>
								<a id="cadastre" href="#" class="hvr-outline-out button3 scroll">Cadastre-se agora</a>
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="banner1">
						<div class="container">
							<div class="banner-info">
								<h3>Controle, <span> Organização, </span> e Praticidade</h3>
								<p>Sched proporciona uma melhor usablidade para suas atividades.<br>
								Tanto para o cliente que prentende reservar um horário.<br>
								Quanto para a empresa com a gestão completa de sua agenda e serviços.</p>
								<a href="#book" class="hvr-outline-out button2 scroll">Faça seu pré cadastro</a>
							</div>
						</div>
					</div>
				</li> 
				<li>
					<div class="banner2">
						<div class="container">
							<div class="banner-info2">
								<h3>24x7x12 <span>Totalmente online</span></h3>
								<p>Acesse de onde estiver, e quando quiser.<br>
								Veja a agenda e reseve um horário do seu estabelecimento favorito<br>
								a qualquer hora do dia.</p>
								<a href="#baixeapp" class="hvr-outline-out button3 scroll">Baixe o app e agende</a>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<div class="clearfix"></div>
</div>
<!-- //banner -->

<!-- services -->
<div class="services" id="sobre">
	<div class="container">
		<div class="col-md-4 services_left wow bounceInDown" data-wow-duration="1.5s" data-wow-delay="0s">
			<h3>Sobre</h3>
			<p class="ser-para" >Sched é uma aplicação gerenciadora de horários, assim como as partes envolvidas no processo,
			empresas, serviços, profissionais e clientes. Conta com relatórios financeiro, com opções de parametrização.</p>
			<!--<h3>Depoimentos</h3>
				<script>
						// You can also use "$(window).load(function() {"
						$(function () {
						 // Slideshow 4
						$("#slider4").responsiveSlides({
							auto: true,
							pager: true,
							nav: false,
							speed: 500,
							namespace: "callbacks",
							before: function () {
						$('.events').append("<li>before event fired.</li>");
						},
						after: function () {
							$('.events').append("<li>after event fired.</li>");
							}
							});
						});
				</script>
			<div  class="callbacks_container">
				<ul class="rslides" id="slider4">
					<li>
						<div class="ser-bottom">
							<h5>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit,
							sed quia consequuntur magni dolores eos qui </h5>
							<p>- Gustavo Henrique</p>
						</div>
					</li>
					<li>
						<div class="ser-bottom">
							<h5>Voluptas sit aspernatur aut odit aut fugit,sed quia consequuntur magni dolores 
							eos qui ratione voluptatem sequi nesciunt</h5>
							<p>- Pará</p>
						</div>
					</li>
					<li>
						<div class="ser-bottom">
							<h5>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit,
							sed quia consequuntur magni dolores eos qui </h5>
							<p>- Gabriela</p>
						</div>
					</li>
				</ul>
			</div>-->
			<div class="clearfix"></div>
		</div>
		<div class="col-md-8 services_right ">
			<div class="list-left text-center wow bounceInDown" data-wow-duration="1.5s" data-wow-delay="0.1s">
				<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
				<h4>App Customizado</h4>
				<p>Para cada estabelecimento, um webapp totalmente aderente ao ramo de trabalho e identidade da empresa.</p>
			</div>
			<div class="list-left text-center wow bounceInDown" data-wow-duration="1.5s" data-wow-delay="0.2s">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
				<h4>Cadastros práticos</h4>
				<p>A administração do seu app é feito por você, assim como o gerencimento de profissionais, mensagens e agenda.</p>
			</div>
			<div class="list-left text-center no_marg wow bounceInDown" data-wow-duration="1.5s" data-wow-delay="0.3s">
				<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
				<h4>Online</h4>
				<p>Sua agenda estará disponível 24hrs por dia para os usuários marcarem um agendamento.</p>
			</div>
			<div class="list-left text-center no_marg wow bounceInDown" data-wow-duration="1.5s" data-wow-delay="0.4s">
				<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
				<h4>Relatórios</h4>
				<p>Para validação e conferência de tudo que está sendo programado em seu estabelecimento.</p>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- //services -->


<!-- capabilities -->
<div class="capacity" id="baixeapp">
	<div class="container">
		<h3>Baixe um ou mais apps e faça parte</h3>

		<div class="panel panel-primary">
			<div class="panel-heading">
				Estabelecimentos
			</div>
			<div class="panel-body">
				<div class="list-group">
                    <?php
                    $stmt = $auth_user->runQuery("SELECT pasta, nomefantasia FROM empresas WHERE excluido = 'N' and bloqueio = 'N' and apenasint = 'N' order by datacadastro ");
                    $stmt->execute();
                    while($row = $stmt->fetch()) {
                        echo '<a href="'.$row['pasta'].'" target="_blank" class="list-group-item"> <img src="'.$row['pasta'].'/logo.png" height="30px"> '.$row['nomefantasia'].'</a>';
                    }
                    ?>
				</div>
			</div>
			<div class="panel-footer" style="font-style: italic"> © Todos os diretios reservados - SchedApp 2017</div>
		</div>

		<div class="col-md-3 capabil_grid1 wow fadeInDownBig animated animated text-center" data-wow-delay="0.4s">
			<div class="capil_text">
				<div class='numscroller numscroller-big-bottom' data-slno='1' data-min='0' data-max='<?php echo $numest; ?>' data-delay='.5' data-increment="100"><?php echo $numest; ?></div>
				<p>Estabelecimentos</p>
			</div>
		</div>
		<div class="col-md-3 capabil_grid2 wow fadeInUpBig animated animated text-center" data-wow-delay="0.4s">
			<div class="capil_text">
				<div class='numscroller numscroller-big-bottom' data-slno='1' data-min='0' data-max='<?php echo $numprof; ?>' data-delay='.5' data-increment="5"><?php echo $numprof; ?></div>
				<p>Profissionais</p>
			</div>
		</div>
		<div class="col-md-3 capabil_grid3 wow fadeInDownBig animated animated text-center" data-wow-delay="0.4s">
			<div class="capil_text">
				<div class='numscroller numscroller-big-bottom' data-slno='1' data-min='0' data-max='<?php echo $numcli; ?>' data-delay='.5' data-increment="100"><?php echo $numcli; ?></div>
				<p>Usuários</p>
			</div>
		</div>
		<div class="col-md-3 capabil_grid4 wow fadeInUpBig animated animated text-center" data-wow-delay="0.4s">
			<div class="capil_text">
				<div class='numscroller numscroller-big-bottom' data-slno='1' data-min='0' data-max='<?php echo $numage; ?>' data-delay='.5' data-increment="1"><?php echo $numage; ?></div>
				<p>Agendamentos</p>
			</div>
		</div>
		<div class="clearfix"></div>

	</div>
</div>
<!-- //capabilities -->
<!-- content -->
<div class="content">
	<div class="container">
		<div class="col-md-4 content_right wow flipInY" data-wow-duration="1.5s" data-wow-delay="0.1s">
			<img class="img-responsive" src="images/pic1.png" alt=" " />
		</div>
		<div class="col-md-4 content_left wow flipInY" data-wow-duration="1.5s" data-wow-delay="0.2s">
			<div class="welcome">
				<h3>Vantagens do sched</h3>
				<ul>
					<li><a href="">App customizado por estabelecimento</a></li>
					<li><a href="">Responsivo: smartphone, tablet e PCs</a></li>
					<li><a href="">Online 24x7x12 </a></li>
					<li><a href="">Prático</a></li>
					<li><a href="">Emissão de relatórios</a></li>
					<li><a href="">Custo baixo</a></li>
					<li><a href="">Mais organização para sua empresa</a></li>
				</ul>
			</div>
		</div>
		<div id="book" class="col-md-4 content_middle wow flipInY" data-wow-duration="1.5s" data-wow-delay="0.3s">
			<h3>Faça seu pré cadastro e entraremos em contato</h3>
            <div class="divrespostacontato"></div>
			<form id="formprecadastro" class="formcontato" method="post">
				<input type="text" name="nome" id="nomep" placeholder="Nome" maxlength="50" required>
				<input type="email" name="email" id="emailp" placeholder="Email" maxlength="50" required>
				<input type="text" name="telefone" id="telefonep" placeholder="Telefone" maxlength="50" required>
				<select id="comoconheceu" name="comoconheceu"  class="frm-field required sect" required>
					<option value="">Como conheceu o sched ?</option>
					<option value="C">Consultor de vendas</option>
					<option value="I">Indicação outro estabelecimento</option>
					<option value="G">Pesquisa no Google</option>
					<option value="R">Redes sociais</option>
					<option value="O">Outro</option>
				</select>
				<input type="submit" class="enviar" value="Enviar">
			</form>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- //content -->

<!-- contact -->
<div class="contact" id="contato">
	<div class="container">
		
		<div class="col-md-6 contact-right wow fadeIn animated animated" data-wow-delay="0.1s" data-wow-duration="2s">
			<h3>Contato</h3>
			<div class="strip"></div>
			<ul class="con-icons">
				<li><span class="glyphicon glyphicon-phone" aria-hidden="true"></span>+55 62 984258554</li>
				<li><a href="mailto:info@example.com"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>sched@schedapp.com.br</a></li>
			</ul>

			<ul class="fb_icons">
				<li class=""><a class="fb" href="https://www.facebook.com/appsched" target="_blank"></a></li>
				<li class=""><a class="insta" href="http://instagram.com/schedapp" target="_blank"></a></li>
			</ul>
			<div class="strip"></div>
            <div class="divrespostacontato"></div>
			<form id="formccontato" class="formcontato" action="#" method="post">
				<input type="text" name="nome" id="nomecontato" placeholder="Nome" maxlength="50" required>
				<input type="email" name="email" id="emailcontato" placeholder="Email" maxlength="50" required>
				<input type="text" name="telefone" id="telefonecontato" placeholder="Telefone" maxlength="50" required>
				<input type="text" name="mensagem" id="mensagem" placeholder="Mensagem" maxlength="100" required><br>
				<input type="submit" class="enviar" value="Enviar">
			</form>
		</div>
		<div class="col-md-6 contact-left wow fadeIn animated animated" data-wow-delay="0.1s" data-wow-duration="2s">
			<h2>Informação</h2>
			<div class="strip"></div>
			<p class="para">Ao baixar algum app ou utilizar os recursos via navegador,
				você está concordando com os nossos <a href="#" data-toggle="modal" data-target="#termos">termos e condições</a>.</p>
			<p class="copy-right">© 2017 SchedApp todos os direitos reservados | Desenvolvido por <a href="#" data-toggle="modal" data-target="#myModal">Rychard Hiago</a></p>

		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- //contact -->


<!-- modal R -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" >
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-info">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body modal-spa">
				<h3 class="modal-title text-primary">Rychard Hiago - Desenvolvedor Web</h3><br>
				(62) 9 8425-8554 <br>
				rychardhiago@gmail.com<br>

			</div>
		</div>
	</div>
</div>
<!-- fim modal R -->
<!-- login -->
			<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" data-focus-on="input:first" >
				<div class="modal-dialog" role="document">
					<div class="modal-content modal-info">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
						</div>
						<div class="modal-body modal-spa">
							<div class="login-grids">
									
									<div id="divlogin" class="login-right">
										<h3>Login</h3>
										<form id="formlogin" action="#" method="post">
                                        <div id="carregandolog" class="center-block" align="center"><img src="images/carregando.gif"></div>
										<div id="divrespostalog"></div>
											<div class="sign-in">
												<h4>Email</h4>
												<input type="text" name="email" id="email" placeholder="Email" required autofocus>
											</div>
											<div class="sign-in">
												<h4>Senha</h4>
												<input type="password" name="senhal" id="senhal" placeholder="Senha" required>
												<a id="esqueceu" href="#" target="_blank">Esqueceu sua senha?</a>
											</div><br>
											<div class="sign-in">
												<input id="logar" type="submit" value="LOGIN" >
											</div>
										</form>
                                        <p>Ao logar você concorda com os nossos <a href="#" data-toggle="modal" data-target="#termos">termos e condições</a></p>
									</div>

                                    <div id="divreset" class="login-right">
                                        <h3>Esqueceu sua senha?</h3>
                                        <form id="formreset" action="#" method="post">
                                            <div id="carregandoreset" class="center-block" align="center"><img src="images/carregando.gif"></div>
                                            <div id="divrespostareset"></div>
                                            <div class="sign-in">
                                                <h4>Email</h4>
                                                <input type="text" name="emailres" id="emailres" placeholder="Email" required autofocus>
                                                <a id="btnlogin" href="#" target="_blank">Voltar a tela de login</a>
                                            </div><br>

                                            <div class="sign-in">
                                                <input id="logarres" type="submit" value="ENVIAR" >
                                            </div>
                                        </form>
                                    </div>
									

							</div>
						</div>
					</div>
				</div>
			</div>
<!-- //login -->
<!-- cadastro login -->
			<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" >
				<div class="modal-dialog" role="document">
					<div class="modal-content modal-info">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
						</div>
						<div class="modal-body modal-spa">
							<div class="login-grids">
									<div class="login-bottom">
										<h3>Cadastre-se, é totalmente grátis</h3>
										<div id="carregando" class="center-block" align="center"><img src="images/carregando.gif"></div>
										<div id="divresposta"></div>
										<form id="formcad" action="#" method="post">
											<div class="sign-up">
												<h4>Nome</h4>
												<input type="text" name="nome" id="nome" placeholder="Nome" maxlength="100" required autofocus>
											</div>
                                            <div class="sign-up">
                                                <h4>Data de nascimento</h4>
                                                <input type="date" name="dtnascimento" id="dtnascimento" placeholder="Data de nascimento" required>
                                            </div>
                                            <div class="sign-up">
												<h4>Endereço</h4>
												<input type="text" name="endereco" id="endereco" placeholder="Endereço" maxlength="250" required>
											</div>
											<div class="sign-up">
												<h4>Telefone</h4>
												<input type="text" name="telefone" id="telefone" placeholder="Telefone" maxlength="20" required>
											</div>
											<div class="sign-up">
												<h4>Email</h4>
												<input type="text" name="emailr" id="emailr" placeholder="Email" maxlength="100" required>
											</div>
											<div class="sign-up">
												<h4>Senha</h4>
												<input type="password" name="senha" id="senha" placeholder="Senha" maxlength="10" minlength="6" required>
											</div>
											<div class="sign-up">
												<h4>Repita a senha</h4>
												<input type="password" name="senhar" id="senhar" placeholder="Senha" maxlength="10" minlength="6" required>
											</div>
											<div class="sign-up">
												<input id="termosecond" type="checkbox" class="checkbox checkbox-inline" required> Concordo com os <a href="#" data-toggle="modal" data-target="#termos">termos e condições</a>
											</div><br>
											<div class="sign-up">
												<input id="cadastrar" type="submit" value="Cadastrar">
											</div>
											
										</form>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<!-- // cadastro login -->


<!-- termos -->
<div class="modal fade" id="termos" tabindex="-1" role="dialog" >
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-info">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body modal-spa">
				<h3 class="modal-title">Termos e condições</h3><br>
				 <br>


			</div>
		</div>
	</div>
</div>
<!-- termos -->

<!-- confirmacao -->
<div class="modal fade" id="confirmacao" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-info">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body modal-spa">
                <h3 class="modal-title">Confirmação de conta</h3><br>
                <span id="bodyconfirmacao"></span> <br>
            </div>
        </div>
    </div>
</div>
<!-- confirmacao -->


<!-- confirmacao contato -->
<div class="modal fade" id="modalrespcontato" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-info">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body modal-spa">
                <h3 class="modal-title">Obrigado!</h3><br>
                <span id="bodymodal">Agradecemos o contato em breve responderemos =) </span> <br>
            </div>
        </div>
    </div>
</div>
<!-- confirmacao contato -->

<!-- login -->
<div class="modal fade" id="mudasenha" tabindex="-1" role="dialog" data-focus-on="input:first" >
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-info">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body modal-spa">
                <div class="login-grids">
                    <div id="divreset" class="login-right">
                        <h3>Nova senha</h3>
                        <form id="formmuda" action="#" method="post">
                            <div id="carregandomuda" class="center-block" align="center"><img src="images/carregando.gif"></div>
                            <div id="divrespostamuda"></div>
                            <div class="sign-up">
                                <h4>Senha</h4>
                                <input type="password" name="senham" id="senham" placeholder="Senha" maxlength="10" minlength="6" required>
                            </div>
                            <div class="sign-up">
                                <h4>Repita a senha</h4>
                                <input type="password" name="senhamr" id="senhamr" placeholder="Senha" maxlength="10" minlength="6" required>
                            </div>

                            <div class="sign-in">
                                <input id="logarmuda" type="submit" value="ENVIAR" >
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- //login -->

<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>
<script>
    /**
     * retorna valor da variavel get
     */
    function getUrlVars(){
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

    function empty(str){
        if (typeof str == 'undefined' || !str || str.length === 0 || str === "" || !/[^\s]/.test(str) || /^\s*$/.test(str) || str.replace(/\s/g,"") === ""){
            return true;
        }
        else{
            return false;
        }
    }

    

    var email = getUrlVars()["e"];
    var token = getUrlVars()["t"];
    var acao = getUrlVars()["acao"];
    var cod = getUrlVars()["c"];
    if(!empty(acao)){
        if (!empty(email) && !empty(token) && !empty(cod)){
            var dados = 'classe=clientes&acao=existe&valor=R&email=' + email +'&token=' + token + '&cod=' + cod ;
            $.post("acoes.php", dados, function (json) {
                var resposta = jQuery.parseJSON(json);
                if (resposta.retorno[0].retorno) {
                    $('#mudasenha').modal('show');
                }
            });
        }
    }
    else if (!empty(email) && !empty(token) && empty(acao)){
        var dados = 'classe=clientes&acao=confirmar&valor=R&email=' + email +'&token=' + token ;
        $.post("acoes.php", dados, function (json) {
            var resposta = jQuery.parseJSON(json);
            if (!resposta.retorno[0].retorno) {
                $('#bodyconfirmacao').html('<h2 class="text-danger"><i class="glyphicon glyphicon-remove"></i> Ops!</h2><br> <h4 class="text-muted">Ocorreu um erro ao confirmar sua conta. Tente mais tarde =(</h4>');
            }
            else{
                $('#bodyconfirmacao').html('<h2 class="text-success"><i class="glyphicon glyphicon-ok"></i> Pronto!</h2><br> <h4 class="text-muted">Agora você pode fazer seu login e aproveitar nossos apps =)</h4>');
            }
            $('#confirmacao').modal('show');
        });
    }

    $('#carregandomuda').hide();
    $('#formmuda').on('submit', function () {
        $('#carregandomuda').show();
        $('#logarmuda').hide();

        var dados = 'classe=clientes&acao=register&valor=R&nome=H&emailr=' + email +'&token=' + token + '&clienteid=' + cod + '&senha=' + $('#senhamr').val();
        $.post("acoes.php", dados, function (json) {
            var resposta = jQuery.parseJSON(json);
            if (!resposta.retorno[0].retorno) {
                $('#divrespostamuda').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i>' + resposta.mensagem[0].mensagem + '</div>');
            }
            else{
                $('#formmuda')[0].reset();
                $('#divrespostamuda').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-check-circle"></i>Senha atualizada com sucesso.</div>');
            }
        });

        $('#carregandomuda').hide();
        $('#logarmuda').show();
        return false;
    });

    $('#carregando').hide();

    $(document).on('hidden.bs.modal', function (event) {
        if ($('.modal:visible').length) {
            $('body').addClass('modal-open');
        }
    });

    $('#divreset').hide();
    $('#carregandoreset').hide();

    $('#esqueceu').on('click', function () {
       $('#divlogin').hide();
       $('#divreset').show();
        return false;
    });

    $('#btnlogin').on('click', function () {
        $('#divlogin').show();
        $('#divreset').hide();
        return false;
    });

    $('#formcad').on('submit', function() {
        $('#carregando').show();
        var inputs = $(this).serialize();
        $('#cadastrar').hide();

        var dados = 'classe=clientes&acao=register&valor=R&' + inputs;
        $.post("acoes.php", dados, function (json) {
            var resposta = jQuery.parseJSON(json);
            if (!resposta.retorno[0].retorno) {
                $('#divresposta').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i>' + resposta.mensagem[0].mensagem + '</div>');
            }
            else{
                $('#divresposta').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-check-circle"></i>Cadastro efetuado com sucesso.<br>Acesse seu email e confirme sua conta.<br> Confira sua caixa de entrada e spam(Lixeira). </div>');
                window.scrollTo(0,1);
            }
        });

        $('#cadastrar').show();
        $('#formcad')[0].reset();
        $('#carregando').hide();
        return false;
    });
    
    $('#carregandolog').hide();

    $('#cadastre').on('click', function () {
       $('#myModal5').modal('show');
    });

    $('#formlogin').on('submit', function() { 
        $('#carregandolog').show();
        var inputs = $(this).serialize();
        $('#logar').hide();

        var dados = 'classe=clientes&acao=doLogin&valor=R&' + inputs;
        $.post("acoes.php", dados, function (json) {
            var resposta = jQuery.parseJSON(json);
            if (!resposta.retorno[0].retorno) {
                $('#divrespostalog').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> Email ou senha inválidos!  </div>');
            }
            else{
               $('#formlogin')[0].reset();
               $('#myModal4').modal('hide');
                window.location.href = "minhaconta/index.php";
            }
        });

        $('#logar').show();
       
        $('#carregandolog').hide();
        return false;
    });

    $('#formreset').on('submit', function() {
        $('#carregandoreset').show();
        $('#logarres').hide();

        var dados = 'classe=clientes&acao=reset&valor=R&emailres=' + $('#emailres').val();
        $.post("acoes.php", dados, function (json) {
            var resposta = jQuery.parseJSON(json);
            if (!resposta.retorno[0].retorno) {
                $('#divrespostareset').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i>' + resposta.mensagem[0].mensagem + '</div>');
            }
            else{
                $('#formreset')[0].reset();
                $('#divrespostareset').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> Enviamos um email com as intruções para mudar sua senha.  </div>');
            }
        });

        $('#logarres').show();
        $('#carregandoreset').hide();
        return false;
    });

    $('.formcontato').on('submit', function() {
        $('#carregandocontato').show();
        var inputs = $(this).serialize();
        $('.enviar').hide();

        var dados = 'classe=contato&acao=register&valor=R&' + inputs;
        $.post("acoes.php", dados, function (json) {
            var resposta = jQuery.parseJSON(json);
            if (!resposta.retorno[0].retorno) {
                $('.divrespostacontato').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> Erro ao enviar os dados!  </div>');
            }
            else{
                $('.formcontato')[0].reset();
                $('#modalrespcontato').modal('show');
            }
        });
        $('.enviar').show();
        $('#carregandocontato').hide();
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

    var passwordm = document.getElementById("senham");
    var confirm_passwordm = document.getElementById("senhamr");

    function validatePasswordm(){
        if(passwordm.value == confirm_passwordm.value) {
            confirm_passwordm.setCustomValidity('');
        } else {
            confirm_passwordm.setCustomValidity("Senhas não são iguais");
        }
    }

    passwordm.onchange = validatePasswordm;
    confirm_passwordm.onkeyup = validatePasswordm;

</script>
</body>
</html>

