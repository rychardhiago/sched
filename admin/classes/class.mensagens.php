<?php

require_once('dbconfig.php');

class mensagens{

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
		    $assunto = $valor["assunto"];
		    $destinatarioid = $valor["destinatarioid"];
		    $remetenteid =  $_SESSION['user_session'];
            $mensagem = $valor["mensagem"];

            if($assunto=="")	{
                return "preencha o assunto!";
            }
            else if($mensagem=="")	{
                return "preencha a mensagem!";
            }
            else {

                $stmt = $this->conn->prepare("INSERT INTO mensagens(destinatarioid,remetenteid,assunto,mensagem) VALUES(:destinatarioid, :remetenteid, :assunto, :mensagem)");
                $stmt->bindparam(":destinatarioid", $destinatarioid);
                $stmt->bindparam(":remetenteid", $remetenteid);
                $stmt->bindparam(":assunto", $assunto);
                $stmt->bindparam(":mensagem", $mensagem);

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
            $stmt = $this->conn->prepare("UPDATE mensagens SET excluido = 'S' WHERE mensagenid = :uid");
            $stmt->bindparam(":uid", $uid);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function ler($uid){
        try{
            $stmt = $this->conn->prepare("UPDATE mensagens SET dtleitura = now() WHERE mensagenid = :uid and dtleitura = '0000-00-00 00:00:00'");
            $stmt->bindparam(":uid", $uid);
            $stmt->execute();
            return stmt;
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