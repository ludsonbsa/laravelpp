@extends(layout())

@section('content')

    @foreach($usuario as $user)
<section class="content" style="background:url('/images/bglead.jpg') repeat-x #f0f0f0;">

    <h1 style="font-size:25px; font-weight: bold; color:#636363; margin-bottom:20px;">Editar Usuário</h1>

    @if(session()->has('msg'))
        <div class='alert alert-success'>
            {!! session('msg') !!}
        </div>
    @elseif(session()->has('msg-error'))
        <div class='alert alert-danger'>
            {!!  session('msg-error') !!}
        </div>
    @endif

    <section class="widget" style="min-height:700px;">

        <div class="faixa"></div>

        <br>

        <div class="content">

            <form name="formulario" action="{{route('admin.editar-update.usuario', $user->id)}}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="field-wrap t30">

                    <img src="{{$user->avatar}}" width="308" height="308" class="perfilEdit avatar" />

                    <label for="upload" id="forup" class="forup">Selecionar um arquivo &#187;</label>

                    <input type="file" name="avatar" id="upload" class="upload" style="display:none;">

                    <img src="/images/alerticon.png" style="margin:8px 5px; float:left"/>

                    <p style="color:#ccc" class="t100">A imagem escolhida deve estar no formato JPG, PNG ou GIF, com no máximo 1 MB de tamanho.</p>

                </div>

                <div class="field-wrap t60">

                    <br>

                    <p style="margin-left:12px;">Seu nível de usuário atual é: {!!$user->role_name!!} <span style="color:#ff7659"></span> <img src="/images/nivel.svg" width="16" style="margin-bottom:-5px; margin-left:10px; position:relative"/></p>



                    <div class="field-wrap t100">

                        <p>Nome Completo:</p>

                        <input type="text" name="user_nome" class="t100" required value="{!! $user->user_nome  !!}" placeholder="">
                    </div>



                    <div class="field-wrap t100">

                        <p>E-mail:</p>

                        <input type="email"  class="t100" required style="color:#e1e1e1;" name="email" value="{{$user->email}}" @if(\Auth::user()->role != 1) readonly @endif placeholder="">

                    </div>

                    <input type="hidden" name="role" value="{{$user->role}}" />
                    <input type="hidden" name="status" value="{{$user->status}}" />

                    @if(\Auth::user()->role == 1)

                    <div class="field-wrap t100">

                        <p>Nível</p>

                        <br>

                        <select name="role" class="t100">

                            @switch($user->role)
                                @case(1)
                                {{ $roleValue = 1 }}
                                {{ $roleName = "Administrador" }}
                                @break

                                @case(2)
                                {{ $roleValue = 2 }}
                                {{ $roleName = "Responsável" }}
                                @break

                                @case(3)
                                {{ $roleValue = 3 }}
                                {{ $roleName = "Atendente" }}
                                @break

                                @case(4)
                                {{ $roleValue = 4 }}
                                {{ $roleName = "Suporte" }}
                                @break

                                @case(5)
                                {{ $roleValue = 5 }}
                                {{ $roleName = "Aux. Admin" }}
                                @break

                                @case(6)
                                {{ $roleValue = 6 }}
                                {{ $roleName = "At. Temporário" }}
                                @break


                            @endswitch

                            <option selected="selected" value="{!! $roleValue !!}"> {!! $roleName; !!}</option>

                            <option disabled>================</option>

                            <option value="1">Administrador</option>

                            <option value="2">Responsável</option>

                            <option value="3">Atendente</option>

                            <option value="4">Suporte</option>

                            <option value="5">At. Temporário</option>

                            <option value="6">At. Temporário</option>

                        </select>

                    </div>

                    <div class="field-wrap t100">

                        <p>Status</p>

                        <br>
                        <select name="status" class="t100">
                            @if($user->status == 1)
                                {{ $statusValue = 1 }}
                                {{ $status = "Ativo" }}
                            @else
                                {{ $statusValue = 0 }}
                                {{ $status = "Inativo" }}
                            @endif
                            <option selected="selected" value="{!! $statusValue !!}">{!! $status !!}</option>

                            <option disabled>================</option>

                            <option  value="1">Ativo</option>

                            <option value="0">Inativo</option>

                        </select>

                    </div>

                    @endif
                    <br>

                    <div class="field-wrap t100">
                        <button type="submit" name="sendForm" class="enviar">Editar Usuário</button>
                    </div>

                </div><!-- final da sessao field wrap -->

            </form>


            <div class="field-wrap t100" style="margin-left:-110px;">
                <a href="#" class="senhas"><button class="enviar">Cadastrar Nova Senha</button></a>
            </div>
            @include('modalSenha')

        </div>

    </section>

</section>
    @endforeach
@endsection