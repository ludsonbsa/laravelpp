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
    @if(session()->has('msg'))
        <h1>{!! session('msg') !!}</h1>
    @endif
</section>
@endsection