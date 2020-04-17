<?php

require_once('dbconfig.php');

class estados{

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
		    $nome = $valor["nome"];
		    $uf = $valor["uf"];
            $paisid = $valor["paisid"];
            $estadoid = $valor["estadoid"];


            if($nome=="")	{
                return "preencha o nome!";
            }
            else if($uf=="")	{
                return "preencha a uf!";
            }
            else {
                if ($estadoid <= 0) {
                    $stmt = $this->conn->prepare("INSERT INTO estados(nome,uf,paisid) VALUES(:nome, :uf, :paisid)");
                    $stmt->bindparam(":nome", $nome);
                    $stmt->bindparam(":uf", $uf);
                    $stmt->bindparam(":paisid", $paisid);
                } else {
                    $stmt = $this->conn->prepare("UPDATE estados SET nome = :nome, uf = :uf , paisid = :paisid WHERE estadoid = :estadoid");
                    $stmt->bindparam(":nome", $nome);
                    $stmt->bindparam(":uf", $uf);
                    $stmt->bindparam(":paisid", $paisid);
                    $stmt->bindparam(":estadoid", $estadoid);
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
            $stmt = $this->conn->prepare("UPDATE estados SET excluido = 'S' WHERE estadoid = :uid");
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