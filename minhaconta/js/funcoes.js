/**
 * Created by RychardSilva on 15/06/2017.
 */


var toggle = true;
var entrar = true;
var foco = false;


/**
 * exclusão
 */
$('#divtable').on('click', '.deletar', function() {
    var apagar = confirm("Deseja realmente cancelar este agendamento?");
    if(apagar == true){
        $('#carregando').show();
        var dados = 'classe='+ classe +'&acao=' + $(this).attr('alt') + '&valor=R&id=' + $(this).attr('href');
        $.post("../../acoes.php", dados, function (json) {
            var resposta = jQuery.parseJSON(json);

            if(!resposta.retorno[0].retorno){
                $(divresposta).html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i><i class="glyphicon glyphicon-remove-circle"></i> ' + resposta.mensagem[0].mensagem+ '</div>');
                $('#carregando').hide();
            }
            else{
                $(divresposta).html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-check-circle"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
                table_carregar(table, classe);
            }
        });
    }
    return false;
});

/**
 * Cadastro
 */
$('#formcadastro').on('submit', function() {
    $('#carregando').show();
    var inputs = $(this).serialize();
    $('#enviar').hide();


    var dados = 'classe='+ classe +'&acao=register&valor=R&' + inputs;
    if(classe == 'agendamentos') {
        dados += '&servicos='+$('#servicosR').val();
    }

    if(classe == 'empresas'){
        dados += '&diassemana='+$('#diassemanas').val();
    }

    $.post("../../acoes.php", dados, function (json) {

        var resposta = jQuery.parseJSON(json);

        if(!resposta.retorno[0].retorno){
            $(divresposta).html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> &nbsp;' + resposta.mensagem[0].mensagem+ '</div>');
            $('#carregando').hide();
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }
        else{

            $(divresposta).html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-check-circle"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
            if((classe == 'empresas') || (foco)) {
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }
            else if(classe == 'agendamentos') {
                $('#hoje').click();
            }
            else {
                table_carregar(table, classe);
            }
        }
    });
    $('#enviar').show();

    if((classe == 'empresas') || (foco)) {
        $("html, body").animate({ scrollTop: 0 }, "slow");
    }
    else if(classe == 'agendamentos') {
        $('#servicosR').select2("val", "");
        $('#nomecliente').val('');
        $('#obsemp').val('');
        $('#profausente').val('N');
        $('#datainicio').val('');
        $('#adddiv').hide();
        $('#divdatafim').hide();
    }
    else {
        $('form')[0].reset();
        $('#cadastro').modal('toggle');
    }
    $('#carregando').hide();
    return false;
});

/**
 * Edição
 */
$('#divtable').on('click', '.editar', function() {
    var uid = $(this).attr('href');
    var dados = 'classe='+classe+'&acao='+consulta+'&valor=' + uid;
    dados += '&tabela='+tabela+'&campo='+campo+'&campoI='+campoI;
    $('#enviar').hide();

    if((alias != "" && classe != "mensagens") || (classe == "chamados")) { dados += '&alias='+alias; }
    $('#carregando').show();
    $.post("../../acoes.php", dados, function (json) {

        var resposta = jQuery.parseJSON(json);
        if(!resposta .retorno[0].retorno){
            $('#resposta').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
        }
        else {
            var dados = resposta.dados[0].dados[0];
            $.each(dados,function(index, value){
                $('#' + index).val(value);
            });
            if($('#senha').length > 0) {
                $('#senha').val('');
            }
            $('.socadastro').hide();
            $('.soedicao').show();
            $('.desabilitar').prop('disabled', true);

            if(classe == 'mensagens'){
                $('#enviar').hide();
                $('#divtitulo').html('Ler mensagem');
                var dadosler = 'classe='+classe+'&acao=ler&valor=' + uid;
                $.post("../../acoes.php", dadosler, function (jsonl){
                    var resposta = jQuery.parseJSON(jsonl);
                    if (!resposta.retorno[0].retorno) {
                        $('#resposta').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-remove"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
                    }
                });
            }
            else {
                $('#enviar').show();
                $('#divtitulo').html('Editar');
            }

            $('#cadastro').modal();
            $('#carregando').hide();
        }
    });
    return false;
});

