@extends(layout())

@section('content')
<section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">

    {!! Session::get('message')  !!}

    <h1 style="font-size:25px; font-weight: bold; color:#636363; margin-bottom:20px;">Adicionar Contato</h1>

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
        <div class="content">

            <form name="formulario" action="{{route('admin.lead.cadastrar')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="data_de_venda" value="{{date('d/m/Y H:i:s')}}" />
                <input type="hidden" name="id_responsavel" value="{{Auth::id()}}">

                <div class="field-wrap t60">
                    <label>Nome:</label>
                    <input type="text" name="nome" value="" class="t100" placeholder="" required="required">
                </div>

                <div class="field-wrap t10">
                    <label>DDI+DDD:</label>
                    <input type="tel" id="ddd" maxlength="4" name="ddd" class="t90" required="required" placeholder="Ex.:61">

                </div>

                <div class="field-wrap t20">
                    <label>Telefone:</label>
                    <input type="text" id="telefone" name="telefone" maxlength="9" class="t90" required="required" placeholder="">
                </div>


                <div class="field-wrap t60">
                    <label>E-mail:</label>
                    <input type="email" name="email" required value="" class="t100 mailverify" placeholder="">
                </div>


                <div class="field-wrap t30">
                    <label>Meio de inserção:</label>
                    <br>
                    <select name="insercao_hotmart" required>
                        <option value="Chat">Chat</option>
                        <option value="Whatsapp">Whatsapp</option>
                        <option value="E-mail">E-mail</option>
                        <option value="Facebook">Facebook</option>
                    </select>
                </div>


                <div class="field-wrap t50">
                    <label>Produto:</label>
                    <br>

                    <select name="nome_do_produto" required>
                    @foreach($produtos as $produto)
                        <option value="{!! $produto->prod_nome_do_produto !!}">{!!$produto->prod_nome_do_produto!!}</option>
                    @endforeach
                    </select>
                </div>

                <div class="field-wrap t40">
                    <label>Prioridade:</label>
                    <br>
                    <select name="prioridade" required>
                        <option value="Dúvidas sobre como pagar">Dúvidas sobre como pagar</option>
                        <option value="Dúvidas profundas sobre o curso">Dúvidas profundas sobre o curso</option>
                    </select>
                </div>


                <div class="field-wrap t94">
                    <label>Observações sobre o pedido: </label>
                    <br><br>
                    <textarea name="observacao"></textarea>
                </div>

                <div class="field-wrap t94">
                    <button type="submit" name="sendForm" class="enviar">Inserir Contato</button>
                </div>

            </form>
        </div>
    </section>

</section>

<script>
    $(function(){
        $('.mailverify').focusOut(function(){
            alert('SAiu o foco');
        });
    });
</script>
@endsection