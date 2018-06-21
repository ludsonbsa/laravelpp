@extends(layout())

@section('content')
<section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">

    <h1 style="font-size:25px; font-weight: bold; color:#636363; margin-bottom:20px;">Adicionar Brinde</h1>
    <section class="widget" style="min-height:560px;">
        @if(session()->has('msg'))
            <div class='alert alert-success'>
                {!! session('msg') !!}
            </div>
        @elseif(session()->has('msg-error'))
            <div class='alert alert-danger'>
                {!! session('msg-error') !!}
            </div>
        @endif
        <div class="faixa"></div>

        <br>

        <form name="formulario" action="{{route('admin.brindes.cadastrar')}}" method="post" enctype="multipart/form-data">


            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{csrf_token()}}">

            <div class="content">
            <input type="hidden" name="data_de_venda" value="{{date('d/m/Y H:i:s')}}" />
                <div class="field-wrap t70">

                    <label>Nome Completo:</label>

                    <input type="text" name="nome" required class="t100">

                </div>

                <div class="field-wrap t25">

                    <label>CPF:</label>

                    <input type="text" name="documento_usuario" class="t100" required>

                </div>

                <div class="field-wrap t40">

                    <label>E-mail:</label>

                    <input type="text" name="email" required class="t100">

                </div>

                <div class="field-wrap t30">

                    <label>Telefone:</label>

                    <input type="hidden" name="ddd" value="">

                    <input type="hidden" name="conferencia" value="1">

                    <input type="hidden" name="enviar_kit" value="1">

                    <input type="hidden" name="insercao_hotmart" value="Add Brinde">

                    <input type="text" name="telefone" class="t100">

                </div>

                <div class="field-wrap t22">

                    <label>CEP:</label>

                    <input type="text"  required name="cep" size="10" maxlength="9"id="cep" class="t100" value="" onblur="pesquisacep(this.value);">

                </div>

                <div class="field-wrap t20">

                    <label>Estado:</label>

                    <input type="text" name="estado" id="uf" class="t100">

                </div>


                <div class="field-wrap t30">

                    <label>Cidade:</label>

                    <input type="text" name="cidade" required id="cidade" class="t100" value="">


                </div>

                <div class="field-wrap t42">

                    <label>Bairro:</label>

                    <input type="text" name="bairro" required id="bairro" class="t100" value="">

                </div>

                <div class="field-wrap t85">

                    <label>Endereço:</label>

                    <input type="text" name="endereco" required id="rua"  class="t100" value="">

                </div>

                <div class="field-wrap t10">

                    <label>Número:</label>

                    <input type="text" name="numero" required class="t100" value="">

                </div>

                <div class="field-wrap t96">

                    <label>Complemento:</label>

                    <input type="text" name="complemento" class="t100" value="">

                </div>

            </div>

            <div class="field-wrap t94">
                <button type="submit" name="sendForm" class="enviar">Inserir Brinde</button>
            </div>

        </form>


    </section>

</section>
@endsection