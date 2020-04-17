<?php

require_once('dbconfig.php');

class servicos{

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
		    $preco = $valor["preco"];
		    $tempo = $valor["tempo"];
            $empresaid = $valor["empresaid"];
            $servicoid = $valor["servicoid"];
            $descricao = $valor["descricao"];


            if($nome=="")	{
                return "preencha o nome!";
            }
            else if($preco=="")	{
                return "preencha o preco!";
            }
            else {
                if ($servicoid <= 0) {
                    $stmt = $this->conn->prepare("INSERT INTO servicos(nome,preco,tempo,empresaid,descricao) VALUES(:nome, :preco, :tempo, :empresaid, :descricao)");
                    $stmt->bindparam(":nome", $nome);
                    $stmt->bindparam(":preco", $preco);
                    $stmt->bindparam(":tempo", $tempo);
                    $stmt->bindparam(":descricao", $descricao);
                    $stmt->bindparam(":empresaid", $empresaid);
                } else {
                    $stmt = $this->conn->prepare("UPDATE servicos SET nome = :nome, preco = :preco , tempo = :tempo , empresaid = :empresaid, descricao = :descricao  WHERE servicoid = :servicoid");
                    $stmt->bindparam(":nome", $nome);
                    $stmt->bindparam(":preco", $preco);
                    $stmt->bindparam(":tempo", $tempo);
                    $stmt->bindparam(":descricao", $descricao);
                    $stmt->bindparam(":empresaid", $empresaid);
                    $stmt->bindparam(":servicoid", $servicoid);
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
            $stmt = $this->conn->prepare("UPDATE servicos SET excluido = 'S' WHERE servicoid = :uid");
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