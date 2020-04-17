<?php
    /**
     * Created by PhpStorm.
     * User: RychardSilva
     * Date: 08/08/2017
     * Time: 11:13
     */
    require_once("session.php");
    require_once('classes/class.agendamentos.php');

    $agendamento = new agendamentos();

    $sq = "select * from servicos where excluido = 'N' and empresaid =".$_SESSION['empresaid'];
    $stm = $agendamento->runQuery($sq);
    $stm->execute();
    $i=0;
    $retorno = "";
    $profissional = $_SESSION['user_session'];

    if((isset($_GET['id'])) and ($_GET['id'] > 0) and ($_GET['id'] != "undefined")){
        $profissional = $_GET['id'];
    }
    while($servicos = $stm->fetch()) {

        $sql = "select * from relservicosprofissionais where servicoid = ".$servicos['servicoid']." and profissionaiid =".$profissional;
        $stmt = $agendamento->runQuery($sql);
        $stmt->execute();
        $relacao = $stmt->fetch();

        $retorno .= '<tr>';
        $retorno .= '<td>'.$servicos['servicoid'].'</td>';
        $retorno .= '<td>'.$servicos['nome'].'</td>';
        if($_SESSION['usacomissao'] == 'S'){
            $retorno .= '<td><input type="number" step="any" id="valorcomissao'.$servicos['servicoid'].'" name="valorcomissao" class="form-control" placeholder="Valor da comissão"';
            if($relacao['valorcomissao'] != ''){ $retorno .= ' value="'.$relacao['valorcomissao'].'"'; }
            $retorno .= '></td>';
            $retorno .= '<td><select name="tipocomissao" id="tipocomissao'.$servicos['servicoid'].'" class="form-control"><option value="V"';
            if($relacao['tipocomissao'] == 'V'){ $retorno .= ' selected'; }
            $retorno .= '>Valor</option><option value="P"';
            if($relacao['tipocomissao'] == 'P'){ $retorno .= ' selected'; }
            $retorno .= '>Percentual</option></select></td>';
        }

        $retorno .= '<td><div class="onoffswitch"><input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" alt="'.$servicos['servicoid'].'" name="seleciona'.$servicos['servicoid'].'" id="seleciona'.$servicos['servicoid'].'"';

        if($relacao['servicoid'] != ''){ $retorno .= ' checked '; }
        $retorno .= '/>';

        $retorno .= '<label class="onoffswitch-label" for="seleciona'.$servicos['servicoid'].'">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                     </div>
                    </td></tr>';
        $i++;
    }
    echo $retorno;
    ?>




