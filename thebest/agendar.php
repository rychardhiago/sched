<?php
    date_default_timezone_set('America/Sao_Paulo');
    require_once("../session.php");

/**
 *  Via Agenda
 */

    if($_POST['acao'] == 'A'){
        echo '<h3 class="text-primary">Agendar</h3><br>';
        /**
         * Validações
         */
        $hoje = date('Y-m-d');
        if ($_POST['data'] < $hoje) {
            echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="glyphicon glyphicon-remove"></i> A data deve ser maior ou igual a hoje. </div>';
            exit();
        } else if ($_POST['data'] == $hoje) {
            $agora = date('H:i:s');
            if ($_POST['horario'] < strtotime($agora)) {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="glyphicon glyphicon-remove"></i> O horário deve ser maior que agora. </div>';
                exit();
            }
        }

        $ini = $_POST['data'] . ' ' . date('H:i:s', $_POST['horario']);
        $start = strtotime($ini);

        $stmt = $auth_user->runQuery("SELECT SUM(preco) preco, SUM(TIME_TO_SEC(tempo)) tempo FROM `servicos` WHERE servicoid in(" . $_POST['servico'] . ")");
        $stmt->execute();
        $s = $stmt->fetch();
        $tempototal = $s['tempo'];
        $end = $start + $tempototal - 60;//retirando 1 min

        $stmt = $auth_user->runQuery("SELECT hrsabertura, hrsfechamento FROM empresas WHERE excluido = 'N' and empresaid = :empresaid ");
        $stmt->bindParam('empresaid',$_SESSION['empresaid']);
        $stmt->execute();
        $row = $stmt->fetch();
        $horafechamento = strtotime($row['hrsfechamento']);

        if (strtotime(date('H:i:s',$end)) > $horafechamento) {
            echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="glyphicon glyphicon-remove"></i> O horário escolhido mais o tempo de execução do serviço ultrapassa a hora de fechamento deste estabelecimento. </div>';
            exit();
        }

        $sql = " SELECT profissionais.profissionaiid, profissionais.nome, profissionais.hralmocoini, profissionais.hralmocofim , count(relservicosprofissionais.profissionaiid) as conta  FROM profissionais, relservicosprofissionais, servicos";
        $sql .= " WHERE profissionais.excluido = 'N' and relservicosprofissionais.profissionaiid = profissionais.profissionaiid and servicos.servicoid = relservicosprofissionais.servicoid ";
        $sql .= " and servicos.servicoid in( " . $_POST['servico'] . " )";
        $sql .= " group by relservicosprofissionais.profissionaiid order by profissionais.nome";

        $stmt = $auth_user->runQuery($sql);
        $stmt->execute();
        $min_conta = substr_count($_POST['servico'],',')+1;

        echo 'Para o(s) serviço(s) selecionado(s) na data de <b>' . date('d/m/Y', strtotime($_POST['data'])) . '</b> as <b>' . date('H:i:s', $_POST['horario']) . '</b> temos os seguintes profissionais: ';

        echo "<form name='formagendamento' id='formagendamento' method='post'>";
        echo "<input type='hidden' name='datainicio' value='" . $_POST['data'] . ' ' . date('H:i:s', $_POST['horario']) . "'>";
        echo "<input type='hidden' name='servicos' value='" . $_POST['servico'] . "'>";
        echo "<br><select name='profissionaiid' id='profissionaiid' class='agendar' required><option value=''>Escolha um profissional</option> ";

        $valor = strtotime(date('H:i:s', $start));
        $endf = strtotime(date('H:i:s', $end));
        $numprof = 0;
        while ($row = $stmt->fetch()) {

            $sq = "SELECT agendamentos.agendamentoid ";
            $sq .= "FROM agendamentos, profissionais, empresas ";
            $sq .= "WHERE agendamentos.profissionaiid = profissionais.profissionaiid and agendamentos.empresaid = empresas.empresaid ";
            $sq .= "and (datainicio BETWEEN '" . date('Y-m-d H:i:s', $start) . "' and '" . date('Y-m-d H:i:s', $end) . "' or datafim BETWEEN '" . date('Y-m-d H:i:s', $start) . "' and '" . date('Y-m-d H:i:s', $end) . "') and agendamentos.profissionaiid = " . $row['profissionaiid'];

            $st = $auth_user->runQuery($sq);
            $st->execute();
            if ($st->rowCount() <= 0) {
                if($row['conta'] >= $min_conta){
                    //horario de almoço do profissional
                    if (!($valor >= strtotime($row['hralmocoini']) and $valor < strtotime($row['hralmocofim'])) && !($endf >= strtotime($row['hralmocoini']) and $endf < strtotime($row['hralmocofim']))) {
                        echo '<option value="' . $row['profissionaiid'] . '">' . $row['nome'] . '</option>';
                        $numprof++;
                    }
                }
            }

        }
        echo "</select><br><br>";
        if($numprof <= 0){
            echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="glyphicon glyphicon-remove"></i> Nenhum profissional para esta combinação data/horário/serviço. </div>';
        }
        echo "<input type='submit' id='btnagenda' value='Confirmar' class='btn btn-lg btn-primary'>";
        echo "</form>";
    }

