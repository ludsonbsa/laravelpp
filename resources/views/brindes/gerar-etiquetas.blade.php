    <table id="myTable" border="0" width="100">
        <thead>
        <tr>
            <th class="header">Nome</th>
            <th class="header">Data de Venda</th>
            <th class="header">CPF</th>
            <!--<th class="header">Produto</th>-->
            <th class="header">Responsável</th>
            <th class="header">E-mail</th>
            <th class="header" colspan="2">Ações</th>
        </tr>
        </thead>
        <tbody>

        @foreach($contatos as $contato)
            <tr class="odd">
                <td class="nome">{!! $contato->nome !!}</td>
                <td>{!! $contato->data_de_venda !!}</td>
                <td>{!! $contato->documento_usuario !!}</td>
                <!--<td>{!! $contato->nome_do_produto !!}</td>-->
                <td class="meio"><span>{!! $contato->user_nome !!}</span></td>
                <td>{!! $contato->email !!}</td>
                @if($contato->endereco != '' || !empty($contato->endereco))
                    <td><img src="/images/vcheck.png" width="25" class="icone" title="Endereço Válido"></td>
                    <td></td>
                    @else
                    <td><img src="/images/alert.png" class="icone" title="Brinde não possui endereço!" alt="Brinde não possui endereço!" width="25"></td>
                    <td><a href="{{route('admin.brindes.editar', $contato->idcontato)}}"><img src="/images/editar.svg" width="25" class="icone"></a></td>
                @endif

            </tr>
        @endforeach

        </tbody>

    </table>
    <?php
    if($contagem == 0){
        echo "<h3 style=\"font-size:18px; float:left; font-weight: 500; color:#636363; margin-left:18px; margin-top:18px;\">Nenhuma etiqueta pendente</h3>";
    }else{
    ?>

    <div class="field-wrap" style="float: right; width: auto !important;" >
        <a href="{{route('admin.brindes.criar-etiquetas')}}" class="enviar"><button class="enviar" type="submit">Gerar Etiquetas</button></a>
    </div>

    <?php
    }
    ?>

<div class="field-wrap" style="float: right;">
    <a href="{{route('admin.brindes.gerarpdf-pendentes')}}" class="enviar"><button class="enviar">Gerar PDF</button></a>
</div>

