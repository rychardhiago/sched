<?php/** * Created by PhpStorm. * User: RychardSilva * Date: 22/03/2017 * Time: 19:29 *//*  * Estrutura do JSON  * *  { *    "retorno":[{"retorno": false}],      --boolean *    "mensagem":[{"mensagem": "txt"}],   --string *    "dados":[{"dados": json}]           --json * *  } **/require_once("session.php");require_once("classes/class.profissionais.php");require_once("classes/class.mensagens.php");require_once("classes/class.chamados.php");require_once("classes/class.empresas.php");require_once("classes/class.servicos.php");require_once("classes/class.agendamentos.php");require_once("classes/class.relservicosprofissionais.php");require_once("classes/class.cidades.php");require_once("classes/class.clientes.php");    if(isset($_POST['classe']) && isset($_POST['acao'])){        $class_geral = new $_POST['classe']();                $json = '{"retorno":[{"retorno":';        $dados = '"dados":[{"dados": ';        $mensagem = '"mensagem":[{"mensagem":';        $retorno = false;        if ($_POST['acao']=='consulta'){            try {                $sql = "SELECT ";                if(isset($_POST['campos']) && ($_POST['campos'] != "")){                    $sql .= $_POST['campos'];                }                else{                    $sql .= $_POST['classe'].".*";                }                $sql .=" FROM ".$_POST['classe']." WHERE excluido = 'N'";                if((isset($_POST['valor']) && ($_POST['valor'] > 0)) || ($_POST['classe'] == "mensagens") || ($_POST['classe'] == "chamados")) {                    $sql .= " AND ";                    if (isset($_POST['alias']) && (!isset($_POST['valor']))) {                        $sql .= $_POST['alias'];                    } else {                        $sql .= substr($_POST['classe'], 0, -1);                    }                    if (!isset($_POST['valor']) && ($_POST['classe'] == "mensagens" || ($_POST['classe'] == "chamados"))) {                        $sql .= "id=" . $_SESSION['user_session'];                    } else if ($_POST['valor'] != "0") {                        if($_POST['usaIN'] == 'S'){                            $sql .= "id IN (" . $_POST['valor'] . ") ";                        }                        else{                            $sql .= "id=" . $_POST['valor'];                        }                    }                }                if(isset($_POST['apenasempresa']) && ($_POST['apenasempresa'] > 0)) {                    if($_POST['apenasempresa'] == 1){                        $sql .= " AND ";                        $sql .= substr($_POST['classe'], 0, -1);                        $sql .= "id<>" . $_SESSION['user_session'];                    }                    if(isset($_POST['validagrupo']) && ($_POST['validagrupo'] > 0)) {                        if($_SESSION['admingrupo'] == 'S'){                            $sql .= " AND empresaid in (select empresaid from empresas where grupoid = " . $_SESSION['grupoid']. ")";                        }                        else if($_SESSION['adminempresa'] == 'S'){                            $sql .= " AND empresaid=" . $_SESSION['empresaid'];                        }                        else {                            $sql .= " AND empresaid=" . $_SESSION['empresaid'] . " AND profissionaiid = ".$_SESSION['user_session'];                        }                    }                    else {                        $sql .= " AND empresaid=" . $_SESSION['empresaid'];                    }                }                if(isset($_POST['filtro']) && isset($_POST['filtrov']) && ($_POST['filtrov'] != "") ){                    $sql .= " AND ".$_POST['filtro']."='". $_POST['filtrov']."'";                }                if(isset($_POST['ordem'])){ $sql .= " ORDER BY ".$_POST['ordem']; }                $stmt = $class_geral->runQuery($sql);                $stmt->execute();                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);                                $retorno = true;                $mensagem .= '"Dados encontrados com sucesso'.$sql.'"';                $dados .= json_encode($result);            }            catch (Exception $e) {                $retorno = false;                $mensagem .= '"Erro ao executar o comando. <br> Erro original: ' . $e->getMessage() . $sql . '"';                $dados .= '""';            }        }        else if ($_POST['acao']=='consultaI'){            try {                $sql = "SELECT ";                if(isset($_POST['campos']) && ($_POST['campos'] != "")){                    $sql .= $_POST['campos'];                }                else{                    $sql .= $_POST['classe'].".*";                }                $sql .=" FROM ".$_POST['classe'].", ".$_POST['tabela']." WHERE ".$_POST['classe'].".excluido = 'N'";                if((isset($_POST['valor']) && ($_POST['valor'] > 0)) || ($_POST['classe'] == "mensagens")) {                    $sql .= " AND ";                    if(isset($_POST['alias'])) {                        $sql .= $_POST['alias'];                    }                    else{                        $sql .= substr($_POST['classe'], 0, -1);                    }                    if (!isset($_POST['valor'])){                        $sql .= "id=" . $_SESSION['user_session'];                    }                    else {                        $sql .= "id=" . $_POST['valor'];                    }                }                if(isset($_POST['apenasempresa']) && ($_POST['apenasempresa'] > 0)){                    if($_POST['apenasempresa'] == 1) {                        $sql .= " AND ";                        $sql .= substr($_POST['classe'], 0, -1);                        $sql .= "id<>" . $_SESSION['user_session'];                    }                    if($_POST['apenasempresa'] == 3) {                        $sql .= " AND empresaid=" . $_SESSION['empresaid'];                    }                    else {                        $sql .= " AND empresas.empresaid=" . $_SESSION['empresaid'];                    }                }                $sql .= " AND ".$_POST['classe'].".".$_POST['campo']." = ".$_POST['tabela'].".".$_POST['campoI'];                if(isset($_POST['filtro']) && isset($_POST['filtrov']) && ($_POST['filtrov'] != "") ){                    $sql .= " AND ".$_POST['filtro']."='". $_POST['filtrov']."'";                }                if(isset($_POST['ordem'])){ $sql .= " ORDER BY ".$_POST['ordem']; }                $stmt = $class_geral->runQuery($sql);                $stmt->execute();                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);                $retorno = true;                $mensagem .= '"Dados encontrados com sucesso"';                $dados .= json_encode($result);            }            catch (Exception $e) {                $retorno = false;                $mensagem .= '"Erro ao executar o comando. <br> Erro original: ' . $e->getMessage() . $sql . '"';                $dados .= '""';            }        }        else if (($_POST['acao']=='register') || ($_POST['acao']=='bloquear') || ($_POST['acao']=='cancelar') || ($_POST['acao']=='editarservicos')){            try {                $valor[] = "";                foreach($_POST as $key => $value) {                    if (($key != "acao") && ($key != "valor") && ($key != "classe")){                        $valor[$key] = $value;                    }                }                $resultado = $class_geral->$_POST['acao']($valor);                if ($resultado == "0"){                    $retorno = true;                    $mensagem .= '"Comando executado com sucesso."';                    $dados .= '""';                }                else{                    $retorno = false;                    $mensagem .= '"Erro ao executar o comando. <br> Erro original: ' . $resultado . '"';                    $dados .= '""';                }            } catch (Exception $e) {                $retorno = false;                $mensagem .= '"Erro ao executar o comando. <br> Erro original: ' . $e->getMessage() . '"';                $dados .= '""';            }        }        else {            try {                if ($r = $class_geral->$_POST['acao']($_POST['valor'])) {                    $retorno = true;                    $mensagem .= '"Comando executado com sucesso."';                    $dados .= '""';                }            } catch (Exception $e) {                $retorno = false;                $mensagem .= '"Erro ao executar o comando. <br> Erro original: ' . $e->getMessage() . '"';                $dados .= '""';            }        }        $dados .= '}]';        $json .= '"'.$retorno.'"}],';        $mensagem .= "}],";        if(($_POST['classe'] == 'clientes') and ($_REQUEST['valor'] > 0)){            $dados .= ', "historico":[{"historico":';            $sql   = "SELECT agendamentos.agendamentoid, agendamentos.datainicio, agendamentos.datafim, agendamentos.obscli, agendamentos.obsemp, agendamentos.cancelado ";            $sql  .= ", agendamentos.datacancel , agendamentos.interno, ifnull(agendamentos.profausente,'N') profausente, agendamentos.nomecliente, agendamentos.tempototal ";            $sql  .= ", agendamentos.precototal, agendamentos.compareceu, ifnull(agendamentos.interno, 'N') interno, profissionais.nome, empresas.nomefantasia empresa, agendamentos.servicos  ";            $sql  .= "FROM agendamentos, profissionais, empresas ";            $sql  .= "WHERE agendamentos.profissionaiid = profissionais.profissionaiid and agendamentos.empresaid = empresas.empresaid ";            $sql  .= " and empresas.empresaid = ".$_SESSION['empresaid'];            $sql  .= " and agendamentos.clienteid = ".$_REQUEST['valor'];            $stmt = $class_geral->runQuery($sql);            $stmt->execute();            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            $dados .= json_encode($result);            $dados .= '}]';        }        $json = $json.$mensagem.$dados."}";        echo $json;    }?>