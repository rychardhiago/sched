<?php

    date_default_timezone_set('America/Sao_Paulo');
    require_once("../session.php");
    date_default_timezone_set('America/Sao_Paulo');

    $ini = $_POST['data'] . ' 00:00:00';
    $start = strtotime($ini);

    $fim = $_POST['data'] . ' 23:59:59';
    $end = strtotime($fim);

    $stmt = $auth_user->runQuery("SELECT SUM(preco) preco, SUM(TIME_TO_SEC(tempo)) tempo FROM `servicos` WHERE servicoid in(" . $_POST['servicos'] . ")");
    $stmt->execute();
    $s = $stmt->fetch();
    $tempototal = $s['tempo'];
    $endservico = $tempototal - 60;


    $stm = $auth_user->runQuery("SELECT hralmocoini, hralmocofim FROM `profissionais` WHERE profissionaiid in(" . $_POST['profissionaiid'] . ")");
    $stm->execute();
    $stq = $stm->fetch();
    $hralmocoini = strtotime($stq['hralmocoini']);
    $hralmocofim = strtotime($stq['hralmocofim']);

    $sq = "SELECT agendamentos.agendamentoid, agendamentos.datainicio, agendamentos.datafim ";
    $sq .= "FROM agendamentos, profissionais, empresas ";
    $sq .= "WHERE agendamentos.profissionaiid = profissionais.profissionaiid and agendamentos.empresaid = empresas.empresaid ";
    $sq .= "and (datainicio BETWEEN '" . date('Y-m-d H:i:s', $start) . "' and '" . date('Y-m-d H:i:s', $end) . "' or datafim BETWEEN '" . date('Y-m-d H:i:s', $start) . "' and '" . date('Y-m-d H:i:s', $end) . "') and agendamentos.profissionaiid = " . $_POST['profissionaiid'];
    $st = $auth_user->runQuery($sq);
    $st->execute();

    $i = 0;
    while($row = $st->fetch()){
        $horarios[$i][1] = strtotime(date('H:i:s',strtotime($row['datainicio'])));
        $horarios[$i][2] = strtotime(date('H:i:s',strtotime($row['datafim'])));
        $i++;
    }


    $stmt = $auth_user->runQuery("SELECT hrsabertura, hrsfechamento , TIME_TO_SEC(intervalo) intervalo FROM empresas WHERE excluido = 'N' and empresaid = :empresaid ");
    $stmt->bindParam('empresaid',$_SESSION['empresaid']);
    $stmt->execute();
    $row = $stmt->fetch();

    echo 'Escolha um <b>horário:</b><br><select name="horario" id="horariop" class="agendar" required>';


    $hora = 0;
    $horainicial = $row['hrsabertura'];
    $horafechamento = strtotime($row['hrsfechamento']);
    $contador = 0;

    if(!estaEntre(strtotime($row['hrsabertura']),$horarios, $endservico, $horafechamento, $hralmocoini, $hralmocofim)) {
        echo '<option value="' . $row['hrsabertura'] . '">' . $row['hrsabertura'] . '</option>';
    }

    while((strtotime($horainicial) + $row['intervalo']) < strtotime($row['hrsfechamento'])){
        $newdate = strtotime($horainicial) + $row['intervalo'];
        $datafim = date('H:i:s', $newdate);
        if(estaEntre($newdate,$horarios, $endservico,$horafechamento, $hralmocoini, $hralmocofim)) {
            $hora = $newdate;
            $horainicial = $datafim;
            continue;
        }
        else{
            echo '<option value="' . $datafim . '">' .$datafim. '</option>';
            $contador++;
        }
        $hora = $newdate;
        $horainicial = $datafim;
    }
    if($contador <= 0){
        echo '<option value="">Nenhum horário disponível para esta combinação serviço/data/profissional</option>';
    }
    echo '</select><br><br>';


    function estaEntre($valor,$horarios,$endservico,$horafechamento,$hralmocoini,$hralmocofim){
       $endf = $valor + $endservico;
       $hoje = date('Y-m-d');
       $agora = date('H:i:s');

       //horarios ja marcados
       for($i=0;$i<count($horarios);$i++){
           if($valor >= $horarios[$i][1] and $valor <= $horarios[$i][2]){
               return true;
           }
           if($endf >= $horarios[$i][1] and $endf <= $horarios[$i][2]){
               return true;
           }

           if($horarios[$i][1] >= $valor and $horarios[$i][1] <= $endf){
               return true;
           }
           if($horarios[$i][2] >= $valor and $horarios[$i][2] <= $endf){
               return true;
           }

       }

       //validando a hora para a data de hoje
       if ($_POST['data'] == $hoje) {
          if ($valor < strtotime($agora)){
              return true;
          }
       }

       //horario de fechamento
       if($valor >= $horafechamento){
           return true;
       }
       if($endf > $horafechamento){
           return true;
       }

       //horario de almoço do profissional
       if($valor >= $hralmocoini and $valor < $hralmocofim){
          return true;
       }
       if($endf >= $hralmocoini and $endf < $hralmocofim){
          return true;
       }

       return false;
    }

?>
