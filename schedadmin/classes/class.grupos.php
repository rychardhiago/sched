<?php

require_once('dbconfig.php');

class grupos{

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
		try{
		    $nomefantasia = $valor["nomefantasia"];
		    $cgc = $valor["cgc"];
            $grupoid = $valor["grupoid"];
            $bloqueio = $valor["bloqueio"];
            $motivobloqueio = $valor["motivobloqueio"];
            $razaosocial = $valor["razaosocial"];


            if($nomefantasia=="")	{
                return "preencha o nome fantasia!";
            }
            else if($cgc=="")	{
                return "preencha o cgc!";
            }
            else {
                if ($grupoid <= 0) {
                    $stmt = $this->conn->prepare("INSERT INTO grupos(razaosocial,nomefantasia,cgc,bloqueio,motivobloqueio) VALUES(:razaosocial,:nomefantasia,:cgc,:bloqueio,:motivobloqueio)");
                    $stmt->bindparam(":razaosocial",$razaosocial);
                    $stmt->bindparam(":nomefantasia",$nomefantasia);
                    $stmt->bindparam(":cgc",$cgc);
                    $stmt->bindparam(":bloqueio",$bloqueio);
                    $stmt->bindparam(":motivobloqueio",$motivobloqueio);
                } else {
                    $stmt = $this->conn->prepare("UPDATE grupos SET razaosocial = :razaosocial, nomefantasia = :nomefantasia, cgc = :cgc, bloqueio = :bloqueio, motivobloqueio = :motivobloqueio WHERE grupoid = :id");
                    $stmt->bindparam(":razaosocial",$razaosocial);
                    $stmt->bindparam(":nomefantasia",$nomefantasia);
                    $stmt->bindparam(":cgc",$cgc);
                    $stmt->bindparam(":bloqueio",$bloqueio);
                    $stmt->bindparam(":motivobloqueio",$motivobloqueio);
                    $stmt->bindparam(":id", $grupoid);
                }

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
            $stmt = $this->conn->prepare("UPDATE grupos SET excluido = 'S' WHERE grupoid = :uid");
            $stmt->bindparam(":uid", $uid);
            $stmt->execute();
            return $stmt;
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