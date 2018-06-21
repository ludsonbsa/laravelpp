$(function() {

    $('.ui-helper-hidden-accessible').hide();
    $("#loader").hide();
    $( ".tool" ).tooltip({
        tooltipClass: "tooltip",
    });

    $(".alert-success").click(function(){
        $(this).fadeOut();
    });

    $("#loader").fadeOut();

    $('.tabs-menu ul li a').click(function(){

        var a = $(this);
        var active_tab_class = 'active-tab-menu';
        var the_tab = '.' + a.attr('data-tab');

       $('.tabs-menu ul li a').removeClass(active_tab_class);
        a.addClass(active_tab_class);

        //Verificação de LEAD MENU
        if(the_tab == '.lead-tab1'){
            location.href='/admin/leads';
        }else if(the_tab == '.lead-tab2'){
            var tab1 = '/admin/leads/vendidos-nao-conferidos';
        }
        else if(the_tab == '.lead-tab3'){
            var tab1 = '/admin/leads/nao-vendidos';
        }
        else if(the_tab == '.lead-tab4'){
            var tab1 = '/admin/leads/boletos-gerados';
        }
        else if(the_tab == '.lead-tab5'){
            var tab1 = '/admin/leads/ligar-depois';
        }
        else if(the_tab == '.lead-tab6'){
            alert("Ainda não existem registros agendados");
        }
        else if(the_tab == '.lead-tab7'){
            var tab1 = '/admin/leads/recuperar-boletos';
        }
        else if(the_tab == '.lead-tab8'){
            $('#loader').fadeIn();
            var tab1 = '/admin/leads/nao-atendidos';
        } else
        //Verificação de Comissões Menu
        if(the_tab == '.com-tab1'){
            location.href='/admin/comissoes';
        }else if(the_tab == '.com-tab2'){
            var tab1 = '/admin/comissoes/conferidas';
        }
        else if(the_tab == '.com-tab3'){
            var tab1 = '/admin/comissoes/aprovar-manualmente';
        }
        else if(the_tab == '.com-tab4'){
            var tab1 = '/admin/comissoes/comissionar-pendentes';
        }
        else if(the_tab == '.com-tab5'){
            var tab1 = '/admin/comissoes/geradas';
        }

        //Verificação de Usuário
        if(the_tab == '.tab1-user'){
            location.href='/admin/usuarios/listar';
        }else if(the_tab == '.tab2-user'){
            var tab1 = '/admin/usuarios/add';
        }

        //Verificação de Importação
        if(the_tab == '.tab1-imp'){
            location.href='/admin/leads/importar';
        }else if(the_tab == '.tab2-imp'){
            var tab1 = '/admin/leads/recuperacao';
        }

        //Verificação de Brinde Menu
        if(the_tab == '.brinde-tab1'){
            location.href='/admin/brindes/listar';
        }else if(the_tab == '.brinde-tab2'){
            var tab1 = '/admin/brindes/resultado-conferencia';
        }
        else if(the_tab == '.brinde-tab3'){
            var tab1 = '/admin/brindes/aprovar-manualmente';
        }
        else if(the_tab == '.brinde-tab4'){
            var tab1 = '/admin/brindes/gerar-etiquetas';
        }
        else if(the_tab == '.brinde-tab5'){
            var tab1 = '/admin/brindes/baixar-etiquetas';
        }

        //Verificação de Brinde Menu
        if(the_tab == '.livro-tab1'){
            location.href='/admin/livro/listar';
        }else if(the_tab == '.livro-tab2'){
            var tab1 = '/admin/livro/resultado-conferencia';
        }
        else if(the_tab == '.livro-tab3'){
            var tab1 = '/admin/livro/aprovar-manualmente';
        }
        else if(the_tab == '.livro-tab4'){
            var tab1 = '/admin/livro/gerar-etiquetas';
        }
        else if(the_tab == '.livro-tab5'){
            var tab1 = '/admin/livro/baixar-etiquetas';
        }


        $(".widget").html("<div id='loader'></div>").load(tab1,function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success")

            if(statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });

        $('#aa-search-input').submit(function(){
            alert("SUBMIT");
            return false;
        });
        return false;
    });

        /**TESTE DE MODAL **/
    $('.leads').click(function(){
        //Pego dados do data-id
        var dados = $(this).attr('data-id');
        var email = $(this).attr('data-email');
        var nome = $(this).attr('data-nome');
        //Abro a modal
        $('.modal').fadeIn('500');
        $('.modal .idlead').text(nome+' <'+email+'> ?');

        var trocar ='/admin/leads/deletar/'+dados;
        //Atribuo o URL de delete com o id chamado
        $('.dataRoute').attr('href', trocar);
        //Jogar as informações do lead pra dentro dos atributos e jogar no alert
    });


    $('.senhas').click(function(){
        //Abro a modal
        $('.modalsenha').fadeIn('500');
        $('.modal .idlead').text(nome+' <'+email+'> ?');

        var trocar ='/admin/leads/deletar/'+dados;
        //Atribuo o URL de delete com o id chamado
        $('.dataRoute').attr('href', trocar);
        //Jogar as informações do lead pra dentro dos atributos e jogar no alert
    });



    $('button[data-dismiss=modal]').click( function(e){
        e.preventDefault();
        $('.modal').fadeOut();
    });


    /**TESTE DE MODAL **/
    /*$('.tabs-menu ul li:nth-child(3) a').click(function(){
        alert('vai');

    });*/

    //Tab de comissões -> Levar para a aba específica de aprovar manualmente


    //Tab de comissões -> Levar para a aba específica de comissões
    $('#comissionar').click(function(){
        var a = $('.tabs-menu ul li:nth-child(4) a');
        var active_tab_class = 'active-tab-menu';
        var the_tab = '.' + a.attr('data-tab');

        $('.tabs-menu ul li a').removeClass(active_tab_class);
        a.addClass(active_tab_class);

        $.ajax({
            beforeSend: function() {
                $('.tabs').fadeOut();
                $('#loader').fadeIn();
            }
        }).done(function() {
            $('#loader').fadeOut();
            //$('.tabs').show();
            $('.tabs-content .tabs').fadeOut();
            $(the_tab).fadeIn('fast');
        });

        return false;
    });

    $('#brindeaprovar').click(function(){
        var a = $('.tabs-menu ul li:nth-child(3) a');
        var active_tab_class = 'active-tab-menu';
        var the_tab = '.' + a.attr('data-tab');

        $('.tabs-menu ul li a').removeClass(active_tab_class);
        a.addClass(active_tab_class);

        $.ajax({
            beforeSend: function() {
                $('.tabs').fadeOut();
                $('#loader').fadeIn();
            }
        }).done(function() {
            $('#loader').fadeOut();
            //$('.tabs').show();
            $('.tabs-content .tabs').fadeOut();
            $(the_tab).fadeIn('fast');
        });

        return false;
    });

    $('#brindesap').click(function(){
        var a = $('.tabs-menu ul li:nth-child(4) a');
        var active_tab_class = 'active-tab-menu';
        var the_tab = '.' + a.attr('data-tab');

        $('.tabs-menu ul li a').removeClass(active_tab_class);
        a.addClass(active_tab_class);

        $.ajax({
            beforeSend: function() {
                $('.tabs').fadeOut();
                $('#loader').fadeIn();
            }
        }).done(function() {
            $('#loader').fadeOut();
            //$('.tabs').show();
            $('.tabs-content .tabs').fadeOut();
            $(the_tab).fadeIn('fast');
        });

        return false;
    });


    $('#refresher').click(function() {

        $.ajax({
            beforeSend: function() {
                $('#loader').fadeIn();
                location.reload(true);
            }
        }).done(function() {
            $('#loader').fadeOut();
        });

        return false;
    });


    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.avatar').attr('src', e.target.result);
                $('.avatar').fadeIn('slow');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#upload").click(function(){
        $('.avatar').fadeOut('fast');
    });

    $("#upload").change(function() {
        readURL(this);
        var arq = this.files[0];
        $(this).val(arq.name);
    });


    $('form[name="adminform"]').submit(function() {

        $(this).ajaxForm({
            uploadProgress: function(event, position, total, percentComplete) {
                $('progress').attr('value',percentComplete);
                $('#porcentagem').html(percentComplete+'%');
            },
            success: function(data) {
                $('progress').attr('value','100');
                $('#porcentagem').html('100%');
                $('pre').html(data);
            }
        });

    });

    $("#hotmart").change(function() {
        $('#planilhaNome').html($('input[type="file"]').val());
    });

    $("#recuperacao").change(function() {
        $('#planilhaNomeRec').html($('input[type="file"]').val());
    });


    // Table sorter
    $("#myTable").tablesorter();
    $("#table").tablesorter();
    $("tr:not(.table-head):odd").addClass("odd");

    // Hide alert
    $(".close").click(function(){
        $(this).parent().parent().fadeOut(500);
        $(".content").delay(300).animate({"marginTop" : 0});
    });

});

