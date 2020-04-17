<?php

require_once('dbconfig.php');


class agendamentos{

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

    public function register($valor){
        try {
            $profissionaiid = $valor["profissionaiid"];
            $servicos = $valor["servicos"];
            $obsemp = '';
            $nomecliente = $_SESSION['nome'];
            $profausente = 'N';
            $datainicio = $valor['datainicio'];
            $empresaid = $_SESSION['empresaid'];
            $clienteid = $_SESSION['user_session'];
            $interno = 'N';
            $datafim = $valor['datafim'];

            $stmt = $this->conn->prepare("SELECT SUM(preco) preco, SUM(TIME_TO_SEC(tempo)) tempo FROM `servicos` WHERE servicoid in(" . $servicos . ")");
            $stmt->execute();
            $s = $stmt->fetch();

            $precototal = $s['preco'];
            $tempototal = $s['tempo'];
            if ($profausente == 'N'){
                $newdate = strtotime($datainicio) + $tempototal - 60;//retirando 1 min
                $datafim = date('Y-m-d H:i:s', $newdate);
            }


            if($nomecliente=="")	{
                return "preencha o nome!";
            }
            else if($servicos=="")	{
                return "selecione pelo menos 1 serviço!";
            }
            else {
                /**
                 * Validação do dia da semana
                 */
                $stmt = $this->conn->prepare("SELECT diassemana from empresas where empresaid = :empresaid ");
                $stmt->bindparam(":empresaid", $empresaid);
                $stmt->execute();
                $dias = $stmt->fetch();
                $dianaopermitido = true;
                $diassemana = explode(',',$dias['diassemana']);
                $dia = date('w',strtotime($datainicio))+1;
                for($i=0;$i<count($diassemana);$i++){
                    if($dia == $diassemana[$i]){
                        $dianaopermitido = false;
                        break;
                    }
                }

                if($dianaopermitido){
                    return " #SCD002 - este estabelecimento não funciona para o dia escolhido! Favor atualize a página e verifque.";
                }


                /**
                 * Validação das datas e horários
                 */
                $sql   = "SELECT count(agendamentos.agendamentoid) contador ";
                $sql  .= "FROM agendamentos, profissionais, empresas ";
                $sql  .= "WHERE agendamentos.profissionaiid = profissionais.profissionaiid and agendamentos.empresaid = empresas.empresaid ";
                $sql  .= "and ((datainicio BETWEEN '".$datainicio."' and '".$datafim."' or datafim BETWEEN '".$datainicio."' and '".$datafim."') or ";
                $sql  .= "(datainicio <= '".$datainicio."' and datafim >='".$datafim."')) ";
                $sql  .= "and agendamentos.profissionaiid = ".$profissionaiid." and agendamentos.empresaid = ".$empresaid." and agendamentos.cancelado = 'N'";
                $stmt = $this->runQuery($sql);
                $stmt->execute();

                $agend = $stmt->fetch();
                if($agend['contador'] > 0 ) {
                    return " #SCD001 - este horário já esta reservado! Favor atualize a página e verifque a agenda.";
                }

                $stmt = $this->conn->prepare("INSERT INTO agendamentos(profissionaiid,servicos,obsemp,nomecliente, profausente, datainicio, empresaid, clienteid, interno, precototal, tempototal, datafim ) VALUES(:profissionaiid, :servicos, :obsemp, :nomecliente, :profausente, :datainicio, :empresaid, :clienteid, :interno, :precototal, SEC_TO_TIME(:tempototal), :datafim)");
                $stmt->bindparam(":profissionaiid", $profissionaiid);
                $stmt->bindparam(":servicos", $servicos);
                $stmt->bindparam(":obsemp", $obsemp);
                $stmt->bindparam(":nomecliente", $nomecliente);
                $stmt->bindparam(":profausente", $profausente);
                $stmt->bindparam(":datainicio", $datainicio);
                $stmt->bindparam(":empresaid", $empresaid);
                $stmt->bindparam(":clienteid", $clienteid);
                $stmt->bindparam(":interno", $interno);
                $stmt->bindparam(":precototal", $precototal);
                $stmt->bindparam(":tempototal", $tempototal);
                $stmt->bindparam(":datafim", $datafim);

                $stmt->execute();
                return "0";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }


    public function deletar($valor){
        $uid = $valor["id"];
        try{

            $stmt = $this->conn->prepare("SELECT datainicio, hrscancelamento, nomefantasia, contato FROM agendamentos, empresas WHERE agendamentos.empresaid = empresas.empresaid AND agendamentoid = :agendamentoid ");
            $stmt->execute(array(':agendamentoid'=>$uid));
            $agendamento=$stmt->fetch(PDO::FETCH_ASSOC);
            $hrscancelamento = $agendamento["hrscancelamento"];
            $datacancel = date("Y-m-d H:i:s", strtotime('+'.$hrscancelamento.' hours'));

            if($datacancel <= $agendamento["datainicio"]){
                //pode cancelar
                $stmt = $this->conn->prepare("UPDATE agendamentos SET cancelado = 'S', datacancel = now(), obscancel = 'CANCELADO PELO CLIENTE' WHERE agendamentoid = :uid");
                $stmt->bindparam(":uid", $uid);
                $stmt->execute();
                return "0";
            }
            else{
                $msg = "Este estabelecimento tem como regra de cancelamento <b>".$agendamento["hrscancelamento"]." hora(s) de antecedência</b>.";
                $msg .= "<br>Portanto não foi possível realizar o cancelamento.";
                $msg .= "<br><br>Caso não possa comparecer entre em contato direto com o estabelecimento.<br>";
                $msg .= $agendamento["nomefantasia"]."<br>".$agendamento["contato"];

                return $msg;
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
	
	public function redirect($url){
		header("Location: $url");
	}

}
?>