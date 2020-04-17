<?php

require_once('dbconfig.php');
require 'PHPMailerAutoload.php';

class clientes{

	private $conn;
	
	public function __construct(){
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
       }
	
	public function runQuery($sql){
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	public function gerarToken($tamanho = 38, $maiusculas = true, $numeros = true, $simbolos = false) {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$';
        $retorno = '';
        $caracteres = '';


        $caracteres .= $lmin;
        if ($maiusculas) $caracteres .= $lmai;
        if ($numeros) $caracteres .= $num;
        if ($simbolos) $caracteres .= $simb;

        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand-1];
        }

        $stmt = $this->conn->prepare("SELECT count(*) as contador FROM clientes WHERE hash like :hash AND clientes.excluido = 'N'");
        $stmt->execute(array(':hash'=>$retorno));
        $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
        if($userRow['contador'] > 0){
            return gerarToken();
        }
        else{
            return $retorno;
        }

    }

    public function cabecalho_email(){
        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.schedapp.com.br';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'sched@schedapp.com.br';                 // SMTP username
        $mail->Password = 'sched@2017';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
        $mail->From = 'sched@schedapp.com.br';
        $mail->FromName = 'SchedApp';
        $mail->isHTML(true);                                  // Set email format to HTML
        return $mail;
    }

    public function enviar_email_reset($email,$hash, $nome, $codigo){
        $mail = $this->cabecalho_email();
        $mail->addAddress($email);     // Add a recipient
        $mail->Subject = 'SCHED - Reset sua senha ';

        $mail->Body    = utf8_decode('
                                                       
                            <body>
                            <head>
                            </head>
                            
                            <div class="test"></div>
                                <div style="min-height: 50px; background: #00a4e4; color: #00a4e4;">.</div>
                                <div style="padding: 10px;">
                                    <div style="color: #FDA30E;">
                                        <img src="http://schedapp.com.br/images/clinic.png" style="width: 72px; height: 72px; display: inline-block; float: left; line-height: 72px;">
                                        <h1><a style="color: #FDA30E; line-height: 72px; text-decoration: none;" href="http://schedapp.com.br/"><i></i>SCH<span>E</span>D</a></h1>
                                    </div>
                                    <div class="" style="padding: 20px; color: #777;">');

        $mail->Body    .= utf8_decode('Olá, '.$nome.'<br>Em '.date('d/m/Y H:i:s').' foi requisitado o reset de sua senha em nossa plataforma. Se foi você e deseja realmente mudar sua senha, basta clicar no link abaixo:');

        $mail->Body    .= utf8_decode('<br><br> <a style="color: #fff; background-color: #ec971f; border-color: #d58512; display: inline-block; padding: 6px 12px; margin-bottom: 0; font-size: 14px; font-weight: normal; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; text-decoration: none;" href="http://schedapp.com.br/index.php?acao=reset&c='.$codigo.'&e='.$email.'&t='.$hash.'">Reset sua senha</a>');
        $mail->Body    .= utf8_decode('<br><br>Caso não tenha sido você, desconsidere este email.');
        $mail->Body    .= utf8_decode('<br><br>Att,<br>Equipe SchedApp.');

        $mail->Body    .= utf8_decode('</div>
                                        </div>
                                        <div style="min-height: 70px; background: #00a4e4; color: #fff;">
        <div style=" float: left; width: 50%; color: #fff;">
            <ul style="display: block; list-style-type: disc;">
                <li style="color: #fff; list-style-type: none; font-size: 14px; display: inline-block; border-left: 1px solid #7ECCEA; padding: 16px 21px; text-decoration: none;"><a>+55 62 984258554</a></li>
                <li style="color: #fff; list-style-type: none; font-size: 14px; display: inline-block; border-left: 1px solid #7ECCEA; padding: 16px 21px; text-decoration: none;"><a>sched@schedapp.com.br</a></li>
            </ul>
        </div>
    </div></body>');


        if(!$mail->send()) {
            return 'Mailer Error: ' . $mail->ErrorInfo;
        }
        else{
            return "0";
        }
    }

    public function enviar_email($email,$hash){
        $mail = $this->cabecalho_email();
        $mail->addAddress($email);     // Add a recipient
        $mail->Subject = 'Bem vindo ao SCHED - Confirme sua conta ';

        $mail->Body    = utf8_decode('
                                                       
                            <body>
                            <head>
                            </head>
                            
                            <div class="test"></div>
                                <div style="min-height: 50px; background: #00a4e4; color: #00a4e4;">.</div>
                                <div style="padding: 10px;">
                                    <div style="color: #FDA30E;">
                                        <img src="http://schedapp.com.br/images/clinic.png" style="width: 72px; height: 72px; display: inline-block; float: left; line-height: 72px;">
                                        <h1><a style="color: #FDA30E; line-height: 72px; text-decoration: none;" href="http://schedapp.com.br/"><i></i>SCH<span>E</span>D</a></h1>
                                    </div>
                                    <div class="" style="padding: 20px; color: #777;">');

        $mail->Body    .= utf8_decode('Em '.date('d/m/Y H:i:s').' foi criado um cadastro em nossa plataforma com este email. Se foi você e deseja confimar sua conta, basta clicar no link abaixo:');

        $mail->Body    .= utf8_decode('<br><br> <a style="color: #fff; background-color: #ec971f; border-color: #d58512; display: inline-block; padding: 6px 12px; margin-bottom: 0; font-size: 14px; font-weight: normal; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; text-decoration: none;" href="http://schedapp.com.br/index.php?e='.$email.'&t='.$hash.'">Confirmar conta</a>');
        $mail->Body    .= utf8_decode('<br><br>Caso não tenha sido você, desconsidere este email.');
        $mail->Body    .= utf8_decode('<br><br>Att,<br>Equipe SchedApp.');

        $mail->Body    .= utf8_decode('</div>
                                        </div>
                                        <div style="min-height: 70px; background: #00a4e4; color: #fff;">
        <div style=" float: left; width: 50%; color: #fff;">
            <ul style="display: block; list-style-type: disc;">
                <li style="color: #fff; list-style-type: none; font-size: 14px; display: inline-block; border-left: 1px solid #7ECCEA; padding: 16px 21px; text-decoration: none;"><a>+55 62 984258554</a></li>
                <li style="color: #fff; list-style-type: none; font-size: 14px; display: inline-block; border-left: 1px solid #7ECCEA; padding: 16px 21px; text-decoration: none;"><a>sched@schedapp.com.br</a></li>
            </ul>
        </div>
    </div></body>');


        if(!$mail->send()) {
            return 'Mailer Error: ' . $mail->ErrorInfo;
        }
        else{
            return "0";
        }
    }

    public function editar($valor){
        try{
            $nome = $valor["nome"];
            $email = $valor["email"];
            $senha = $valor["senha"];
            $endereco = $valor["endereco"];
            $telefone = $valor["telefone"];
            $clienteid = $valor["clienteid"];

            $new_password = password_hash($senha, PASSWORD_DEFAULT);

            if($nome=="")	{
                return "preencha o nome!";
            }
            else if($email=="")	{
                return "preencha o email!";
            }
            else {
                $stmt = $this->conn->prepare("SELECT clienteid, nome, email FROM clientes WHERE email=:email AND clientes.excluido = 'N' AND clientes.clienteid <> :clienteid");
                $stmt->bindparam(":email", $email);
                $stmt->bindparam(":clienteid", $clienteid);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    return "Este email já está cadastrado na nossa base de dados.";
                }

                $stmt = $this->conn->prepare("UPDATE clientes SET hash = '', senha = :senha, nome = :nome, email = :email, endereco = :endereco, telefone = :telefone  WHERE clienteid = :clienteid");
                $stmt->bindparam(":nome", $nome);
                $stmt->bindparam(":email", $email);
                $stmt->bindparam(":endereco", $endereco);
                $stmt->bindparam(":senha", $new_password);
                $stmt->bindparam(":telefone", $telefone);
                $stmt->bindparam(":clienteid", $clienteid);
                $stmt->execute();
                return "0";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
	
	public function register($valor){
		try{
		    $nome = $valor["nome"];
		    $email = $valor["emailr"];
            $senha = $valor["senha"];
            $endereco = $valor["endereco"];
            $telefone = $valor["telefone"];
            $clienteid = $valor["clienteid"];
            $dtnascimento = $valor["dtnascimento"];
            $hash = $this->gerarToken();

            $new_password = password_hash($senha, PASSWORD_DEFAULT);

            if($nome=="")	{
                return "preencha o nome!";
            }
            else if($email=="")	{
                return "preencha o email!";
            }
            else {
                if ($clienteid <= 0) {
 
                    $stmt = $this->conn->prepare("SELECT clienteid, nome, email FROM clientes WHERE email=:umail AND clientes.excluido = 'N' ");
                    $stmt->execute(array(':umail'=>$email));
                    if($stmt->rowCount() > 0){
                      return "Este email já está cadastrado na nossa base de dados.";
                    }


                    $stmt = $this->conn->prepare("INSERT INTO clientes(nome,email,endereco,senha,telefone,hash,dtnascimento) VALUES(:nome, :email, :endereco, :senha, :telefone, :hash, :dtnascimento)");
                    $stmt->bindparam(":nome", $nome);
                    $stmt->bindparam(":email", $email);
                    $stmt->bindparam(":endereco", $endereco);
                    $stmt->bindparam(":senha", $new_password);
                    $stmt->bindparam(":telefone", $telefone);
                    $stmt->bindparam(":hash", $hash);
                    $stmt->bindparam(":dtnascimento", $dtnascimento);

                    $this->enviar_email($email,$hash);

                } else {
                    $stmt = $this->conn->prepare("UPDATE clientes SET senha = :senha, hash = '', confirmada = 'S' WHERE clienteid = :clienteid");
                    $stmt->bindparam(":senha", $new_password);
                    $stmt->bindparam(":clienteid", $clienteid);
                }

                $stmt->execute();
                return "0";
            }
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}				
	}

    public function reset($valor){
        try{
            $email = $valor["emailres"];
            $hash = $this->gerarToken();
            if($email=="")	{
                return "preencha o email!";
            }
            else {
                $stmt = $this->conn->prepare("SELECT clienteid, nome, email FROM clientes WHERE email=:umail AND clientes.excluido = 'N' ");
                $stmt->execute(array(':umail'=>$email));
                $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() <= 0){
                    return "Este email não está cadastrado na nossa base de dados.";
                }
                $stmt = $this->conn->prepare("UPDATE clientes SET hash = :hash WHERE clienteid = :clienteid");
                $stmt->bindparam(":hash", $hash);
                $stmt->bindparam(":clienteid", $userRow['clienteid']);
                $stmt->execute();
                $this->enviar_email_reset($email,$hash,$userRow['nome'],$userRow['clienteid']);
                return "0";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function existe($valor){
        try{
            $email = $valor["email"];
            $hash = $valor["token"];
            $clienteid = $valor["cod"];
            if($email=="")	{
                return "preencha o email!";
            }
            else {
                $stmt = $this->conn->prepare("SELECT clienteid FROM clientes WHERE email=:umail AND hash=:uhash AND clienteid = :clienteid AND clientes.excluido = 'N' ");
                $stmt->bindparam(':umail',$email);
                $stmt->bindparam(':uhash',$hash);
                $stmt->bindparam(':clienteid',$clienteid);
                $stmt->execute();
                if($stmt->rowCount() <= 0){
                    return "Este email não está cadastrado na nossa base de dados.";
                }
                return "0";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function deletar($uid){
        try{
            $stmt = $this->conn->prepare("UPDATE clientes SET excluido = 'S' WHERE clienteid = :uid");
            $stmt->bindparam(":uid", $uid);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function ultimos($ultimos){
        try{
            $stmt = $this->conn->prepare("UPDATE clientes SET ultimos = :ultimos WHERE clienteid = :uid");
            if(strlen($_SESSION['ultimos']) > 9){
                $ult = $_SESSION['ultimos'] . ',' . $ultimos;
                $ultimo = substr($ult, (strlen($ultimos) + 1), 11);
            }
            else{
                $ultimo = $_SESSION['ultimos'].','.$ultimos;
            }
            $stmt->bindparam(":ultimos", $ultimo);
            $stmt->bindparam(":uid", $_SESSION['user_session']);
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

    public function doLogin($valor){
        $umail = $valor["email"];
        $upass = $valor["senhal"];

        try{
            $stmt = $this->conn->prepare("SELECT clienteid, nome, email, senha, ultimos FROM clientes WHERE email=:umail AND clientes.excluido = 'N' AND clientes.confirmada = 'S'");
            $stmt->execute(array(':umail'=>$umail));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() == 1){
                if(password_verify($upass, $userRow['senha'])){
                    $_SESSION['user_session'] = $userRow['clienteid'];
                    $_SESSION['nome'] = $userRow['nome'];
                    $_SESSION['email'] = $userRow['email'];
                    $_SESSION['data'] = date("d/m/Y H:i:s");
                    $_SESSION['ultimos'] = $userRow['ultimos'];
                    return $userRow['nome'];
                }
                else{
                    return "1";
                }
            }
            else{
                return "1";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function confirmar($valor){
        $umail = $valor["email"];
        $uhash = $valor["token"];

        try{
            $stmt = $this->conn->prepare("SELECT clienteid, nome, email FROM clientes WHERE email=:umail AND hash=:uhash AND clientes.excluido = 'N'");
            $stmt->bindparam(":umail", $umail);
            $stmt->bindparam(":uhash", $uhash);
            $stmt->execute();
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() == 1){
                $stmt = $this->conn->prepare("UPDATE clientes SET confirmada = 'S', hash = '' WHERE clienteid = :uid");
                $stmt->bindparam(":uid", $userRow['clienteid']);
                $stmt->execute();
                return "0";
            }
            else{
                return "1";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function is_loggedin(){
        if(isset($_SESSION['user_session'])) {
            return true;
        }
    }

    public function doLogout(){
        session_destroy();
        unset($_SESSION['user_session']);
        unset($_SESSION['nome']);
        unset($_SESSION['email']);
        unset($_SESSION['data']);
        unset($_SESSION['ultimos']);
        return true;
    }

    public function contar($valor){
        try{
            $exc = 'excluido';
            if($valor == 'agendamentos'){
             $exc = 'cancelado';
            }
            $stmt = $this->conn->prepare("SELECT count(*) as contador FROM ".$valor." WHERE ".$exc."= 'N'");
            $stmt->execute();
            $cont =$stmt->fetch(PDO::FETCH_ASSOC);
            return $cont['contador'];
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }


}
?>