/**
 * Agenda via Profissional
 */


    if($_POST['acao'] == 'P'){
     echo '<h3 class="text-success">Agenda de '.$_POST['nome'].'</h3><br>';
     echo "<form name='formagendamentop' id='formagendamentop' method='post'><div id='divvalidate'></div> ";
     echo "<input type='hidden' name='profissionaiid' id='profissionaiid' value='".$_POST['profissionaiid']."'>";
     echo 'Escolha um <b>serviço:</b><br><select name="servicos" id="servicosp" class="agendar muda" data-placeholder="Serviço(s)" multiple required><option value="">Serviço</option>';

        $stmt = $auth_user->runQuery("SELECT servicos.servicoid, servicos.nome FROM servicos, relservicosprofissionais WHERE servicos.servicoid = relservicosprofissionais.servicoid and relservicosprofissionais.profissionaiid = :profissionaiid and servicos.excluido = 'N' and servicos.empresaid = :empresaid order by servicos.nome ");
        $stmt->bindParam('empresaid',$_SESSION['empresaid']);
        $stmt->bindParam('profissionaiid',$_POST['profissionaiid']);
        $stmt->execute();
        while($row = $stmt->fetch()) {
            echo '<option value="'.$row['servicoid'].'">'.$row['nome'].'</option>';
        }

     echo '</select><br><br>Escholha uma <b>data:</b><br><input type="date" name="datainicio" id="datap" class="agendar muda" required><br><br>';

     echo '<div id="horarios"></div>';
     echo "<input type='submit' id='btnagenda' value='Confirmar' class='btn btn-lg btn-success' disabled>";
     echo "</form>";

    }

?>

<script>

    $('#servicosp').select2({width: '95%'});

    $('.muda').on('change', function () {

        if(($('#servicosp').select2("val") == '') || ($('#servicosp').select2("val") == null)){
            $('#divvalidate').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="glyphicon glyphicon-remove"></i> Escolha um serviço.</div>');
            return false;
        }
        else{
            if($('#datap').val() !== '') {
                $('#horarios').html('');
                var dados = 'profissionaiid=' + $('#profissionaiid').val() + '&data=' + $('#datap').val() + '&servicos=' + $('#servicosp').val();
                $('#divvalidate').html('<img src="../images/carregando.gif">');
                $.post('horarios.php', dados, function (json) {
                    $('#horarios').html(json);
                    $('#btnagenda').prop('disabled',false);
                    $('#divvalidate').html('');
                });
            }
        }
    });

    $('#formagendamentop').on('submit', function () {
        $('#btnagenda').prop('disabled',true);
        var inputs = $(this).serialize();
        var dados = 'classe=agendamentos&acao=register&valor=R&' + 'datainicio=' + $('#datap').val() +' '+ $('#horariop').val() + '&profissionaiid=' + $('#profissionaiid').val() + '&servicos=' + $('#servicosp').val();
        $.post('../acoes.php', dados, function (json) {
            var resposta = jQuery.parseJSON(json);
            $('#modalagendar').modal('hide');
            if (!resposta.retorno[0].retorno) {
                $('#divrespostaagendap').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="glyphicon glyphicon-remove"></i> Erro ao confirmar agendamento.<br>Erro original: ' + resposta.mensagem[0].mensagem + '  </div>');
            }
            else{
                $('#formagendamentop')[0].reset();
                $('#horarios').html('')
                $('#formagendar')[0].reset();
                $('#servicosp').select2("val", "");
                $('#divrespostaagendap').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="glyphicon glyphicon-ok"></i> Agendamento confirmado com sucesso.  </div>');
            }
            $('html,body').animate({scrollTop:$('#prof').offset().top},1000);
        });
        return false;
    });

    $('#formagendamento').on('submit', function () {
        $('#btnagenda').prop('disabled',true);
        var inputs = $(this).serialize();
        var dados = 'classe=agendamentos&acao=register&valor=R&' + inputs;
        $.post('../acoes.php', dados, function (json) {
            var resposta = jQuery.parseJSON(json);
            $('#modalagendar').modal('hide');
            if (!resposta.retorno[0].retorno) {
                $('#divrespostaagenda').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="glyphicon glyphicon-remove"></i> Erro ao confirmar agendamento.<br>Erro original: ' + resposta.mensagem[0].mensagem + '  </div>');
            }
            else{
                $('#formagendamento')[0].reset();
                $('#formagendar')[0].reset();
                $('#servico').select2("val", "");
                $('#divrespostaagenda').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="glyphicon glyphicon-ok"></i> Agendamento confirmado com sucesso.  </div>');
            }
        });
        $('#btnagenda').prop('disabled',false);
        return false;
    });
</script>
