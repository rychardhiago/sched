<?php
    date_default_timezone_set('America/Sao_Paulo');
    require_once("../session.php");
    /*
     * Variaveis
     */
    $empresaid = 1;
    $_SESSION['empresaid'] = $empresaid;

    $auth_user->ultimos($_SESSION['empresaid']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>The Best Barbearia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">

    <meta name="apple-mobile-web-app-title" content="The Best">

    <link rel="shortcut icon" sizes="16x16" href="logo.png">
    <link rel="shortcut icon" sizes="196x196" href="logo.png">
    <!--link rel="apple-touch-icon-precomposed" sizes="152x152" href="icon-152x152.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="icon-144x144.png">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="icon-120x120.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="icon-114x114.png">
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="icon-76x76.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="icon-72x72.png"-->
    <link rel="apple-touch-icon-precomposed" href="logo.png">


    <script type="application/x-javascript">
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); } </script>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../js/numscroller-1.0.js"></script>
    <script type="text/javascript" src="../js/move-top.js"></script>
    <script type="text/javascript" src="../js/easing.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
            });
        });
    </script>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/addtohomescreen.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="stylesheet" type="text/css" href="css/JTable.css">


    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">


    <div class="">
        <!------------- Navbar -------------->
        <nav class="navbar navbar-inverse bs-dark">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">The Best Barbearia</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home <span class="sr-only">(current)</span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#sobre" class="scroll">Sobre nós</a></li>
                            <li><a href="#servicos" class="scroll">Serviços</a></li>
                            <li><a href="#prof" class="scroll">Profissionais</a></li>
                            <li><a href="#agenda" class="scroll">Agenda</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#conta" class="scroll">Contato</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle navbar-img" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

                            <?php
                            $imagem = "../clientes/imagens/".$_SESSION['user_session'].".jpg";
                            if(file_exists($imagem)){
                                echo '<img class="user_img img-circle imgper" src="'.$imagem.'">';
                            }
                            else{
                                echo '<h1><i class="glyphicon glyphicon-user user_img img-circle"></i></h1>';
                            }
                            ?>

                            <b><?php echo $_SESSION['nome']; ?><span class="caret"></span></b>

                        </a>
                        <ul class="dropdown-menu">
                            <li><a id="btnperfil" href="#" data-toggle="modal" data-target="#perfil">Perfil</a></li>
                            <li><a id="btnagendamentos" href="#" data-toggle="modal" data-target="#agendamentos">Meus agendamentos</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a id="logout" href="#">Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!----------- !Navbar End ------------>

        <div class="center-block" align="center">
            <img src="logo.png" class="img-responsive" style="max-height: 400px;">
        </div>

        <div class="corpo">
            <div id="sobre">
                <h1 class="titulos">Sobre nós</h1>
                <div style="padding-left: 2%; padding-right: 1%;">
                <?php
                $stmt = $auth_user->runQuery("SELECT empresas.sobre, diassemana FROM empresas WHERE excluido = 'N' and empresaid = :empresaid order by nomefantasia ");
                $stmt->bindParam('empresaid',$empresaid);
                $stmt->execute();
                $row = $stmt->fetch();

                echo nl2br($row['sobre']);

                $diassemana = '';
                $array = explode(',',$row['diassemana']);

                ?>
                </div>
            </div>

            <div id="servicos">
                <h1 class="titulos">Serviços</h1><br>
                <div style="padding-left: 2%;  padding-right: 1%;">
                <?php

                $stmt = $auth_user->runQuery("SELECT servicos.nome, servicos.descricao, servicos.preco, servicos.tempo FROM servicos WHERE excluido = 'N' and empresaid = :empresaid order by nome ");
                $stmt->bindParam('empresaid',$empresaid);
                $stmt->execute();
                while($row = $stmt->fetch()) {
                    echo '<h3><i class="glyphicon glyphicon-menu-right"></i> '.$row['nome'].'</h3>';
                    echo '<p class="text-muted">'.$row['descricao'].'</p>';
                    echo '<b>A partir de R$ '.number_format($row['preco'], 2, ',', '.').' | Tempo médio: '.$row['tempo'].'</b><br><br>';
                }

                ?>
                </div>
            </div><br>

            <div id="prof">
                <h1 class="titulos">Profissionais</h1><br>
                <div style="padding-left: 2%;  padding-right: 1%;">
                    <div id="divrespostaagendap"></div>
                    <?php

                    $stmt = $auth_user->runQuery("SELECT nome, descricao, profissionaiid FROM profissionais WHERE excluido = 'N' and empresaid = :empresaid order by nome ");
                    $stmt->bindParam('empresaid',$empresaid);
                    $stmt->execute();
                    while($row = $stmt->fetch()) {
                        echo '<h3>';
                        $imagem = "../admin/empresas/".$empresaid."/imagens/".$row['profissionaiid'].".jpg";
                        if(file_exists($imagem)){
                            echo '<img class="user_img img-circle imgper" src="'.$imagem.'">';
                        }
                        else{
                            echo '<i class="glyphicon glyphicon-menu-right"></i>';
                        }

                        echo ' '.$row['nome'].'</h3>';
                        echo '<p class="text-muted">'.nl2br($row['descricao']).'</p><br>';
                        echo '<b><a href="#" data-nome="'.$row['nome'].'"  data-valor="'.$row['profissionaiid'].'" class="btn btn-lg btn-success agendap"><i class="glyphicon glyphicon-calendar"></i> Agenda de '.$row['nome'].'</a> </b><br><br>';
                    }

                    ?>
                </div>
            </div>

            <div id="agenda">
                <h1 class="titulos">Agenda</h1><br>
                <div style="padding-left: 2%;  padding-right: 1%;">
                    <div id="divrespostaagenda"></div>
                    <form id="formagendar" method="post">
                        <?php
                            $days = array('domingo', 'segunda', 'terça', 'quarta','quinta','sexta', 'sabádo');
                            for($i=0;$i<count($array);$i++){
                                $diassemana .= $days[$array[$i]-1].', ';
                            }
                            $diassemana = substr($diassemana,0,(strlen($diassemana)-2));
                            echo '<i><h4>* Aberto '.$diassemana.'.</h4></i><br>';
                        ?>
                        Escholha uma <b>data:</b><br><br>
                        <input type="date" name="data" id="data" class="agendar" required><br><br>
                        Escolha um <b>horário:</b><br><br>
                        <select name="horario" id="horario" class="agendar" required>
                            <option value="">Horário</option>

                            <?php
                            date_default_timezone_set('America/Sao_Paulo');
                            $stmt = $auth_user->runQuery("SELECT hrsabertura, hrsfechamento , TIME_TO_SEC(intervalo) intervalo FROM empresas WHERE excluido = 'N' and empresaid = :empresaid ");
                            $stmt->bindParam('empresaid',$empresaid);
                            $stmt->execute();
                            $row = $stmt->fetch();

                            echo '<option value="'.strtotime($row['hrsabertura']).'">'.$row['hrsabertura'].'</option>';
                            $hora = 0;
                            $horainicial = $row['hrsabertura'];
                            while((strtotime($horainicial) + $row['intervalo']) < strtotime($row['hrsfechamento'])){
                                $newdate = strtotime($horainicial) + $row['intervalo'];
                                $datafim = date('H:i:s', $newdate);
                                echo '<option value="' . $newdate . '">' . $datafim . '</option>';
                                $hora = $newdate;
                                $horainicial = $datafim;
                            }
                            ?>


                        </select><br><br>
                        Escolha um ou mais <b>serviços:</b><br><br>
                        <select name="servico" id="servico" class="agendar" data-placeholder="Selecione o(s) serviço(s)" multiple required>
                            <option value="">Serviço</option>
                            <?php
                                $stmt = $auth_user->runQuery("SELECT servicos.servicoid, servicos.nome FROM servicos WHERE excluido = 'N' and empresaid = :empresaid order by nome ");
                                $stmt->bindParam('empresaid',$empresaid);
                                $stmt->execute();
                                while($row = $stmt->fetch()) {
                                    echo '<option value="'.$row['servicoid'].'">'.$row['nome'].'</option>';
                                }

                            ?>

                        </select><br><br><br>
                        <input type="submit" id="agendar" class="btn btn-lg btn-primary" value="Agendar"><br><br>
                    </form>
                </div>
            </div>

            <div id="conta">
                <h1 class="titulos">Contato</h1><br>
                <div style="padding-left: 2%;  padding-right: 1%;">
                    <?php

                    $stmt = $auth_user->runQuery("SELECT nomefantasia, endereco, contato FROM empresas WHERE excluido = 'N' and empresaid = :empresaid ");
                    $stmt->bindParam('empresaid',$empresaid);
                    $stmt->execute();
                    while($row = $stmt->fetch()) {
                        echo '<h3>'.$row['nomefantasia'].'</h3>';
                        echo '<p class="text-muted">'.nl2br($row['endereco']).'</p>';
                        echo '<b>Telefone: '.$row['contato'].'</b><br><br>';
                    }

                    ?>
                    <div class="map" align="center">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3819.0784484957!2d-49.25344678513161!3d-16.82246388841945!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x935efb81dbaec143%3A0x30c04fd31b2738f4!2sThe+Best+Barbearia!5e0!3m2!1spt-BR!2sbr!4v1508187986778" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                    <br>
                    <h5 style="font-style: italic"> © Todos os diretios reservados - SchedApp 2017 </h5>
                </div>
            </div>

        </div>


    </div>

    <!-- login -->
    <div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" data-focus-on="input:first" >
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-info">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body modal-spa">
                    <div class="login-grids">

                        <div id="divlogin" class="login-right">
                            <h3>Login - Sched</h3>
                            <form id="formlogin" action="#" method="post">
                                <div id="carregandolog" class="center-block carregando" align="center"><img src="../images/carregando.gif"></div>
                                <div id="divrespostalog"></div>
                                <div class="sign-in">
                                    <h4>Email</h4>
                                    <input type="text" name="email" id="email" placeholder="Email" required autofocus>
                                </div>
                                <div class="sign-in">
                                    <h4>Senha</h4>
                                    <input type="password" name="senhal" id="senhal" placeholder="Senha" required>
                                    <a id="esqueceu" href="#">Esqueceu sua senha?</a> <a id="cadastrese" href="#" class="pull-right" data-toggle="modal" data-target="#cadastromodal">Cadastre-se</a>
                                </div><br>
                                <div class="sign-in">
                                    <input id="logar" type="submit" value="LOGIN" >
                                </div>
                            </form>
                            <p>Ao logar você concorda com os nossos <a href="#" class="text-primary" data-toggle="modal" data-target="#termos">termos e condições</a></p>
                        </div>

                        <div id="divreset" class="login-right">
                            <h3>Esqueceu sua senha?</h3>
                            <form id="formreset" action="#" method="post">
                                <div id="carregandoreset" class="center-block carregando" align="center"><img src="../images/carregando.gif"></div>
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
    <div class="modal fade" id="cadastromodal" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-info">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body modal-spa">
                    <div class="login-grids">
                        <div class="login-bottom">
                            <h3>Cadastre-se, é totalmente grátis</h3>
                            <div id="carregando" class="center-block carregando" align="center"><img src="../images/carregando.gif"></div>
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
                                    <input type="text" name="endereco" id="endereco" placeholder="Endereço Ex.: Rua Silva N02 Q01 L10 Centro" maxlength="250" required>
                                </div>
                                <div class="sign-up">
                                    <h4>Telefone</h4>
                                    <input type="text" name="telefone" id="telefone" placeholder="Telefone Ex.: (XX) XXXXX-XXXX" maxlength="20" required>
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


    <!-- perfil -->
    <div class="modal fade" id="perfil" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-info">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body modal-spa">
                    <div class="login-grids">
                        <div class="login-bottom">
                            <h3>Perfil</h3>
                            <div class="perfil" align="center" class="center-block">
                                <?php
                                $imagem = "../clientes/imagens/".$_SESSION['user_session'].".jpg";
                                if(file_exists($imagem)){
                                    echo '<a><img id="imgperfil" class="imgper img-circle user_img" src="'.$imagem.'" style="max-height:70px;"></a>';
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

                            <div id="carregandoper" class="center-block carregando" align="center"><img src="../images/carregando.gif"></div>
                            <div id="divrespostaper"></div>
                            <form id="formper" action="#" method="post" class="">
                                <div class="sign-up">
                                    <h4>Nome</h4>
                                    <input type="text" class="form-control" name="nome" id="nomeper" placeholder="Nome" maxlength="100" required autofocus>
                                </div>
                                <div class="sign-up">
                                    <h4>Endereço</h4>
                                    <input type="text" class="form-control" name="endereco" id="enderecoper" placeholder="Endereço" maxlength="250" required>
                                </div>
                                <div class="sign-up">
                                    <h4>Telefone</h4>
                                    <input type="text" class="form-control" name="telefone" id="telefoneper" placeholder="Telefone" maxlength="20" required>
                                </div>
                                <div class="sign-up">
                                    <h4>Email</h4>
                                    <input type="text" class="form-control" name="email" id="emailper" placeholder="Email" maxlength="100" required>
                                </div>
                                <div class="sign-up">
                                    <h4>Senha</h4>
                                    <input type="password" class="form-control" name="senha" id="senhaper" placeholder="Senha" maxlength="10" minlength="6" required>
                                </div>
                                <div class="sign-up">
                                    <input id="salvar" class="form-control" type="submit" value="Salvar">
                                </div>

                            </form>
                            <br><br>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- perfil -->

    <!-- agendamentos -->
    <div class="modal fade" id="agendamentos" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-info">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body modal-spa">
                    <div class="login-grids">
                        <div class="login-bottom">
                            <h3 class="modal-title">Meus agendamentos</h3><br>

                            <div id="respostaag"></div><br>

                            <div id="divtable" class="table-responsive">
                                <table id="tabela_dados" class="table table-responsive table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th data-bSortable="true">#</th>
                                        <th data-bSortable="true">Data</th>
                                        <th data-bSortable="true">Estabelecimento</th>
                                        <th data-bSortable="true">Profissional</th>
                                        <th class="noprint">Ações</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                            <script type="text/javascript">
                                var classe = 'agendamentos';
                                var divresposta = '#respostaag';
                                var campos = 'agendamentoid, agendamentos.datainicio as data, cancelado as status, obscancel as obs, empresas.nomefantasia as estabelecimento, profissionais.nome as profissional';
                                var alias = 'cliente';
                                var inner = '';
                                var campoI = 'empresaid';
                                var tabela = 'empresas';
                                var campo = 'empresaid';
                                var tabela2 = 'profissionais';
                                var campo2 = 'profissionaiid';
                                var limite = 0;
                                var ordem = "datainicio DESC";
                                var apenasempresa = 0;
                                var mobil = 1;


                                var table = '#tabela_dados';
                                var consulta = 'consultaI';
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- agendamentos -->


    <!-- agendar -->
    <div class="modal fade" id="modalagendar" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-info">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body modal-spa">
                    <div id="divagendar"></div>
                </div>

            </div>
        </div>
    </div>
    <!-- agendar -->


    <script type="text/javascript" src="../dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="../dist/css/select2.min.css">

    <script src="js/addtohomescreen.js"></script>
    <script>
        addToHomescreen.removeSession();
        addToHomescreen({
            startDelay: 0
        });

        $('#servico').select2();

        /**
         * Agendar
         *
         */

        $('.agendap').on('click', function () {
            $(this).prop('disabled',true);
            var dados = 'acao=P&profissionaiid='+$(this).data('valor')+'&nome='+$(this).data('nome');
            $.post("agendar.php", dados, function (json){
                $('#divagendar').html(json);
                $('#modalagendar').modal('show');
            });
            $(this).prop('disabled',false);
            return false;
        });

        /**
         * Agendar
         *
        */

        $('#formagendar').on('submit', function () {
            $('#agendar').prop('disabled',true);
            var dados = 'acao=A&data='+$('#data').val()+'&horario='+$('#horario').val()+'&servico='+$('#servico').val();
            $.post("agendar.php", dados, function (json) {
                $('#divagendar').html(json);
                $('#modalagendar').modal('show');
            });
            $('#agendar').prop('disabled',false);
            return false;
        });

        /*
        ********** LOGIN **************
         */
        var logado = true;
        $('.carregando').hide();
        $('#divreset').hide();
        <?php
            if(!$auth_user->is_loggedin()){
                echo "$('#loginmodal').modal('show'); logado = false;";
            }
        ?>

        $('#formlogin').on('submit', function() {
            $('#carregandolog').show();
            var inputs = $(this).serialize();
            $('#logar').hide();

            var dados = 'classe=clientes&acao=doLogin&valor=R&' + inputs;
            $.post("../acoes.php", dados, function (json) {
                var resposta = jQuery.parseJSON(json);
                if (!resposta.retorno[0].retorno) {
                    $('#divrespostalog').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> Email ou senha inválidos!  </div>');
                }
                else{
                    $('#formlogin')[0].reset();
                    $('#loginmodal').modal('hide');
                    window.location.href = "index.php";
                }
            });

            $('#logar').show();

            $('#carregandolog').hide();
            return false;
        });

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

        $('#formreset').on('submit', function() {
            $('#carregandoreset').show();
            $('#logarres').hide();

            var dados = 'classe=clientes&acao=reset&valor=R&emailres=' + $('#emailres').val();
            $.post("../acoes.php", dados, function (json) {
                var resposta = jQuery.parseJSON(json);
                if (!resposta.retorno[0].retorno) {
                    $('#divrespostareset').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i>' + resposta.mensagem[0].mensagem + '</div>');
                }
                else{
                    $('#formreset')[0].reset();
                    $('#divrespostareset').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> Enviamos um email com as intruções para mudar sua senha. <br> Confira sua caixa de entrada e spam(Lixeira).   </div>');
                }
            });

            $('#logarres').show();
            $('#carregandoreset').hide();
            return false;
        });


        $(document).on('hidden.bs.modal', function (event) {
            if(!logado){
                $('#loginmodal').modal('show');
            }
        });

        /*
        *********** FIM LOGIN *********
        */


        /*
        ************** CADASTRE-SE *********************
         */

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

        /*
        *************** FIM CADASTRE-SE *****************
         */

        /*
        ************ LOGOUT
         */

        $('#logout').on('click', function () {
            var dados='user';
            $.post("logout.php", dados, function (json) {
                window.location.href = "index.php";
            });
            return false;
        });

        /*
        ************ FIM LOGOUT
         */


        /*
        ************* PERFIL *********************
         */
        $('#btnperfil').on('click', function (event) {
            var uid = '<?php echo $_SESSION['user_session']; ?>';
            var dados = 'classe=clientes&acao=consulta&valor=' + uid;

            $('#carregandoper').show();
            $.post("../acoes.php", dados, function (json) {
                var resposta = jQuery.parseJSON(json);
                if(!resposta .retorno[0].retorno){
                    $('#respostaper').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
                }
                else {
                    var dados = resposta.dados[0].dados[0];
                    $.each(dados,function(index, value){
                        $('#'+ index+'per').val(value);
                    });
                    if($('#senhaper').length > 0) {
                        $('#senhaper').val('');
                    }
                    $('#carregandoper').hide();
                }
            });
        });


        $('#formper').on('submit', function() {
            $('#carregandoper').show();
            var inputs = $(this).serialize();
            $('#salvar').hide();

            var dados = 'classe=clientes&acao=editar&valor=R&' + inputs+'&clienteid=<?php echo $_SESSION['user_session']; ?>';
            $.post("../acoes.php", dados, function (json) {
                var resposta = jQuery.parseJSON(json);
                if (!resposta.retorno[0].retorno) {
                    $('#divrespostaper').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> ' + resposta.mensagem[0].mensagem + '  </div>');
                }
                else{
                    $('#divrespostaper').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> ' + resposta.mensagem[0].mensagem + '</div>');
                }
            });
            $('#salvar').show();
            $('#carregandoper').hide();
            return false;
        });

        /*
        ************* FIM PERFIL *******************
         */
    </script>

    <link href="../minhaconta/up/uploadfile.css" rel="stylesheet">
    <script src="../minhaconta/up/jquery.uploadfile.min.js"></script>

    <script>
        var ret= $("#fileuploads1").uploadFile(
            {
                url:"../minhaconta/up/php/upload.php",
                uploadStr: "Foto",
                fileName:"myfile",
                allowedTypes:"jpg,png,gif,jpeg",
                multiple:false,
                maxFileSize: 2097152,
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
                abortStr: 'Cancelar',
                sizeErrorStr: 'Imagem não enviada! Tamanho máximo permitido é ',
                showStatusAfterSuccess:true
            });

    </script>

    <script type="text/javascript" language="javascript" src="../minhaconta/js/dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="../minhaconta/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="../minhaconta/js/moment.min.js"></script>
    <script src="../minhaconta/js/funcoes.js"></script>
    <script type="text/javascript">
        table_carregar(table,classe);
        $("#agendamentos").on("show.bs.modal", function () {
            table_carregar(table,classe);
        });
    </script>

</head>

</html>