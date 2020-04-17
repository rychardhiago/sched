<?php

require_once('dbconfig.php');

class chamados{

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
		    $profissionaiid = $_SESSION['user_session'];
            $mensagem = $valor["mensagem"];
            $tipo = $valor["tipo"];
            $situacao = "A";
            $chamadoid = $valor["chamadoid"];
            $addmensagem = $valor['addmensagem'];
            $identificador = date("dmY_Hi");

            if($chamadoid > 0){
                $stmt = $this->conn->prepare("UPDATE chamados set mensagem = CONCAT(mensagem,:mensagem) WHERE chamadoid = :chamadoid");
                $stmt->bindparam(":chamadoid", $chamadoid);

                if($addmensagem != "") {
                    $newmensagem = '
                     ------------------------------------------------ 
                     ' . $addmensagem;
                }
                else {
                    $newmensagem = ".";
                }

                $stmt->bindparam(":mensagem", $newmensagem);

            }
            else {
                if ($assunto == "") {
                    return "preencha o assunto!";
                }
                else if ($mensagem == "") {
                    return "preencha a mensagem!";
                }
                else {
                    $stmt = $this->conn->prepare("INSERT INTO chamados(assunto,profissionaiid,tipo,mensagem,situacao,identificador) VALUES(:assunto, :profissionaiid, :tipo, :mensagem, :situacao, :identificador)");
                    $stmt->bindparam(":assunto", $assunto);
                    $stmt->bindparam(":profissionaiid", $profissionaiid);
                    $stmt->bindparam(":tipo", $tipo);
                    $stmt->bindparam(":mensagem", $mensagem);
                    $stmt->bindparam(":situacao", $situacao);
                    $stmt->bindparam(":identificador", $identificador);
                }
            }
            $stmt->execute();
            return "0";
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}				
	}

    public function deletar($uid){
        try{
            $stmt = $this->conn->prepare("UPDATE chamados SET excluido = 'S' WHERE chamadoid = :uid");
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