$(document).ready(function() {
    /*var buscarBrinde = $('#buscaBr').val();
     $('form[name="encontrarBrindes"]').submit(function () {
         var buscarBrinde = $('#buscaBr').val();

         $.ajax({
             type: 'POST',
             url: '/admin/brindes/buscar-brinde',
             data: $(this).serialize(),
             dataType: 'json',
             encode:true,
             beforeSend: function(){
                 $('#loader').fadeIn();
                 $('#resultado').fadeOut();
             }
         }).done(function(data) {
             if(data){
                 $('#loader').fadeOut();
                 $('#nome').delay(500).text(data.nome);
                 $('#email').delay(500).text(data.email);
                 $('#cep').delay(500).text(data.cep);

                 if(data.etiqueta_gerada == 1){
                     $('#etiqueta_gerada').text("Etiqueta já gerada, não é possível editar o endereço");
                     $('.enviar').hide();
                 }else{
                     $('#etiqueta_gerada').text("A etiqueta ainda não foi gerada");
                     $('.enviar').attr('href','editar?id='+data.id);
                 }

                 if(data.aprovado == 1){
                     $('#comprou').html("<p style='text-align: left;'>É aluna ou já comprou</p>");
                     $('#dataVenda').html("<p style='text-align: left;'>Data de transação: "+data.data_de_venda+"</p>");
                 }else{
                     $('#comprou').html("<p style='text-align: left;'>Não é aluna ou não comprou</p>");
                 }

                 $('#email').text(data.email);

                 if(data.enviar_kit == 1){

                 }

                 $('#notify').fadeOut();
                 $('#resultado').delay(600).fadeIn();
             }else{
                 $('#loader').fadeOut();
                 $('#notify').fadeIn(300).html("<p style='font-size:20px;'>Este contato não se encontra na base de Brindes</p><p style='font-size:18px;'><a href='/admin/brindes/add?email="+buscarBrinde+"'>Clique aqui</a> para adicionar um brinde a este contato</p>");
             }
         }).fail(function(){
             console.log("Deu erro");
         });
         event.preventDefault();
     });*/


    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
        $("#ibge").val("");
    }

    //Quando o campo cep perde o foco.
    $("#cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#uf").val("...");
                $("#ibge").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                        $("#ibge").val(dados.ibge);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });

    $(".deletarIni").click(function(){

        var conf = confirm("Deseja excluir o registro?");
        var val = $(this).attr('data-value');
        if(conf == true){
            $(location).attr('href', val);
        }
    });

    $('.notificar').click(function(){
        $(this).fadeOut();
    });

    $(window).unload(function() {
        $.ajax( {
            url: "https://mbr.digital/admin/logout/"
        });
    });

});

$(document).ready(function(){

    var ligarDepois = $('.ligarD');

    var direitoBrinde = $('.direitoBrinde');

    var kits = $('.kits');

    kits.hide();


    var valAtend = $('.pos_atendimento');


    if(valAtend.val() == 'Ligar Depois'){
        ligarDepois.show();
    }


    $('.pos_atendimento').on('change', function() {

        if(this.value == 'Ligar Depois'){

            ligarDepois.fadeIn('slow');

            kits.fadeOut();

            direitoBrinde.fadeOut('slow');

        }else

        if(this.value == 'Vendido'){

            kits.fadeIn('slow');

            ligarDepois.fadeOut('slow');

        }else

        if(this.value == 'Boleto Gerado'){

            kits.fadeIn('slow');

            ligarDepois.fadeOut('slow');

        }else{

            ligarDepois.fadeOut('slow');

            kits.fadeOut();

            direitoBrinde.fadeOut('slow')

        }



    });



    $('.kit').on('change', function() {

        if(this.value == 1){

            direitoBrinde.fadeIn('slow');


        }else{
            direitoBrinde.fadeOut('slow');

        }

    })

});





