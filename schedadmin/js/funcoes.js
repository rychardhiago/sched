/**
 * Created by RychardSilva on 01/05/2017.
 */

/**
 *  ESCONDE MENU
 */
$('#menu').load('menu.php', function () {
    $('#sidebaricon').click();
});


var table = '#tabela_dados';
var consulta = 'consulta';
if(inner != ''){
    consulta += 'I';
}


table_carregar(table,classe);

/**
 * acção do botão adicionar
 */
$('.inner-block').on('click', '#btn-add', function() {
    $('#modal-title').html('Adicionar');
    $('.classeid').val('0');
    $('form')[0].reset();
});

/**
 * exclusão
 */
$('#divtable').on('click', '.deletar', function() {
    var apagar = confirm("Deseja realmente excluir este registro?");
    if(apagar == true){
        $('#carregando').show();
        var dados = 'classe='+ classe +'&acao=' + $(this).attr('alt') + '&valor=' + $(this).attr('href');
        $.post("acoes.php", dados, function (json) {
            var resposta = jQuery.parseJSON(json);

            if(!resposta.retorno[0].retorno){
                $(divresposta).html('<div class="alert alert-danger"><i class="fa fa-remove"></i> &nbsp;' + resposta.mensagem[0].mensagem+ '</div>');
                $('#carregando').hide();
            }
            else{
                $(divresposta).html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
                table_carregar(table, classe);
            }
        });
    }
    return false;
});

/**
 * Cadastro
 */
$('form').on('submit', function() {
    $('#carregando').show();
    var inputs = $(this).serialize();

    var dados = 'classe='+ classe +'&acao=register&valor=R&' + inputs;

    if(classe == 'empresas'){
        dados += '&diassemana='+$('#diassemanas').val();
    }

    $.post("acoes.php", dados, function (json) {

        var resposta = jQuery.parseJSON(json);

        if(!resposta.retorno[0].retorno){
            $(divresposta).html('<div class="alert alert-danger"><i class="fa fa-remove"></i> &nbsp;' + resposta.mensagem[0].mensagem+ '</div>');
            $('#carregando').hide();
        }
        else{
            $(divresposta).html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
            table_carregar(table, classe);
        }
    });

    $('form')[0].reset();
    $('#myModal2').modal('toggle');

    return false;
});

/**
 * Edição
 */
$('#divtable').on('click', '.editar', function() {
    var dados = 'classe='+classe+'&acao=consulta&valor=' + $(this).attr('href');

    if(alias != ""){ dados += '&alias='+alias; }
    $.post("acoes.php", dados, function (json) {
        var resposta = jQuery.parseJSON(json);
        if(!resposta .retorno[0].retorno){
            $('#resposta').html('<div class="alert alert-danger"><i class="fa fa-remove"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
        }
        else {
            var dados = resposta.dados[0].dados[0];
            $.each(dados,function(index, value){
                $('#'+index).val(value);
            });
            if($('#senha').length ) {
                $('#senha').val('');
            }
            if(classe == 'empresas'){
                $('#diassemanas').selectpicker('val','');
                var values = dados['diassemana'];
                $.each(values.split(","), function(i,e){
                    $("#diassemanas option[value='" + e + "']").prop("selected", true);
                });
                $('#diassemanas').selectpicker('refresh');
            }
            $('#modal-title').html('Editar');
            $('#myModal2').modal();
        }
    });
    return false;
});


/**************************************** FUNÇÕES AUXILIARES **************************************************************************/

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
    $(table).dataTable().fnDestroy();
    $('#carregando').show();

    if(dados.length == 0){
        html += '<table id="tabela_dados" class="table table-hover"><thead><tr><th data-bSortable="true">#</th>';
        html += campostoth();
        html += '<th class="noprint">Ações</th></tr></thead><tbody>';
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
            if((key == "datacadastro") || (key == "dtleitura") || (key == "dtenvio")){
                itens += '<td>' + formatDateTime(value,1) + '</td>';
            }
            else if(key == "situacao"){
                itens += '<td>' + formatSituacao(value,1) + '</td>';
            }
            else if(key == "pasta"){
                itens += '<td align="center"><a href="../admin/empresas/' +value+'" target="_blank"><i class="glyphicon glyphicon-folder-open"></i></a></td>';
            }
            else {
                itens += '<td>' + value + '</td>';
            }
            if(recebeacoes){
                acoes = '<td class="noprint"><a href="' + value + '" class="deletar" alt="deletar"><span class="label label-danger">deletar</span></a> ';
                acoes += '<a href="' + value + '" class="editar" alt="editar"><span class="label label-info">editar</span></a></td>';
                recebeacoes = false;
            }
        });
        itens += acoes + '</tr>';
        recebeacoes = true;
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
    var dados = 'classe='+classe+'&acao='+consulta+'&valor=0&campos='+campos;
    if(consulta == 'consultaI'){
        dados += '&tabela='+inner+'&campo='+campoI;
    }
    $.post("acoes.php", dados, function (json) {

        var tabela = jQuery.parseJSON(json);
        if (!tabela.retorno[0].retorno) {
            $('#resposta').html('<div class="alert alert-danger"><i class="fa fa-remove"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
            $('#carregando').hide();
        }
        else {
            table_crud('#tabela_dados', tabela.dados[0].dados);
        }
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
}

/**
 * coloca a primeira letra em maiusculo
 */
function titleize(text) {
    var words = text.toLowerCase().split(" ");
    for (var a = 0; a < words.length; a++) {
        var w = words[a];
        words[a] = w[0].toUpperCase() + w.slice(1).replace("2"," - ");
    }
    return words.join(" ");
}

/**
 * Preencher select com dados do banco
 */
function preencher(selectid, tabela, valor, nome) {
    var itens = '';
    var dados = 'classe='+tabela+'&acao=consulta&valor=0&campos='+valor+','+nome;
    $.post("acoes.php", dados, function (json) {
        var tabela = jQuery.parseJSON(json);
        if (!tabela.retorno[0].retorno) {
            $('#resposta').html('<div class="alert alert-danger"><i class="fa fa-remove"></i> &nbsp;' + resposta.mensagem[0].mensagem + '</div>');
            $('#carregando').hide();
        }
        else {
            var dados = tabela.dados[0].dados;
            for (var i = 0; i < dados.length; i++) {
                itens += '<option value="' + dados[i][valor] + '">'+ dados[i][nome] +'</option>';
            }
            $('#'+selectid).append(itens);
        }
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
