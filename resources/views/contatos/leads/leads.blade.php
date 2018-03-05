@extends(layout())

@section('content')

    <section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">
        {!! Session::get('message')  !!}

        <h1 style="font-size:25px; font-weight: bold; margin-bottom:20px;">Leads <a href='#' id="refresher" title="Atualizar Dados"><img src="/images/refresh.svg" width="25" class="refresher" /></a></h1>

        <div class="tabs-content">

            <div class="tabs-menu">

                <ul>
                    <li><a class="active-tab-menu" href="#1" data-tab="tab1">Atender Leads</a></li>
                    <li><a href="#2" data-tab="tab2">Vendidos Não Conferidos</a></li>
                    <li><a href="#3" data-tab="tab3">Não Vendidos</a></li>
                    <li><a href="#4" data-tab="tab4">Boletos Gerados</a></li>
                    <li><a href="#5" data-tab="tab5">Ligar Depois</a></li>
                    <li><a href="#6" data-tab="tab6">Agendado</a></li>
                    <li><a href="#7" data-tab="tab7">Recuperar Boletos</a></li>
                    <li><a href="#8" data-tab="tab8">Não Atendidos</a></li>

                </ul>
            </div> <!-- tabs-menu -->


            <div class="tab1 tabs first-tab">
                <div class="widget">
                    <div class="content" ng-controller="Contatos" ng-model="Contatos">

                        <table id="myTable" border="0" width="100" >
                            <thead>
                            <tr>

                                <th class="header">Nome</th>

                                <th class="header">Telefone</th>

                                <th class="header">E-mail</th>

                                <th class="header">Meio</th>

                                <th class="header">Prioridade</th>

                                <th class="header">Responsável</th>

                                <th colspan="3"></th>

                            </tr>
                            </thead>
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                            <script>


                                $(document).ready(function() {
                                    $.ajax({
                                        url: '/uploads/em_atendimento.txt',
                                        async: true
                                    }).done(function(data) {

                                    });
                                });
                            </script>

                            @include('modalLead')
                            <tbody>
                            @foreach($contatos as $contato)

                                <tr class="" @if($contato->em_atendimento == 1) style="background:#e4e4e4; color:#ccc" disabled="" @endif>
                                    <td class="nome">{!! $contato->nome !!}</td>
                                    <td>({{$contato->ddd}}) {{$contato->telefone}}</td>
                                    <td>{{$contato->email}}</td>
                                    <td class="meio"><span>{{$contato->insercao_hotmart}}</span></td>
                                    <td>{!!$contato->prioridade!!}</td>
                                    <td>{{$contato->user_nome}}</td>
                                    <td class="acao">
                                        @if($contato->em_atendimento == 1)
                                            <p style="margin-bottom:0px;">Em atendimento</p>
                                            @else
                                            <a href="{{route('admin.atender', $contato->id)}}" class="atender">Atender</a>
                                        @endif
                                        </td>
                                    <td class="acao">
                                        <a href="{{route('admin.lead.editar', $contato->id)}}" title="Editar Contato"><img src="/images/editar.svg" width="30" class="icone"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="leads" data-nome="{{$contato->nome}}" data-email="{{$contato->email}}"
                                           data-id="{{$contato->id}}"><img src="/images/excluir.svg" width="30" class="icone del"  title="Excluir Contato" alt="[Excluir]"></a>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $contatos->links() !!}
                </div>
            </div>

            <div class="tab2 tabs">

                <?php //include(route('admin.leads.vendidos-nao-conferidos'))?>

            </div> <!-- .tab2 -->

</div>

</div><!--container de header search -->
</section>

@endsection