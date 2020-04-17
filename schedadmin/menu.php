<?php
/**
 * Created by PhpStorm.
 * User: RychardSilva
 * Date: 06/05/2017
 * Time: 14:16
 */
require_once("session.php");
?>

<li id="menu-home" ><a href="home.php" title="Home"><i class="fa fa-tachometer"></i><span>Home</span></a></li>
<li><a href="chamados.php" title="Chamados"><i class="fa fa-book nav_icon"></i><span>Chamados</span></a></li>
<li><a href="grupos.php" title="Grupos"><i class="fa fa-th-list"></i><span>Grupos</span></a></li>
<li><a href="empresas.php" title="Empresas"><i class="fa fa-file-text"></i><span>Empresas</span></a></li>
<li><a href="servicos.php" title="Serviços"><i class="fa fa-cogs"></i><span>Serviços</span></a></li>
<li><a href="profissionais.php" title="Profissionais"><i class="fa fa-user"></i><span>Profissionais</span></a></li>
<li><a href="agendamentos.php" title="Agendamentos"><i class="fa fa-calendar-times-o"></i><span>Agendamentos</span></a></li>
<li><a href="cidades.php" title="Cidades"><i class="fa fa-map-marker"></i><span>Cidades</span></a></li>
<li><a href="estados.php" title="Estados"><i class="fa fa-th-large"></i><span>Estados</span></a></li>
<li><a href="pais.php" title="Países"><i class="fa fa-flag"></i><span>Países</span></a></li>
<?php
    if($_SESSION['grupo'] == "Admin"){
        echo '<li><a href="usuarios.php" title="Usuários"><i class="fa fa-users"></i><span>Usuários</span></a></li>';
    }
?>


