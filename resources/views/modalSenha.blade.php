<div class="modal modalsenha" id="confirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('admin.cadastrar_senha.usuario', $user->id)}}" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" style="font-weight: bold;">Cadastrar Nova Senha para: <strong>{!!
                    $user->user_nome  !!}</strong></h4>
                </div>
                <div class="modal-body">
                    <input type="password" name="password" placeholder="Digite a nova senha" required>
                    <input type="password" name="confirm_password" placeholder="Confirmação de senha" required>
                </div>
                <div class="modal-footer">
                    <a href="#" class="dataRoute"><button type="submit" class="btn btn-success" id="cadastrarSenha" data-route="">Cadastrar Senha</button></a>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>