<?php

require_once('dbconfig.php');


class contato{

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
		    $email = $valor["email"];
            $comoconheceu = $valor["comoconheceu"];
            $telefone = $valor["telefone"];
            $mensagem = $valor["mensagem"];

            if($nome=="")	{
                return "preencha o nome!";
            }
            else if($email=="")	{
                return "preencha o email!";
            }
            else {

                $stmt = $this->conn->prepare("INSERT INTO contatosite(nome,email,comoconheceu,mensagem,telefone) VALUES(:nome, :email, :comoconheceu, :mensagem, :telefone)");
                $stmt->bindparam(":nome", $nome);
                $stmt->bindparam(":email", $email);
                $stmt->bindparam(":comoconheceu", $comoconheceu);
                $stmt->bindparam(":mensagem", $mensagem);
                $stmt->bindparam(":telefone", $telefone);

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
            $stmt = $this->conn->prepare("UPDATE contatosite SET excluido = 'S' WHERE contatositeid = :uid");
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