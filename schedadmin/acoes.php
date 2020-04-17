<?php
/**
 * Created by PhpStorm.
 * User: RychardSilva
 * Date: 22/03/2017
 * Time: 19:29
 */

/* 
 * Estrutura do JSON 
 *
 *  {
 *    "retorno":[{"retorno": false}],      --boolean
 *    "mensagem":[{"mensagem": "txt"}],   --string
 *    "dados":[{"dados": json}]           --json
 *
 *  }
 *
*/
require_once("session.php");
require_once("classes/class.usuarios.php");
require_once("classes/class.pais.php");
require_once("classes/class.estados.php");
require_once("classes/class.cidades.php");
require_once("classes/class.grupos.php");
require_once("classes/class.empresas.php");
require_once("classes/class.servicos.php");
require_once("classes/class.profissionais.php");
require_once("classes/class.chamados.php");

    if(isset($_POST['classe']) && isset($_POST['acao']) && isset($_POST['valor'])){
        $class_geral = new $_POST['classe']();
        
        $json = '{"retorno":[{"retorno":';
        $dados = '"dados":[{"dados": ';
        $mensagem = '"mensagem":[{"mensagem":';
        $retorno = false;

        if ($_POST['acao']=='consulta'){
            try {
                $sql = "SELECT ";
                if(isset($_POST['campos']) && ($_POST['campos'] != "")){
                    $sql .= $_POST['campos'];
                }
                else{
                    $sql .= "*";
                }
                $sql .=" FROM ".$_POST['classe']." WHERE excluido = 'N'";
                if(isset($_POST['valor']) && ($_POST['valor'] > 0)){
                   $sql .= " AND ";
                   if(isset($_POST['alias'])) {
                       $sql .= $_POST['alias'];
                   }
                   else{
                       $sql .= substr($_POST['classe'], 0, -1);
                   }
                   $sql .= "id=".$_POST['valor'];
                }
                if(isset($_POST['ordem'])){ $sql .= " ORDER BY ".$_POST['ordem']; }
                $stmt = $class_geral->runQuery($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $retorno = true;
                $mensagem .= '"Dados encontrados com sucesso"';
                $dados .= json_encode($result);
            }
            catch (Exception $e) {
                $retorno = false;
                $mensagem .= '"Erro ao executar o comando <br>Erro original: ' . $e->getMessage() . $sql . '"';
                $dados .= '""';
            }
        }
        else if ($_POST['acao']=='consultaI'){
            try {
                $sql = "SELECT ";
                if(isset($_POST['campos']) && ($_POST['campos'] != "")){
                    $sql .= $_POST['campos'];
                }
                else{
                    $sql .= "*";
                }
                $sql .=" FROM ".$_POST['classe'].", ".$_POST['tabela']." WHERE ".$_POST['classe'].".excluido = 'N'";
                if(isset($_POST['valor']) && ($_POST['valor'] > 0)){
                    $sql .= " AND ";
                    if(isset($_POST['alias'])) {
                        $sql .= $_POST['alias'];
                    }
                    else{
                        $sql .= substr($_POST['classe'], 0, -1);
                    }
                    $sql .= "id=".$_POST['valor'];
                }
                $sql .= " AND ".$_POST['classe'].".".$_POST['campo']." = ".$_POST['tabela'].".".$_POST['campo'];
                if(isset($_POST['ordem'])){ $sql .= " ORDER BY ".$_POST['ordem']; }
                $stmt = $class_geral->runQuery($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $retorno = true;
                $mensagem .= '"Dados encontrados com sucesso"';
                $dados .= json_encode($result);
            }
            catch (Exception $e) {
                $retorno = false;
                $mensagem .= '"Erro ao executar o comando <br>Erro original: ' . $e->getMessage() . $sql . '"';
                $dados .= '""';
            }
        }
        else if ($_POST['acao']=='register'){
            try {
                $valor[] = "";

                foreach($_POST as $key => $value) {
                    if (($key != "acao") && ($key != "valor") && ($key != "classe")){
                        $valor[$key] = $value;
                    }
                }

                $resultado = $class_geral->$_POST['acao']($valor);
                if ($resultado == "0"){
                    $retorno = true;
                    $mensagem .= '"Comando executado com sucesso."';
                    $dados .= '""';
                }
                else{
                    $retorno = false;
                    $mensagem .= '"Erro ao executar o comando <br>Erro original: ' . $resultado . '"';
                    $dados .= '""';
                }
            } catch (Exception $e) {
                $retorno = false;
                $mensagem .= '"Erro ao executar o comando <br>Erro original: ' . $e->getMessage() . '"';
                $dados .= '""';
            }
        }
        else {
            try {
                if ($r = $class_geral->$_POST['acao']($_POST['valor'])) {
                    $retorno = true;
                    $mensagem .= '"Comando executado com sucesso."';
                    $dados .= '""';
                }
            } catch (Exception $e) {
                $retorno = false;
                $mensagem .= '"Erro ao executar o comando <br>Erro original: ' . $e->getMessage() . '"';
                $dados .= '""';
            }
        }

        $dados .= '}]';
        $json .= '"'.$retorno.'"}],';
        $mensagem .= "}],";
        
        $json = $json.$mensagem.$dados."}";
        echo $json;
    }
?>