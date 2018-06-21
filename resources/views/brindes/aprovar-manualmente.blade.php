<table id="myTable" border="0" width="100">
    <thead>
    <tr>
        <th class="header">Nome</th>
        <th class="header">CPF</th>
        <th class="header">Telefone</th>
        <th class="header">E-mail</th>
        <th class="header">Produto</th>
        <th class="header">Atendente</th>
        <th class="header" colspan="2">Ações</th>
    </tr>
    </thead>
    <tbody>

    @foreach($brindes as $contato)
        <tr class="odd {!! $contato->id !!}">
            <td class="nome">{!! $contato->nome !!}</td>
            <td>{!! $contato->documento_usuario !!}</td>
            <td>{!! $contato->telefone !!}</td>
            <td>{!! $contato->email !!}</td>
            <td>{!! $contato->nome_do_produto !!}</td>
            <td>{!! $contato->user_nome !!}</td>
            <td>
                <a href="#" class="reprovar" data-id="{!! $contato->id !!}"><img src="/images/reprovar.svg" title="Reprovar" alt="[Reprovar]" class="icone" width="50" /></a>
            </td>
            <td>
                <a href="#" class="aprovar" data-id="{!! $contato->id !!}"><img src="/images/aprovar.svg" title="Aprovar" alt="[Aprovar]" class="icone" width="50" /></a></td>

        </tr>
    @endforeach

    </tbody>
</table>

@if($contagem != 0)
    <h3 style="font-size:18px; float:left; font-weight: 500; color:#636363; margin-top:8px; padding:17px;">Você precisa aprovar/reprovar {{$contagem}}  brindes</h3>
    <div class="field-wrap" style="float: right;">

        <a href="{{route('admin.brindes.gerarpdf-aprovarmanual')}}" class="enviar"><button class="enviar">Gerar PDF</button></a>
    </div>
    @else
    <h3 style="font-size:18px; float:left; font-weight: 500; color:#636363; margin-top:8px; padding:17px;">Nada para aprovar/reprovar</h3>
@endif


<script>
    $(function(){
        $('.reprovar').click(function(){

            var id = $(this).attr('data-id');
            var url = '/admin/brindes/reprovar/'+id;
            var vai = $('.'+id);

            $.ajax({
                url: url,
                beforeSend: function() {
                    vai.css('transition','all 1s');
                    vai.css('opacity','0.3');
                }
            }).done(function() {
                //Pega o attr do tr pra sumir!
                vai.css('opacity','0');
                vai.fadeOut('slow');
            });
            return false;
        });

        $('.aprovar').click(function(){

            var id = $(this).attr('data-id');
            var url = '/admin/brindes/aprovar/'+id;
            var vai = $('.'+id);

            $.ajax({
                url: url,
                beforeSend: function() {
                    vai.css('transition','all 1s');
                    vai.css('opacity','0.3');
                }
            }).done(function() {
                //Pega o attr do tr pra sumir!
                vai.css('opacity','0');
                vai.fadeOut('slow');
            });
            return false;
        });


    });
</script>