$('body').on('click', '#btncadastro', function() {
    $('#formcadastro')[0].reset();
    $('.socadastro').show();
    $('.soedicao').hide();
    $('.desabilitar').prop('disabled', false);
    $('.classeid').val('0');

    if(classe == 'mensagens'){
        $('#divtitulo').html('Nova mensagem');
    }
    else {
        $('#divtitulo').html('Adicionar');
    }
});


$("#cadastro").on("hidden.bs.modal", function () {

    if(classe == "mensagens") {
        //modo edicao
        if ($('.desabilitar').prop('disabled')) {
            location.href = "mensagens.php";
        }
    }
    else {
        table_carregar(table, classe);
        $('#formcadastro')[0].reset();
    }
});




/**************************************** FUNÇÕES AUXILIARES **************************************************************************/
/**
 * retorna valor da variavel get
 */
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}


/**
 *
 *  TABLE_CRUD(TABELA STRING, DADOS JSON )
 *  Preencher tabelas padrão cadastro
 */
function table_crud(table, dados){
    var html = "";
    var itens = "";
    var acoes = "";
    var recebe = true;
    var recebeacoes = true;
    var podecancelar = true;
    $(table).dataTable().fnDestroy();
    $('#carregando').show();

    if(dados.length == 0){
        html += '<table id="tabela_dados" class="table table-hover"><thead><tr><th data-bSortable="true">#</th>';
        html += campostoth();
        html += '<th class="noprint">Ações</th></tr></thead><tbody>';
    }

    var labeleditar = 'editar';
    if(classe == 'mensagens'){
        labeleditar = 'ler mensagem';
    }

    for (var i = 0; i < dados.length; i++) {
        if(i==0){
            html += '<table id="tabela_dados" class="table table-hover"><thead><tr>';
            $.each(dados[i], function(key, value){
                if(recebe){
                    html += '<th data-bSortable="true">#</th>';
                    recebe = false;
                }
                else{
                    html += '<th data-bSortable="true">' + titleize(key) + '</th>';
                }
            });
            html += '<th class="noprint">Ações</th>';
            html += '</tr></thead><tbody>';
        }

        itens += '<tr>';

        $.each(dados[i], function(key, value){
            if((key == "datacadastro") || (key == "dtleitura") || (key == "data") || (key == "dtinicio")){
                itens += '<td>' + formatDateTime(value,1) + '</td>';
                if(classe == "agendamentos"){
                    podecancelar = comparaData(value);
                    if(!podecancelar) {
                        acoes = '<td> --- </td>';
                    }
                }
            }
            else if(key == "situacao"){
                itens += '<td>' + formatSituacao(value) + '</td>';
            }
            else if(key == "status"){
                itens += '<td>' + formatStatus(value) + '</td>';
            }
            else {
                itens += '<td>' + value + '</td>';
            }
            if(recebeacoes){
                var label = "deletar";
                if(classe == "agendamentos"){
                    label = "Cancelar";
                    acoes = '<td class="noprint"><a href="' + value + '" class="deletar" alt="deletar"><span class="btn-sm btn-danger">' + label + '</span></a> ';
                }

                if(classe != "agendamentos") {
                    acoes += '<a id="editar' + value + '" href="' + value + '" class="editar" alt="editar"><span class="label label-info">' + labeleditar + '</span></a>';
                }
                acoes += '</td>';
                recebeacoes = false;
                podecancelar = false;
            }
        });
        itens += acoes + '</tr>';
        recebeacoes = true;
        podecancelar = true;
    }

    itens += '</tbody></table>';

    $('#divtable').html(html+itens);
    table_dinamica(table);
}

/**
 *
 *  TABLE_CARREGAR(TABELA STRING, CLASSE STRING)
 *  Faz a consulta e preenchee tabelas padrão cadastro
 */
