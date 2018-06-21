@extends(layout())

@section('content')

<section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">
        <h1 style="font-size:25px; font-weight: bold; margin-bottom:20px;">Comissões<a href='#' id="refresher" title="Atualizar Dados"><img src="/images/refresh.svg" width="25" class="refresher" /></a></h1>

        <div class="tabs-content">
            <div class="tabs-menu">
                <ul>
                    <li><a class="active-tab-menu" href="#1" data-tab="com-tab1">Conferir Vendas</a></li>
                    <li><a href="#3" data-tab="com-tab3">Aprovar Manualmente</a></li>
                    <li><a href="#4" data-tab="com-tab4">Comissionar Pendentes</a></li>
                    <li><a href="#5" data-tab="com-tab5">Comissões Geradas</a></li>
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
                                    <th class="header">Meio de Inserção</th>
                                    <th class="header">E-mail</th>
                                </tr>
                            </thead>
                        <tbody>

                        @foreach($contatos as $contato)
                        <tr class="odd">
                            <td class="nome">{!!$contato->nome!!}</td>
                            <td>{!! $contato->ddd!!} {!!$contato->telefone !!}</td>
                            <td>{!! $contato->insercao_hotmart !!}</td>
                            <td>{!! $contato->email !!}</td>
                        </tr>
                         @endforeach

                        </tbody>
                        </table>

                        <div class="field-wrap" style="float:right; margin-top:0px; padding:17px; width:96.75%;">
                            <h3 style="font-size:18px; float:left; font-weight: 500; color:#636363; margin-top:8px;">Você precisa conferir {{$count}} vendas</h3>
                            <a href="{{route('admin.comissoes.conferir')}}"> <button type="submit" name="" class="enviar">Conferir Vendas</button></a>
                        </div>
                     </form>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection