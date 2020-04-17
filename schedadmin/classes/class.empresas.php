<?php

require_once('dbconfig.php');

class empresas{

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

            $empresaid = $valor["empresaid"];
            $grupoid = $valor["grupoid"];
            $razaosocial = $valor["razaosocial"];
            $nomefantasia = $valor["nomefantasia"];
            $cgc = $valor["cgc"];
            $hrscancelamento = $valor["hrscancelamento"];
            $hrsabertura = $valor["hrsabertura"];
            $hrsfechamento = $valor["hrsfechamento"];
            $diassemana = $valor["diassemana"];
            $bloqueioautomatico = $valor["bloqueioautomatico"];
            $numfaltas = $valor["numfaltas"];
            $latitude = $valor["latitude"];
            $longitude = $valor["longitude"];
            $matriz = $valor["matriz"];
            $endereco = $valor["endereco"];
            $cep = $valor["cep"];
            $cidadeid = $valor["cidadeid"];
            $bloqueio = $valor["bloqueio"];
            $motivobloqueio = $valor["motivobloqueio"];
            $tipocontrato = $valor["tipocontrato"];
            $usacomissao = $valor['usacomissao'];
            $apenasint = $valor['apenasint'];
            $intervalo = $valor['intervalo'];
            $sobre = $valor['sobre'];



            if($nomefantasia=="")	{
                return "preencha o nome fantasia!";
            }
            else if($grupoid=="")	{
                return "preencha o estado!";
            }
            else {
                if ($empresaid <= 0) {
                    $stmt = $this->conn->prepare("INSERT INTO empresas(grupoid, razaosocial, nomefantasia, cgc, bloqueio, hrscancelamento, hrsabertura, hrsfechamento, diassemana, bloqueioautomatico, numfaltas, latitude, longitude, matriz, endereco, cep, cidadeid, motivobloqueio, tipocontrato, usacomissao, intervalo, sobre, apenasint ) VALUES(:grupoid, :razaosocial, :nomefantasia, :cgc, :bloqueio, :hrscancelamento, :hrsabertura, :hrsfechamento, '".$diassemana."', :bloqueioautomatico, :numfaltas, :latitude, :longitude, :matriz, :endereco, :cep, :cidadeid, :motivobloqueio, :tipocontrato, :usacomissao, :intervalo, :sobre, :apenasint )");

                    $stmt->bindparam(":grupoid", $grupoid);
                    $stmt->bindparam(":razaosocial",$razaosocial);
                    $stmt->bindparam(":nomefantasia", $nomefantasia);
                    $stmt->bindparam(":cgc",$cgc);
                    $stmt->bindparam(":bloqueio",$bloqueio);
                    $stmt->bindparam(":hrscancelamento",$hrscancelamento);
                    $stmt->bindparam(":hrsabertura",$hrsabertura);
                    $stmt->bindparam(":hrsfechamento",$hrsfechamento);
                    $stmt->bindparam(":bloqueioautomatico",$bloqueioautomatico);
                    $stmt->bindparam(":numfaltas",$numfaltas);
                    $stmt->bindparam(":latitude",$latitude);
                    $stmt->bindparam(":longitude",$longitude);
                    $stmt->bindparam(":matriz",$matriz);
                    $stmt->bindparam(":endereco",$endereco);
                    $stmt->bindparam(":cep",$cep);
                    $stmt->bindparam(":cidadeid",$cidadeid);
                    $stmt->bindparam(":motivobloqueio",$motivobloqueio);
                    $stmt->bindparam(":tipocontrato",$tipocontrato);
                    $stmt->bindparam(":usacomissao",$usacomissao);
                    $stmt->bindparam(":intervalo",$intervalo);
                    $stmt->bindparam(":sobre",$sobre);
                    $stmt->bindparam(":apenasint",$apenasint);


                } else {
                    $stmt = $this->conn->prepare("UPDATE empresas SET grupoid = :grupoid, razaosocial = :razaosocial, nomefantasia = :nomefantasia, cgc = :cgc, bloqueio = :bloqueio, hrscancelamento = :hrscancelamento, hrsabertura = :hrsabertura, hrsfechamento = :hrsfechamento, diassemana = '".$diassemana."', bloqueioautomatico = :bloqueioautomatico, numfaltas = :numfaltas, latitude = :latitude, longitude = :longitude, matriz = :matriz, endereco = :endereco, cep = :cep, cidadeid = :cidadeid, motivobloqueio = :motivobloqueio, tipocontrato  = :tipocontrato, usacomissao = :usacomissao, intervalo = :intervalo, sobre = :sobre, apenasint = :apenasint  WHERE empresaid = :id");
                    $stmt->bindparam(":id",$empresaid);
                    $stmt->bindparam(":nomefantasia", $nomefantasia);
                    $stmt->bindparam(":grupoid", $grupoid);
                    $stmt->bindparam(":razaosocial",$razaosocial);
                    $stmt->bindparam(":cgc",$cgc);
                    $stmt->bindparam(":bloqueio",$bloqueio);
                    $stmt->bindparam(":hrscancelamento",$hrscancelamento);
                    $stmt->bindparam(":hrsabertura",$hrsabertura);
                    $stmt->bindparam(":hrsfechamento",$hrsfechamento);
                    $stmt->bindparam(":bloqueioautomatico",$bloqueioautomatico);
                    $stmt->bindparam(":numfaltas",$numfaltas);
                    $stmt->bindparam(":latitude",$latitude);
                    $stmt->bindparam(":longitude",$longitude);
                    $stmt->bindparam(":matriz",$matriz);
                    $stmt->bindparam(":endereco",$endereco);
                    $stmt->bindparam(":cep",$cep);
                    $stmt->bindparam(":cidadeid",$cidadeid);
                    $stmt->bindparam(":motivobloqueio",$motivobloqueio);
                    $stmt->bindparam(":tipocontrato",$tipocontrato);
                    $stmt->bindparam(":usacomissao",$usacomissao);
                    $stmt->bindparam(":intervalo",$intervalo);
                    $stmt->bindparam(":sobre",$sobre);
                    $stmt->bindparam(":apenasint",$apenasint);
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
            $stmt = $this->conn->prepare("UPDATE empresas SET excluido = 'S' WHERE empresaid = :uid");
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