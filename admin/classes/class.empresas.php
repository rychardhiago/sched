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
	
	public function redirect($url){
		header("Location: $url");
	}

    public function register($valor){
        try{

            $empresaid = $valor["empresaid"];

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
            $usacomissao = $valor['usacomissao'];
            $sobre = $valor['sobre'];
            $intervalo = $valor['intervalo'];



            if($diassemana=="")	{
                return "preencha os dias da semana!";
            }
            else if($cidadeid=="")	{
                return "preencha a cidade!";
            }
            else {
                $stmt = $this->conn->prepare("UPDATE empresas SET hrscancelamento = :hrscancelamento, hrsabertura = :hrsabertura, hrsfechamento = :hrsfechamento, diassemana = '".$diassemana."', bloqueioautomatico = :bloqueioautomatico, numfaltas = :numfaltas, latitude = :latitude, longitude = :longitude, matriz = :matriz, endereco = :endereco, cep = :cep, cidadeid = :cidadeid, usacomissao = :usacomissao, sobre = :sobre, intervalo = :intervalo  WHERE empresaid = :id");
                $stmt->bindparam(":id",$empresaid);

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

                $stmt->bindparam(":usacomissao",$usacomissao);
                $stmt->bindparam(":sobre",$sobre);
                $stmt->bindparam(":intervalo",$intervalo);

                $stmt->execute();
                return "0";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

}
?>