<?php

require_once('dbconfig.php');

class pais{

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
		    $sigla = $valor["sigla"];
            $paisid = $valor["paisid"];


            if($nome=="")	{
                return "preencha o nome!";
            }
            else if($sigla=="")	{
                return "preencha a sigla!";
            }
            else {
                if ($paisid <= 0) {
                    $stmt = $this->conn->prepare("INSERT INTO pais(nome,sigla) VALUES(:nome, :sigla)");
                    $stmt->bindparam(":nome", $nome);
                    $stmt->bindparam(":sigla", $sigla);
                } else {
                    $stmt = $this->conn->prepare("UPDATE pais SET nome = :nome, sigla = :sigla WHERE paisid = :id");
                    $stmt->bindparam(":nome", $nome);
                    $stmt->bindparam(":sigla", $sigla);
                    $stmt->bindparam(":id", $paisid);
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
            $stmt = $this->conn->prepare("UPDATE pais SET excluido = 'S' WHERE paisid = :uid");
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