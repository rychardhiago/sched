<?php

require_once('dbconfig.php');

class relservicosprofissionais{

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
	
	public function redirect($url){
		header("Location: $url");
	}

    public function register($valor){
        try {
            $profissionaiid = $valor["profissionaiid"];
            $servicoid = $valor["servicoid"];
            $tipocomissao = $valor['tipocomissao'];
            $valorcomissao = $valor['valorcomissao'];


            if($profissionaiid=="")	{
                return "preencha o profissional!";
            }
            else if($servicoid=="")	{
                return "preencha o serviço!";
            }
            else {

                $stmt = $this->conn->prepare("INSERT INTO relservicosprofissionais(profissionaiid,servicoid,tipocomissao,valorcomissao) VALUES(:profissionaiid, :servicoid, :tipocomissao, :valorcomissao)");
                $stmt->bindparam(":profissionaiid", $profissionaiid);
                $stmt->bindparam(":servicoid", $servicoid);
                $stmt->bindparam(":tipocomissao", $tipocomissao);
                $stmt->bindparam(":valorcomissao", $valorcomissao);

                $stmt->execute();
                return "0";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function deletar($uid){
        try{
            $stmt = $this->conn->prepare("DELETE FROM relservicosprofissionais WHERE profissionaiid = :uid");
            $stmt->bindparam(":uid", $uid);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

}
?>