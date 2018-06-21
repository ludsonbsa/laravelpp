<form action="{{route('admin.comissoes.comissionar')}}" name="enviarQueries" method="post">

<table id="myTable" border="0" width="100">
    <thead>
    <tr>
        <th class="header">Nome</th>
        <th class="header">CPF</th>
        <th class="header">Telefone</th>
        <th class="header">Data de Venda</th>
        <th class="header">Produto</th>
        <th class="header">E-mail</th>
    </tr>
    </thead>
    <tbody>

        @foreach($contatos as $contato)

        <tr class="odd">

            <td class="nome">{!! $contato->nome !!}</td>
            <input type="hidden" name="nome" value="{!! $contato->nome !!}">
            <td>{!! $contato->documento_usuario !!}</td>
            <input type="hidden" name="documento_usuario" value="{!! $contato->documento_usuario !!}">
            <td>{!! $contato->telefone !!}</td>
            <input type="hidden" name="telefone" value="{!! $contato->telefone !!}">
            <td>{!! $contato->data_de_venda !!}</td>
            <td>{!! $contato->nome_do_produto !!}</td>
            <td>{!! $contato->email !!}</td>
            <input type="hidden" name="email" value="{!! $contato->email !!}">


        </tr>
        @endforeach

    </tbody>

</table>
<?php
if($contagem == 0){
    echo "<h3 style=\"font-size:18px; float:left; font-weight: 500; color:#636363; margin-left:18px; margin-top:18px; padding:17px;\">Nenhuma venda pendente</h3>";
}else{
    ?>
    <h3 style="font-size:18px; float:left; font-weight: 500; color:#636363; margin-top:8px; padding:17px;">Você precisa comissionar {{$contagem}} venda(s)</h3>
    <div class="field-wrap" style="float: right;">
        <a href="{{route('admin.comissoes.relatorio-pendente')}}" class="enviar"><button class="enviar">Gerar PDF</button></a> &nbsp;
        <button class="enviar" type="submit">Comissionar Vendas</button>
    </div>


<?php
}
?>
</form>

