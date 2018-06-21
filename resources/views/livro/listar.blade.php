@extends(layout())

@section('content')
<section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">
    <h1 style="font-size:25px; font-weight: bold; margin-bottom:20px;">Conferência de KIT Webnário<a href='#' id="refresher" title="Atualizar Dados"><img src="/images/refresh.svg" width="25" class="refresher" /></a></h1>


    <div class="tabs-content">

        <div class="tabs-menu">
                <ul>
                    <li><a class="active-tab-menu" href="#1" data-tab="livro-tab1">Conferir Livros</a></li>
                    <li><a href="#3" data-tab="livro-tab3">Aprovar Manualmente</a></li>
                    <li><a href="#4" data-tab="livro-tab4">Gerar Etiquetas Pendentes</a></li>
                    <li><a href="#5" data-tab="livro-tab5">Baixar Etiquetas</a></li>
                </ul>
            </div> <!-- tabs-menu -->

            <div class="tab1 tabs first-tab">

                <div class="widget">
                    <div class="content">

                    <table id="myTable" border="0" width="100">

                    <thead>
                    <tr>
                        <th class="header">Nome</th>
                        <th class="header">Telefone</th>
                        <th class="header">Meio de Inserção</th>
                        <th class="header">E-mail</th>
                        <th class="header">Responsável</th>
                        <th class="header" colspan="2">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @include('modalLead')

                        @foreach($brindes as $brinde)
                        <tr class="odd">

                            <td class="nome">{!!$brinde->nome!!}</td>
                            <td>({{$brinde->ddd}}) {{$brinde->telefone}}</td>
                            <td>{!!$brinde->insercao_hotmart!!}</td>
                            <td>{!!$brinde->email!!}</td>
                            <td>{!!$brinde->user_nome!!}</td>


                            @if(Auth::user()->role == 1 || Auth::user()->id == $brinde->id_responsavel)

                            @endif

                            @if(Auth::user()->role == 1 || Auth::user()->role == 4 || Auth::user()->role == 3)
                                <td class="acao">
                                    <a href="{{route('admin.livro.editar', $brinde->id)}}" title="Editar Contato"><img src="/images/editar.svg" width="30" class="icone"></a>
                                </td>
                            @endif

                            @if(Auth::user()->role == 1 || Auth::user()->id == $brinde->id_responsavel)
                                <td>
                                    <a href="#" class="leads" data-nome="{{$brinde->nome}}" data-email="{{$brinde->email}}"
                                       data-id="{{$brinde->id}}"><img src="/images/excluir.svg" width="30" class="icone del"  title="Excluir Contato" alt="[Excluir]"></a>
                                </td>
                            @else
                                <td class="acao"></td>
                            @endif





                        </tr>
                        @endforeach

                    </tbody>

                </table>

                {!! $brindes->links() !!}
                        @if(Auth::user()->role == 1 || Auth::user()->role == 4)
                <div class="field-wrap" style="float:right; margin-top:0px; padding:17px; width:100%;">
                    <h3 style="font-size:18px; float:left; font-weight: 500; color:#636363; margin-top:8px;">Você precisa conferir {{$brindes->total()}}  brindes</h3>
                    <a href="{{route('admin.livro.conferir')}}"><button type="submit" name="enviaQueryBrinde" class="enviar">Conferir Brindes</button></a>
                </div>
                        @endif
                    </div>
                </div>



            </div>

        </div><!--container de header search -->
</section>
@endsection