<?php

require_once('dbconfig.php');

class profissionais{

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
		    $cgc = $valor["cgc"];
		    $email = $valor["email"];
            $empresaid = $valor["empresaid"];
            $senha = $valor["senha"];
            $numsessoes = $valor["numsessoes"];
            $bloqueado = $valor["bloqueado"];
            $adminempresa = $valor["adminempresa"];
            $admingrupo = $valor["admingrupo"];
            $profissionaiid = $valor["profissionaiid"];
            $descricao = $valor["descricao"];

            $new_password = password_hash($senha, PASSWORD_DEFAULT);

            if($nome=="")	{
                return "preencha o nome!";
            }
            else if($cgc=="")	{
                return "preencha o cgc!";
            }
            else {
                if ($profissionaiid <= 0) {
                    $stmt = $this->conn->prepare("INSERT INTO profissionais(nome,cgc,email,empresaid,senha,numsessoes,bloqueado,adminempresa,admingrupo,descricao) VALUES(:nome, :cgc, :email, :empresaid, :senha, :numsessoes, :bloqueado, :adminempresa, :admingrupo, :descricao)");
                    $stmt->bindparam(":nome", $nome);
                    $stmt->bindparam(":cgc", $cgc);
                    $stmt->bindparam(":email", $email);
                    $stmt->bindparam(":empresaid", $empresaid);
                    $stmt->bindparam(":senha", $new_password);
                    $stmt->bindparam(":numsessoes", $numsessoes);
                    $stmt->bindparam(":bloqueado", $bloqueado);
                    $stmt->bindparam(":adminempresa", $adminempresa);
                    $stmt->bindparam(":admingrupo", $admingrupo);
                    $stmt->bindparam(":descricao", $descricao);

                } else {
                    $stmt = $this->conn->prepare("UPDATE profissionais SET nome = :nome, cgc = :cgc , email = :email , empresaid = :empresaid, senha = :senha, numsessoes = :numsessoes, bloqueado = :bloqueado, adminempresa = :adminempresa, admingrupo = :admingrupo, descricao = :descricao  WHERE profissionaiid = :profissionaiid");
                    $stmt->bindparam(":nome", $nome);
                    $stmt->bindparam(":cgc", $cgc);
                    $stmt->bindparam(":email", $email);
                    $stmt->bindparam(":empresaid", $empresaid);
                    $stmt->bindparam(":senha", $new_password);
                    $stmt->bindparam(":numsessoes", $numsessoes);
                    $stmt->bindparam(":bloqueado", $bloqueado);
                    $stmt->bindparam(":adminempresa", $adminempresa);
                    $stmt->bindparam(":admingrupo", $admingrupo);
                    $stmt->bindparam(":profissionaiid", $profissionaiid);
                    $stmt->bindparam(":descricao", $descricao);
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
            $stmt = $this->conn->prepare("UPDATE profissionais SET excluido = 'S' WHERE profissionaiid = :uid");
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