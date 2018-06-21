@extends(layout())

@section('content')
    <section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">
        {!! Session::get('message')  !!}
        <h1 style="font-size:25px; font-weight: bold; color:#636363; margin-bottom:20px;">Editar Brinde Webnário</h1>

        <section class="widget" style="min-height:560px;">

            <div class="faixa"></div>

            <br>
            @foreach($brindes as $brinde)

            <form name="formulario" action="{{route('admin.livro.editar-update', $brinde->id)}}" method="post" enctype="multipart/form-data">

                <input type="hidden" name="_token" value="{{csrf_token()}}">

                <div class="content">
                    <div class="field-wrap t70">

                        <label>Nome Completo:</label>

                        <input type="text" name="nome" required class="t100"  value="{!! $brinde->nome !!}">

                    </div>

                    <div class="field-wrap t25">

                        <label>CPF:</label>

                        <input type="text" name="documento_usuario" class="t100" value="{!! $brinde->documento_usuario !!}">

                    </div>

                    <div class="field-wrap t40">

                        <label>E-mail:</label>

                        <input type="text" name="email" required class="t100" value="{!! $brinde->email !!}">

                    </div>

                    <div class="field-wrap t30">

                        <label>Telefone:</label>

                        <input type="text" name="ddd" class="t30" value="{!! $brinde->ddd !!}">

                        <input type="text" name="telefone" class="t60" value="{!! $brinde->telefone !!}">

                    </div>

                    <div class="field-wrap t22">

                        <label>CEP:</label>

                        <input type="text"  required name="cep" size="10" maxlength="9" id="cep" class="t100" value="{!! $brinde->cep !!}">

                    </div>

                    <div class="field-wrap t20">

                        <label>Estado:</label>
                        <input type="text" name="estado" maxlength="2" id="uf" class="t100" value="{!! $brinde->estado !!}" placeholder="Digite apenas o UF">

                    </div>


                    <div class="field-wrap t30">

                        <label>Cidade:</label>

                        <input type="text" name="cidade" required id="cidade" class="t100" value="{!! $brinde->cidade !!}">


                    </div>

                    <div class="field-wrap t42">

                        <label>Bairro:</label>

                        <input type="text" name="bairro" required id="bairro" class="t100" value="{!! $brinde->bairro !!}">

                    </div>

                    <div class="field-wrap t85">

                        <label>Endereço:</label>

                        <input type="text" name="endereco" required id="rua"  class="t100" value="{!! $brinde->endereco !!}">

                    </div>

                    <div class="field-wrap t10">

                        <label>Número:</label>

                        <input type="text" name="numero" required class="t100" value="{!! $brinde->numero !!}">

                    </div>

                    <div class="field-wrap t96">

                        <label>Complemento:</label>

                        <input type="text" name="complemento" class="t100" value="{!! $brinde->complemento !!}">

                    </div>

                </div>

                <div class="field-wrap t94">
                    <button type="submit" name="sendForm" class="enviar">Atualizar Brinde</button>
                </div>
            @endforeach
            </form>


        </section>

    </section>
@endsection