function table_carregar(table, classe) {
    var dados = 'classe='+classe+'&acao='+consulta+'&campos='+campos;
    dados += '&tabela='+tabela+'&campo='+campo+'&campoI='+campoI+'&alias='+alias+'&tabela2='+tabela2+'&campo2='+campo2+'&limite='+limite+'&ordem='+ordem;

    apenasempresa = typeof apenasempresa !== 'undefined' ? apenasempresa : 0;
    dados = dados + '&apenasempresa='+apenasempresa;
    $('#carregando').show();
    $.post("../../acoes.php", dados, function (json) {

        var tabela = jQuery.parseJSON(json);
        if (!tabela.retorno[0].retorno) {
            $('#resposta').html('<div class="alert alert-danger"><i class="fa fa-remove"></i> &nbsp;' + tabela.mensagem[0].mensagem + '</div>');
            $('#carregando').hide();
        }
        else {
            table_crud('#tabela_dados', tabela.dados[0].dados);
        }
        $('#carregando').hide();
    });
}

/**
 *
 *  TABLE_DINAMICA(TABELA STRING)
 *  Aplica dataTables ao table
 */
function table_dinamica(table) {
    var columnSort = new Array;
    $(table).find('thead tr th').each(function(){
        if($(this).attr('data-bSortable') == 'true') {
            columnSort.push({ 'bSortable': true });
        } else {
            columnSort.push({ 'bSortable': false });
        }
    });

    var tabela = $(table).dataTable({
        'aoColumns': columnSort,
        'iDisplayLength': 100
    });
    /**
     * BOTÃO DE IMPRESSÃO
     */
    $('#btnimprimir').click(function(){
        $('.noprint').hide();
        window.print();
        $('.noprint').show();
    });

    $('#tabela_dados_length label select').addClass('form-control');
    $('#tabela_dados_filter label input').addClass('form-control');

    $('#memberLogs_filter label').contents().unwrap();

    $('#carregando').hide();
    if(classe == "agendamentos"){
        $("#btncadastro").hide();
        if(mobil > 0){
            $('#btnimprimir').hide();
            $('#buscador').hide();
            $('#tabela_dados_length').hide();
        }
    }

    var id = getUrlVars()["id"];
    if((id > 0) && (entrar)){
        $('#editar'+id)[0].click();
        entrar = false;
    }
}

/**
 * coloca a primeira letra em maiusculo
 */
function titleize(text) {
    var words = text.toLowerCase().split(" ");
    for (var a = 0; a < words.length; a++) {
        var w = words[a];
        words[a] = w[0].toUpperCase() + w.slice(1);
    }
    return words.join(" ");
}

/**
 * Preencher select com dados do banco
 */
