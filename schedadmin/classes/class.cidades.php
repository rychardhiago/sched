<?php

require_once('dbconfig.php');

class cidades{

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
		    $cidadeid = $valor["cidadeid"];
            $estadoid = $valor["estadoid"];


            if($nome=="")	{
                return "preencha o nome!";
            }
            else if($estadoid=="")	{
                return "preencha a sigla!";
            }
            else {
                if ($cidadeid <= 0) {
                    $stmt = $this->conn->prepare("INSERT INTO cidades(nome,estadoid) VALUES(:nome, :estadoid)");
                    $stmt->bindparam(":nome", $nome);
                    $stmt->bindparam(":estadoid", $estadoid);
                } else {
                    $stmt = $this->conn->prepare("UPDATE cidades SET nome = :nome, estadoid = :estadoid WHERE cidadeid = :id");
                    $stmt->bindparam(":nome", $nome);
                    $stmt->bindparam(":estadoid", $estadoid);
                    $stmt->bindparam(":id", $cidadeid);
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
            $stmt = $this->conn->prepare("UPDATE cidades SET excluido = 'S' WHERE cidadeid = :uid");
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