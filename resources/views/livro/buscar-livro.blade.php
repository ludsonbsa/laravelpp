@extends(layout())

@section('content')
    <section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">

        <h1 style="font-size:25px; font-weight: bold; color:#636363; margin-bottom:20px;">Buscar Kit Webnário</h1>

        <section class="widget" style=" height:160px;">

            <div class="faixa"></div>

            <br>

            <form action="{{route('admin.livro.buscar-livro')}}" name="encontrarBrinde" id="brindeFind" method="post">
                {!! csrf_field() !!}
                <div class="field-wrap t96">
                    <label>Digite o E-mail:</label>
                    <br>
                    <input type="search" required id="buscaBr" class="t96" style="padding:12px;" name="buscarBrinde" placeholder="Digite o e-mail ou cep do contato...">
                </div>
            </form>

        </section>

        <section id="resultado">

            <h1 style="font-size:25px; font-weight: bold;" id=""></h1>
            <br><br>

            @foreach($brindes as $brinde)
                <div class="field-wrap floatLeft dentro" style="width:40%; padding-right:30px; border-right: 2px solid #dbdbdb;">

                    <img src="/images/perfil.png" class="perfil floatLeft" />
                    <div class="field-wrap floatRight t55">
                        <br>

                        <p style="color:#ff8169; font-size:24px; line-height: 25px;" id="nome"><b></b>{!! $brinde->nome !!}</p>
                        <p><small id="email">{!! $brinde->email !!}</small></p>
                        <p><small id="cep"><b>CEP: </b>{!! $brinde->cep !!}</small></p>
                        <p><small id="estado"><b>Estado: </b>{!! $brinde->estado !!}</small></p>
                        <p><small id="cidade"><b>Cidade: </b>{!! $brinde->cidade !!}</small></p>
                        <p><small id="endereco"><b>Endereço: </b>{!! $brinde->endereco !!}</small></p>
                        <p><small id="bairro"><b>Bairro: </b>{!! $brinde->bairro !!}</small></p>
                        <p><small id="numero"><b>Número: </b>{!! $brinde->numero !!}</small></p>
                        <p><small id="complemento"><b>Complemento: </b>{!! $brinde->complemento !!}</small></p>

                        @if($brinde->aprovado == 1)
                            <p id="comprou">É aluna ou já comprou</p>
                        @else
                            <p id="comprou">Não é aluna ou não comprou</p>
                        @endif

                        <p id="dataVenda"><b>Data de Transação: </b>{!! $brinde->data_de_venda !!}</p>
                    </div>
                </div>
                <div class="field-wrap t45">
                    <br><br>
                    @if($brinde->etiqueta_gerada == 0)
                        <p id="etiqueta_gerada" style="font-weight: bold; line-height: 30px; text-align: center; font-size:26px; color:#878787;">A etiqueta ainda não foi gerada</p>

                        <a href="{{route('admin.livro.editar', $brinde->id)}}" class="enviar"><button class="enviar t96">Você pode editar este endereço</button></a>
                    @else
                        <p id="etiqueta_gerada" style="font-weight: bold; line-height: 30px; text-align: center; font-size:26px; color:#878787;">A etiqueta já foi gerada, não é possível editar este endereço.</p>
                    @endif

                    <br>
                </div>
        </section>
        @endforeach

    </section>
@endsection