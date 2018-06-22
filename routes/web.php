<?php
use App\Http\Middleware\Admin;
use App\Http\Middleware\Atendente;
use App\Http\Middleware\Suporte;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@showLoginForm');

Route::get('/home', 'ContatosController@index')->name('home');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
    // Authentication Routes...
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
    $this->post('login', 'Auth\LoginController@login');
    $this->post('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    $this->post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::middleware([ 'middleware' => 'auth'])->group(function () {
        Route::get('home', 'ConfigController@dashboard')->name('home');
        //LEADS
        Route::get('leads', 'ContatosController@index')->name('leads');

        Route::get('leads/vendidos-nao-conferidos', 'ContatosController@vendidos_nao_conferidos')->name('leads.vendidos-nao-conferidos');

        Route::get('leads/nao-vendidos', 'ContatosController@nao_vendidos')->name('leads.nao-vendidos');

        Route::get('leads/boletos-gerados', 'ContatosController@boletos_gerados')->name('leads.nao-vendidos');

        Route::get('leads/ligar-depois', 'ContatosController@ligar_depois')->name('leads.ligar-depois');

        Route::get('leads/recuperar-boletos', 'ContatosController@recuperar_boletos')->name('leads.recuperar-boletos');

        Route::get('leads/nao-atendidos', 'ContatosController@nao_atendidos')->name('leads.nao_atendidos');

        Route::post('leads/atender-update/{id}', 'ContatosController@atender_update')->name('leads.atender_update');

        Route::post('leads/editar-update/{id}', 'ContatosController@editar_update')->name('leads.editar-update');

        Route::post('leads/search', 'ContatosController@search')->name('leads.search');

        //Atender atribui as informações de atendente
        Route::get('leads/atender/{id}', 'ContatosController@atender')->name('atender');

        //Editar não atribui informações de quem está editando
        Route::get('leads/editar/{id}', 'ContatosController@find')->name('lead.editar');

        Route::get('leads/editar-ligar-depois/{id}', 'ContatosController@atender_ligar_depois')->name('lead.editar-ligar-depois');

        Route::post('leads/editar-update-ligar-depois/{id}', 'ContatosController@editar_update')->name('leads.editar-update-ligar-depois');

        //Editar não atribui informações de quem está editando
        Route::get('leads/deletar/{id}', 'ContatosController@deletar')->name('lead.deletar');

        //Adicionar Lead
        Route::get('leads/add/', 'ContatosController@add')->name('lead.add');
        Route::put('leads/cadastrar', 'ContatosController@cadastrar')->name('lead.cadastrar');

        #Cancelar Atendimento
        Route::get('leads/cancelar/{id}', 'ContatosController@atender_cancelar')->name('lead.cancelar');

        #Importações
        Route::get('leads/importar', 'ImportacoesController@index')->name('importar');
        Route::get('leads/recuperacao', 'ImportacoesController@recuperacao')->name('recuperacao');

        Route::post('leads/importar/upload', 'ImportacoesController@planilhaImport')
            ->name('importar.upload');

        Route::post('leads/importar/recuperacao', 'ImportacoesController@recuperacaoPlanilha')
            ->name('importar.recuperacao');

        #Leads Aprovados
        Route::get('leads/aprovados/', 'ImportacoesController@aprovados')->name('lead.aprovado');
        //FIM DE LEADS

        //COMISSOES
        Route::get('comissoes/', 'ComissoesController@conferencia')->name('comissoes.listar');
        Route::get('comissoes/conferidas', 'ComissoesController@conferidas')->name('comissoes.conferidas');
        Route::get('comissoes/conferir', 'ComissoesController@conferir')->name('comissoes.conferir');

        Route::get('comissoes/aprovar-manualmente', 'ComissoesController@aprovar_manualmente')->name('comissoes.aprovar_manualmente');

        Route::get('comissoes/comissionar-pendentes', 'ComissoesController@comissionar_pendentes')->name('comissoes.comissionar_pendentes');

        Route::get('comissoes/relatorio', 'ComissoesController@relatorio')->name('comissoes.relatorio');

        Route::get('comissoes/geradas', 'ComissoesController@geradas')->name('comissoes.geradas');

        Route::get('comissoes/aprovar/{id}', 'ComissoesController@aprovar')->name('comissoes.aprovar');

        Route::get('comissoes/reprovar/{id}', 'ComissoesController@reprovar')->name('comissoes.reprovar');

        Route::post('comissoes/comissionar', 'ComissoesController@comissionar')->name('comissoes.comissionar');

        Route::get('comissoes/relatorio-pendente', 'ComissoesController@relatorio_comissinar_pendente')->name('comissoes.relatorio-pendente');

        /****************USUÁRIOS****************/
        Route::get('usuarios/listar', 'UserController@index')->name('listar.usuarios');
        Route::put('usuarios/cadastrar', 'UserController@cadastrar')->name('cadastrar.usuarios');

        Route::get('usuarios/add', 'UserController@add')->name('add.usuarios');

        Route::get('usuarios/editar/{id}', 'UserController@editar')->name('editar.usuario');

        Route::post('usuarios/editar-update/{id}', 'UserController@editar_update')->name('editar-update.usuario');

        Route::post('usuarios/cadastrar_senha/{id}', 'UserController@cadastrar_senha')->name('cadastrar_senha.usuario');

        Route::get('usuarios/status/{status}/{id}', [
            'uses' => 'UserController@status',
        ])->name('status');

        Route::get('usuarios/excluir/{id}', 'UserController@excluir')->name('excluir');

        /********* BRINDES ********/
        Route::get('brindes/listar', 'BrindesController@index')->name('listar.brindes');
        Route::post('brindes/conferir-brinde', 'BrindesController@conferir_brinde')->name('listar.conferir-brinde');

        Route::get('brindes/resultado-conferencia', 'BrindesController@resultado_conferencia')->name('brindes.resultado-conferencia');

        Route::get('brindes/baixar-etiquetas', 'BrindesController@baixar_etiquetas')->name('brindes.baixar_etiqueta');

        Route::get('brindes/aprovar-manualmente', 'BrindesController@aprovar_manualmente')->name('brindes.aprovar-manualmente');

        Route::get('brindes/gerar-etiquetas', 'BrindesController@gerar_etiquetas')->name('brindes.gerar_etiquetas');

        Route::get('brindes/etiquetas/deletar/{etiqueta}', 'BrindesController@deletar_etiqueta')->name('brindes.deletar_etiqueta');

        Route::get('brindes/etiquetas/baixar/{etiqueta}', 'BrindesController@baixar')->name('brindes.baixar_etiqueta');

        Route::get('brindes/add', 'BrindesController@add')->name('brindes.add');
        Route::put('brindes/cadastrar', 'BrindesController@cadastrar')->name('brindes.cadastrar');
        Route::get('brindes/editar/{id}', 'BrindesController@editar')->name('brindes.editar');
        Route::post('brindes/editar-update/{id}', 'BrindesController@editar_update')->name('brindes.editar-update');

        Route::get('brindes/buscar', 'BrindesController@buscar')->name('brindes.buscar');

        Route::post('brindes/buscar-brinde','BrindesController@buscar_brinde')->name('brindes.buscar-brinde');

        Route::get('brindes/conferir', 'BrindesController@conferirBrindes')->name('brindes.conferir');

        Route::get('brindes/criar-etiquetas', 'BrindesController@criar_etiquetas')->name('brindes.criar-etiquetas');

        Route::get('brindes/gerarpdf-pendente', 'BrindesController@gerarpdf_pendentes')->name('brindes.gerarpdf-pendentes');

        Route::get('brindes/gerarpdf-aprovarmanual', 'BrindesController@aprovar_manualmente_pdf')->name('brindes.gerarpdf-aprovarmanual');

        Route::get('brindes/aprovar/{id}', 'BrindesController@aprovar')->name('brindes.aprovar');

        Route::get('brindes/reprovar/{id}', 'BrindesController@reprovar')->name('brindes.reprovar');



        /*************************** LIVRO BRINDE ***************************************************/

        Route::get('livro/listar', 'LivroBrindeController@index')->name('listar.livro');
        Route::post('livro/conferir-brinde', 'BrindesController@conferir_brinde')->name('listar.conferir-livro');

        Route::get('livro/resultado-conferencia', 'LivroBrindeController@resultado_conferencia')->name('livro.resultado-conferencia');

        Route::get('livro/baixar-etiquetas', 'LivroBrindeController@baixar_etiquetas')->name('livro.baixar_etiqueta');

        Route::get('livro/aprovar-manualmente', 'LivroBrindeController@aprovar_manualmente')->name('livro.aprovar-manualmente');

        Route::get('livro/gerar-etiquetas', 'LivroBrindeController@gerar_etiquetas')->name('livro.gerar_etiquetas');

        Route::get('livro/etiquetas/deletar/{etiqueta}', 'LivroBrindeController@deletar_etiqueta')->name('livro.deletar_etiqueta');

        Route::get('livro/etiquetas/baixar/{etiqueta}', 'LivroBrindeController@baixar')->name('livro.baixar_etiqueta');

        Route::get('livro/add', 'LivroBrindeController@add')->name('livro.add');
        Route::put('livro/cadastrar', 'LivroBrindeController@cadastrar')->name('livro.cadastrar');
        Route::get('livro/editar/{id}', 'LivroBrindeController@editar')->name('livro.editar');
        Route::post('livro/editar-update/{id}', 'LivroBrindeController@editar_update')->name('livro.editar-update');

        Route::get('livro/buscar', 'LivroBrindeController@buscar')->name('livro.buscar');

        Route::post('livro/buscar-brinde','LivroBrindeController@buscar_brinde')->name('livro.buscar-brinde');

        Route::get('livro/conferir', 'LivroBrindeController@conferirBrindes')->name('livro.conferir');

        Route::get('livro/criar-etiquetas', 'LivroBrindeController@criar_etiquetas')->name('livro.criar-etiquetas');

        Route::get('livro/gerarpdf-pendente', 'LivroBrindeController@gerarpdf_pendentes')->name('livro.gerarpdf-pendentes');

        Route::get('livro/gerarpdf-aprovarmanual', 'LivroBrindeController@aprovar_manualmente_pdf')->name('livro.gerarpdf-aprovarmanual');

        Route::get('livro/aprovar/{id}', 'LivroBrindeController@aprovar')->name('livro.aprovar');

        Route::get('livro/reprovar/{id}', 'LivroBrindeController@reprovar')->name('livro.reprovar');

        Route::post('livro/buscar-brinde/', 'LivroBrindeController@buscar_livro')->name('livro.buscar-livro');

    /*********CONFIG********/
    Route::get('config', 'ConfigController@index')->name('config');
    Route::get('dashboard', 'ConfigController@dashboard')->name('dashboard');
    });

    /****************************************SUPORTE********************************************/

    /*******EXTERNO***********/
    Route::any('infusion/', 'HomeController@infusion')->name('infusion');
    Route::any('brinde/wb-pp/', 'HomeController@wb_brinde')->name('webnario');
    Route::any('brinde/pp/',  'HomeController@brinde_pp')->name('brinde-pp');
    Route::any('hotmart/', 'HomeController@hotmart')->name('hotmart');
    Route::any('form-hotmart/', 'HomeController@form_hotmart')->name('formhotmart');

    Route::get('form/', 'HomeController@form')->name('infusion.form');

});