function preencher(selectid, tabelabc, valor, nome, apenasempresa, validagrupo, valorPadrao, valorvazio) {
    apenasempresa = typeof apenasempresa !== 'undefined' ? apenasempresa : 0;
    validagrupo = typeof validagrupo !== 'undefined' ? validagrupo : 0;
    valorPadrao = typeof valorPadrao !== 'undefined' ? valorPadrao : 0;
    valorvazio = typeof valorvazio !== 'undefined' ? valorvazio : false;
    var itens = '';
    var dados = 'classe='+tabelabc+'&acao=consulta&valor=0&campos='+valor+','+nome;
    dados = dados + '&apenasempresa='+apenasempresa + '&validagrupo='+validagrupo;
    $('#carregando').show();
    $.post("../../acoes.php", dados, function (json) {

        var tabela = jQuery.parseJSON(json);
        if (!tabela.retorno[0].retorno) {
            $('#resposta').html('<div class="alert alert-danger"><i class="fa fa-remove"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
        }
        else {
            var dados = tabela.dados[0].dados;
            if(valorvazio){
                itens += '<option value="">Selecione '+tabelabc+'</option>';
            }
            for (var i = 0; i < dados.length; i++) {
                itens += '<option value="' + dados[i][valor] + '">'+ dados[i][nome] +'</option>';
            }
            $('#'+selectid).append(itens);
            if(valorPadrao > 0){
                $('#'+selectid).val(valorPadrao);
            }
        }
        $('#carregando').hide();
    });
}

/**
 * Transforma os campos em <th>
 */
function campostoth(){
    var retorno = '';
    var array = campos.split(",");

    for (i = 1; i < array.length; i++) {
        var th = "";
        if(array[i].indexOf("as") > 0){
            th = array[i].substr(array[i].indexOf(" as ")+4,array[i].length);
        }
        else{
            th = array[i];
        }

        retorno += '<th>' + th + '</th>';
    }

    return retorno;
}

/**
 * Formatar datas
 */
function formatDateTime(sDate,FormatType) {
    if(sDate == '0000-00-00 00:00:00'){
        return '--/--/---- --:--';
    }

    var lDate = moment(sDate,'YYYY-MM-DD HH:mm:ss').toDate();

    var month=new Array(12);
    month[0]="Janeiro";
    month[1]="Fevereiro";
    month[2]="Março";
    month[3]="Abril";
    month[4]="Maio";
    month[5]="Junho";
    month[6]="Julho";
    month[7]="Agosto";
    month[8]="Setembro";
    month[9]="Outubro";
    month[10]="Novembro";
    month[11]="Dezembro";

    var weekday=new Array(7);
    weekday[0]="Dom";
    weekday[1]="Seg";
    weekday[2]="Ter";
    weekday[3]="Qua";
    weekday[4]="Qui";
    weekday[5]="Sex";
    weekday[6]="Sab";

    var hh = lDate.getHours() < 10 ? '0' +
    lDate.getHours() : lDate.getHours();
    var mi = lDate.getMinutes() < 10 ? '0' +
    lDate.getMinutes() : lDate.getMinutes();
    var ss = lDate.getSeconds() < 10 ? '0' +
    lDate.getSeconds() : lDate.getSeconds();

    var d = lDate.getDate();
    var dd = d < 10 ? '0' + d : d;
    var yyyy = lDate.getFullYear();
    var mon = eval(lDate.getMonth()+1);
    var mm = (mon<10?'0'+mon:mon);
    var monthName=month[lDate.getMonth()];
    var weekdayName=weekday[lDate.getDay()];

    if(FormatType==1) {
        return dd+'/'+mm+'/'+yyyy+' '+hh+':'+mi;
    } else if(FormatType==2) {
        return weekdayName+', '+ dd + ' de ' + monthName+' de ' + yyyy + ', ' +hh+':'+mi;
    } else if(FormatType==3) {
        return mm+'/'+dd+'/'+yyyy;
    } else if(FormatType==4) {
        var dd1 = lDate.getDate();
        return dd1+'-'+Left(monthName,3)+'-'+yyyy;
    } else if(FormatType==5) {
        return mm+'/'+dd+'/'+yyyy+' '+hh+':'+mi+':'+ss;
    } else if(FormatType == 6) {
        return mon + '/' + d + '/' + yyyy + ' ' +
            hh + ':' + mi + ':' + ss;
    } else if(FormatType == 7) {
        return  dd + '-' + monthName.substring(0,3) +
            '-' + yyyy + ' ' + hh + ':' + mi + ':' + ss;
    }
}

/**
 * Formatar situação
 */
function formatSituacao(situacao){
    if(situacao == "A"){
        return "<span class='label label-success'>Aberto</span>";
    }
    else if(situacao == "P"){
        return "<span class='label label-info'>Pausado</span>";
    }
    else {
        return "<span class='label label-danger'>Fechado</span>";
    }
}

function formatStatus(status){
    if(status == "N"){
        return "<span class='label label-success'>Agendado</span>";
    }
    else {
        return "<span class='label label-danger'>Cancelado</span>";
    }
}

/**
 * Preencher table com dados de servicos
 */
function preenchertable(tableid, profissionaiid, usacomissao) {
    usacomissao = typeof usacomissao !== 'undefined' ? usacomissao : 'N';
    var itens = '';
    var dados = 'classe=servicos&acao=consulta&valor=0&campos=servicoid, nome servico';
    dados = dados + '&apenasempresa=2';
    $('#carregando').show();
    $.post("../../acoes.php", dados, function (json) {

        var tabela = jQuery.parseJSON(json);
        if (!tabela.retorno[0].retorno) {
            $('#resposta').html('<div class="alert alert-danger"><i class="fa fa-remove"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
        }
        else {
            var dados = tabela.dados[0].dados;

            var html = "";
            var itens = "";
            var acoes = "";
            var recebe = true;
            var recebeacoes = true;

            html += '<table id="tabela_servicos" class="table table-bordered table-responsive"><thead><tr><th data-bSortable="true">#</th>';
            html += '<th>Serviço</th>';
            if(usacomissao == 'S') {
                html += '<th>Valor da comissão</th><th>Tipo da comissão</th>';
            }
            html += '<th>Seleciona</th></tr></thead><tbody>';

            for (var i = 0; i < dados.length; i++) {

                itens += '<tr>';
                $.each(dados[i], function(key, value){

                    itens += '<td>' + value + '</td>';

                    if(recebeacoes){
                        acoes = '';
                        if(usacomissao =='S') {
                            acoes += '<td><input type="number" step="any" name="valorcomissao" class="form-control" placeholder="Valor da comissão"></td>';
                            acoes += '<td><select name="tipocomissao" class="form-control"><option value="V">Valor</option><option value="P">Percentual</option></select></td>';
                        }

                        acoes += '<td><div class="switch-main"><div class="onoffswitch">';
                        acoes += '<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch'+i+'" checked>';
                        acoes += '<label class="onoffswitch-label" for="myonoffswitch'+i+'">';
                        acoes += '    <span class="onoffswitch-inner"></span>';
                        acoes += '    <span class="onoffswitch-switch"></span>';
                        acoes += '    </label>';
                        acoes += '    </div>';
                        acoes += '   </div></td>';
                        recebeacoes = false;
                    }
                });
                itens += acoes + '</tr>';
                recebeacoes = true;
            }

            itens += '</tbody></table>';

            $('#divtable').html(html+itens);
        }
        $('#carregando').hide();
    });
}

/**
 * Preencher select com dados do banco
 */
function preencherServicos(selectid, profissionaiid, profissionaiiddefault) {
    profissionaiid = typeof profissionaiid !== 'undefined' ? profissionaiid : 0;
    var profissional = profissionaiid;
    if((profissional == null) || (profissional == 0)){
        profissional = profissionaiiddefault;
    }
    var itens = '';
    var dados = 'classe=servicos&acao=consultaI&valor=0&campos=servicos.servicoid valor,servicos.nome';
    dados = dados + '&apenasempresa=3&campoI=servicoid&campo=servicoid&tabela=relservicosprofissionais&filtro=profissionaiid&filtrov='+profissional;
    $('#carregando').show();
    $.post("../../acoes.php", dados, function (json) {
        var tabela = jQuery.parseJSON(json);
        if (!tabela.retorno[0].retorno) {
            $('#resposta').html('<div class="alert alert-danger"><i class="fa fa-remove"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
        }
        else {
            $('#'+selectid).find('option').remove();
            var dados = tabela.dados[0].dados;
            for (var i = 0; i < dados.length; i++) {
                itens += '<option value="' + dados[i]['valor'] + '">'+ dados[i]['nome'] +'</option>';
            }
            $('#'+selectid).append(itens);
        }
        $('#carregando').hide();
    });
}

/**
 *
 */
function comparaData(sDate) {

    if (sDate == '0000-00-00 00:00:00') {
        return false;
    }

    var lDate = moment(sDate, 'YYYY-MM-DD HH:mm:ss').toDate();
    var today = new Date();

    return (lDate>=today);
}