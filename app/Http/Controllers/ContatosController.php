<?php

namespace App\Http\Controllers;

use App\Contatos;
use App\Helpers\Permissoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\User;
use App\Notifications\NotifyContato;


class ContatosController extends Controller
{
    public function index(Request $request){

        $lead = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.data_de_venda, t1.nome,t1.ddd, t1.telefone, t1.email, t1.obs_followup, t1.observacao, t1.status, t1.documento_usuario, t1.nome_do_produto, t1.em_atendimento, t1.em_atendendo, t1.insercao_hotmart, t1.prioridade, t1.id_responsavel, t2.user_nome, t2.avatar")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereNull('t1.aprovado')
            ->whereNotNull('t1.email')
            ->where('t1.email','!=', '')
            ->whereNull('t1.pos_atendimento')
            ->whereNotNull('t1.telefone')
            ->where('t1.telefone', '!=','')
            ->whereNotIn('t1.status',['Aprovado', 'Completo','Boleto Impresso', 'Boleto Gerado'])
            ->groupBy('t1.email')
            ->orderBy('t1.id','DESC')
            ->paginate(100);

        return view('contatos.leads.leads', ['contatos' => $lead]);
    }

    public function vendidos_nao_conferidos(){

        if(Auth::user()->role == 1 || Auth::user()->role == 4){
            $lead = DB::table('tb_atendimento as t1')
                ->selectRaw("t1.at_id, t2.nome_do_produto, t1.at_nome_atendente, t1.at_inicio_atendimento, t1.at_final_atendimento, t2.id, t2.nome, t2.ddd, t2.telefone, t2.email, t2.status, t2.insercao_hotmart, t2.pos_atendimento, t2.id_responsavel")
                ->join('tb_contatos as t2','t1.at_id_contato','=','t2.id')
                ->whereRaw("t2.pos_atendimento = 'Vendido' AND t2.conferencia = 0 AND t1.at_nome_atendente != 'Sistema'")
                ->orderBy('t1.at_final_atendimento','DESC')
                ->get();

        }elseif(Auth::user()->role >= 3){
            $lead = DB::table('tb_atendimento as t1')
                ->selectRaw("t1.at_id, t2.nome_do_produto, t1.at_nome_atendente, t1.at_id_responsavel, t1.at_inicio_atendimento, t1.at_final_atendimento, t2.id, t2.nome, t2.ddd,  t2.telefone, t2.email, t2.status, t2.insercao_hotmart, t2.obs_followup, t2.pos_atendimento, t2.id_responsavel")
                ->join('tb_contatos as t2','t1.at_id_contato','=','t2.id')
                ->whereRaw("(t2.pos_atendimento = 'Vendido' AND t2.conferencia = 0 ) AND t1.at_nome_atendente != 'Sistema' AND t1.at_id_responsavel = ".Auth::user()->id)
                ->orderBy('t1.at_final_atendimento','DESC')
                ->get();

        }elseif(Auth::user()->role == 2){

            $lead = DB::table('tb_atendimento as t1')
                ->selectRaw("t1.at_id, t2.nome_do_produto, t1.at_nome_atendente, t1.at_id_responsavel, t1.at_inicio_atendimento, t1.at_final_atendimento, t2.id, t2.nome, t2.ddd,  t2.telefone, t2.email, t2.status, t2.insercao_hotmart, t2.obs_followup, t2.pos_atendimento, t2.id_responsavel")
                ->join('tb_contatos as t2','t1.at_id_contato','=','t2.id')
                ->whereRaw("(t2.pos_atendimento = 'Vendido' AND t2.conferencia = 0 ) AND t1.at_nome_atendente != 'Sistema' AND t2.id_responsavel =  ".Auth::user()->id)
                ->orderBy('t1.at_final_atendimento','DESC')
                ->get();
        }


        return view('contatos.leads.vendidos-nao-conferidos', ['contatos' => $lead]);
    }


    public function nao_vendidos(){

        if(Auth::user()->role == 1 || Auth::user()->role == 4){
        $lead = DB::table('tb_atendimento as t1')
            ->selectRaw("t1.at_id, t1.at_nome_atendente, t1.at_inicio_atendimento, t1.at_final_atendimento, t2.id, t2.ddd, t2.nome, t2
.telefone, t2.email, t2.id_responsavel, t2.status, t2.insercao_hotmart, t2.pos_atendimento")
            ->join('tb_contatos as t2','t1.at_id_contato','=','t2.id')
            #Tem que pegar o charset que veio do modelo antigo, e o novo
            ->whereRaw("t2.pos_atendimento IN('NÃ£o Vendido', 'Não Vendido')")
            ->orderBy('t1.at_final_atendimento','DESC')
            ->get();

        }elseif(Auth::user()->role >= 3){
            $lead = DB::table('tb_atendimento as t1')
                ->selectRaw("t1.at_id, t1.at_nome_atendente, t1.at_inicio_atendimento, t1.at_final_atendimento, t2.id, t2.ddd, t2.nome, t2.telefone, t1.at_id_responsavel, t2.email, t2.id_responsavel, t2.status, t2.insercao_hotmart, t2.pos_atendimento")
                ->join('tb_contatos as t2','t1.at_id_contato','=','t2.id')
                #Tem que pegar o charset que veio do modelo antigo, e o novo
                ->whereRaw("t2.pos_atendimento IN('NÃ£o Vendido', 'Não Vendido') AND t1.at_id_responsavel = ".Auth::user()->id)
                ->orderBy('t1.at_final_atendimento','DESC')
                ->get();

        }elseif (Auth::user()->role == 2) {
            $lead = DB::table('tb_atendimento as t1')
                ->selectRaw("t1.at_id, t1.at_nome_atendente, t1.at_inicio_atendimento, t1.at_final_atendimento, t2.id, t2.nome, t2.ddd, t2.telefone, t2.email, t2.status, t2.insercao_hotmart, t2.pos_atendimento, t2.id_responsavel")
                ->join('tb_contatos as t2','t1.at_id_contato','=','t2.id')
                #Tem que pegar o charset que veio do modelo antigo, e o novo
                ->whereRaw("t2.pos_atendimento IN('NÃ£o Vendido', 'Não Vendido') AND t2.id_responsavel = ".Auth::user()->id)
                ->orderBy('t1.at_final_atendimento','DESC')
                ->get();
        }

        return view('contatos.leads.nao-vendidos', ['contatos' => $lead]);
    }

    public function boletos_gerados(){
        if(Auth::user()->role == 1 || Auth::user()->role == 4){
        $lead = DB::table('tb_atendimento as t1')
            ->selectRaw("t1.at_id, t1.at_nome_atendente, t1.at_inicio_atendimento, t1.at_final_atendimento, t2.id, t2.nome, t2.ddd, t2.id_responsavel, t2.telefone, t2.email, t2.status, t2.insercao_hotmart, t2.pos_atendimento")
            ->join('tb_contatos as t2','t1.at_id_contato','=','t2.id')
            ->whereRaw("t2.conferencia = 0 AND t2.pos_atendimento LIKE '%Boleto Gerado%'")
            ->orderBy('t1.at_final_atendimento','DESC')
            ->get();
        }elseif(Auth::user()->role >= 3){
            $lead = DB::table('tb_atendimento as t1')
                ->selectRaw("t1.at_id, t1.at_nome_atendente, t1.at_inicio_atendimento, t1.at_final_atendimento, t2.id, t2.nome, t2.ddd, t2.id_responsavel, t1.at_id_responsavel, t2.telefone, t2.email, t2.status, t2.insercao_hotmart, t2.pos_atendimento")
                ->join('tb_contatos as t2','t1.at_id_contato','=','t2.id')
                ->whereRaw("t2.conferencia = 0 AND t2.pos_atendimento LIKE '%Boleto Gerado%' AND t1.at_id_responsavel = ".Auth::user()->id)
                ->orderBy('t1.at_final_atendimento','DESC')
                ->get();

        }elseif(Auth::user()->role == 2){
            $lead = DB::table('tb_atendimento as t1')
                ->selectRaw("t1.at_id, t1.at_nome_atendente, t1.at_inicio_atendimento, t1.at_final_atendimento, t2.id, t2.nome, t2.ddd, t2.id_responsavel, t1.at_id_responsavel, t2.telefone, t2.email, t2.status, t2.insercao_hotmart, t2.pos_atendimento")
                ->join('tb_contatos as t2','t1.at_id_contato','=','t2.id')
                ->whereRaw("t2.conferencia = 0 AND t2.pos_atendimento = 'Boleto Gerado' AND t2.id_responsavel = ".Auth::user()->id)
                ->orderBy('t1.at_final_atendimento','DESC')
                ->get();

        }
        //Ver poque quando vc adiciona o lead em adicionar, ele não tá caindo na condição aqui de cima
        return view('contatos.leads.boletos-gerados', ['contatos' => $lead]);
    }

    public function ligar_depois(){
        if(Auth::user()->role == 1 || Auth::user()->role == 4){
        $lead = DB::table('tb_atendimento as t1')
            ->selectRaw("t1.at_id, t1.at_nome_atendente, t1.at_inicio_atendimento, t1.at_final_atendimento, t1.at_data_ligar_depois, t2.id, t2.nome, t2.telefone, t2.email, t2.observacao, t2.id_responsavel, t2.obs_followup, t2.status, t2.insercao_hotmart, t2.ddd, t2.obs_followup, t2.pos_atendimento, t2.data_ligar_depois")
            ->join('tb_contatos as t2','t1.at_id_contato','=','t2.id')
            ->where("t2.pos_atendimento", '=',"Ligar Depois")
            ->where('t1.at_nome_atendente', '!=', 'Sistema')
            ->orderBy('data_ligar_depois','ASC')
            ->get();

        }elseif(Auth::user()->role >= 3){
            $lead = DB::table('tb_atendimento as t1')
                ->selectRaw("t1.at_id, t1.at_nome_atendente, t1.at_inicio_atendimento, t1.at_final_atendimento, t1.at_data_ligar_depois, t1.at_id_responsavel, t2.obs_followup, t2.id, t2.nome, t2.telefone, t2.email, t2.observacao, t2.id_responsavel, t2.obs_followup, t2.status, t2.insercao_hotmart, t2.ddd, t2.pos_atendimento, t2.data_ligar_depois")
                ->join('tb_contatos as t2','t1.at_id_contato','=','t2.id')
                ->where("t2.pos_atendimento", '=',"Ligar Depois")
                ->where('t1.at_id_responsavel' ,'=', Auth::user()->id)
                ->orderBy('t2.data_ligar_depois','ASC')
                ->get();


        }elseif (Auth::user()->role == 2) {
            $lead = DB::table('tb_atendimento as t1')
                ->selectRaw("t1.at_id, t1.at_nome_atendente, t1.at_inicio_atendimento, t1.at_final_atendimento, t1.at_data_ligar_depois, t1.at_id_responsavel, t2.id, t2.obs_followup, t2.nome, t2.telefone, t2.email, t2.observacao, t2.id_responsavel, t2.obs_followup, t2.status, t2.insercao_hotmart, t2.ddd, t2.pos_atendimento, t2.data_ligar_depois")
                ->join('tb_contatos as t2','t1.at_id_contato','=','t2.id')
                ->where('t1.at_id_responsavel' ,'=', Auth::user()->id)
                ->orderBy('t2.data_ligar_depois','ASC')
                ->get();

        }
        return view('contatos.leads.ligar-depois', ['contatos' => $lead]);
    }

    public function recuperar_boletos(){
        $lead = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.data_de_venda, t1.nome,t1.ddd, t1.telefone, t1.email, t1.status, t1.documento_usuario, t1.insercao_hotmart, t1.em_atendimento, t1.em_atendendo, t1.obs_followup, t1.prioridade, t1.id_responsavel, t1.pos_atendimento, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereNotNull('t1.telefone')
            ->where('t1.telefone', '!=','')
            ->whereRaw("(t1.aprovado IS NULL AND t1.pos_atendimento IS NULL) AND (t1.status = 'Expirado' OR t1.status = 'Boleto impresso')")
            ->groupBy('t1.email')
            ->orderBy('t1.id','DESC')
            ->get();
        //VEr poque quando vc adiciona o lead em adicionar, ele não tá caindo na condição aqui de cima
        return view('contatos.leads.recuperar-boletos', ['contatos' => $lead]);
    }

    public function nao_atendidos(){
        if(Auth::user()->role == 1 || Auth::user()->role == 4){
        $lead = DB::table('tb_atendimento as t1')
            ->selectRaw("t1.at_id, t1.at_nome_atendente, t1.at_inicio_atendimento, t1.at_id_responsavel, t1.at_final_atendimento, t2.id, t2.ddd, t2.nome, t2.telefone, t2.id_responsavel, t2.email, t2.status, t2.obs_followup, t2.insercao_hotmart, t2.pos_atendimento")
            ->join('tb_contatos as t2','t1.at_id_contato','=','t2.id')
            ->whereRaw("t2.pos_atendimento IN('Boleto NÃ£o Atendido', 'NÃ£o Atendeu') OR t2.pos_atendimento IN('Boleto Não Atendido', 'Não Atendeu')")
            ->orderBy('t1.at_final_atendimento','DESC')
            ->get();

        }elseif(Auth::user()->role >= 3) {
                $lead = DB::table('tb_atendimento as t1')
                    ->selectRaw("t1.at_id, t1.at_nome_atendente, t1.at_id_responsavel, t1.at_inicio_atendimento, t1.at_final_atendimento, t2.id, t2.ddd, t2.nome, t2.telefone, t2.id_responsavel, t2.email, t2.status, t2.obs_followup, t2.insercao_hotmart, t2.pos_atendimento")
                    ->join('tb_contatos as t2', 't1.at_id_contato', '=', 't2.id')
                    ->whereRaw("t2.pos_atendimento IN ('Boleto Não Atendido', 'Não Atendeu') AND t1.at_id_responsavel = " . Auth::user()->id)
                    ->orderBy('t1.at_final_atendimento', 'DESC')
                    ->get();

        }elseif (Auth::user()->role == 2){
            $lead = DB::table('tb_atendimento as t1')
                ->selectRaw("t1.at_id, t1.at_nome_atendente, t1.at_id_responsavel, t1.at_inicio_atendimento, t1.at_final_atendimento, t2.id, t2.ddd, t2.nome, t2.telefone, t2.id_responsavel, t2.email, t2.status, t2.obs_followup, t2.insercao_hotmart, t2.pos_atendimento")
                ->join('tb_contatos as t2', 't1.at_id_contato', '=', 't2.id')
                ->whereRaw("t2.pos_atendimento IN ('Boleto Não Atendido', 'Não Atendeu') AND t2.id_responsavel = " . Auth::user()->id)
                ->orderBy('t1.at_final_atendimento', 'DESC')
                ->get();
        }
        return view('contatos.leads.nao-atendidos', ['contatos' => $lead]);
    }

    public function find($id)
    {

        $query = DB::table('tb_contatos')
            ->selectRaw("tb_contatos.id, tb_contatos.em_atendimento, tb_contatos.pos_atendimento, tb_contatos.nome_do_produto, tb_contatos.data_de_venda, tb_contatos.nome, tb_contatos.ddd, tb_contatos.telefone, tb_contatos.email, tb_contatos.obs_followup, tb_contatos.cep, tb_contatos.endereco, tb_contatos.cidade, tb_contatos.estado, tb_contatos.bairro, tb_contatos.numero, tb_contatos.complemento, tb_contatos.observacao, tb_contatos.status, tb_contatos.em_atendendo, tb_contatos.documento_usuario, tb_contatos.estado, tb_contatos.em_atendimento, tb_contatos.insercao_hotmart, tb_contatos.prioridade, tb_contatos.id_responsavel, t2.user_nome")
            ->join('users as t2','tb_contatos.id_responsavel','=','t2.id')
            ->where('tb_contatos.id','=', $id)
            ->get();

        return view('contatos.leads.editar', ['contato' => $query]);
    }

    public function atender($id)
    {
        #Fazer update em atendimento
        $dado = ['em_atendimento' => Auth::id(), 'em_atendendo' => Auth::user()->avatar];
        $upd = DB::table('tb_contatos')
            ->where('id', '=', $id)
            ->update($dado);

        $query = DB::table('tb_contatos')
            ->selectRaw("tb_contatos.id, tb_contatos.nome_do_produto, tb_contatos.data_de_venda, tb_contatos.nome, tb_contatos.ddd, tb_contatos.telefone, tb_contatos.email, tb_contatos.obs_followup, tb_contatos.observacao, tb_contatos.status, tb_contatos.documento_usuario, tb_contatos.em_atendimento, tb_contatos.em_atendendo, tb_contatos.insercao_hotmart, tb_contatos.enviar_kit, tb_contatos.estado, tb_contatos.data_ligar_depois, tb_contatos.pos_atendimento, tb_contatos.prioridade, tb_contatos.id_responsavel, tb_contatos.cep, tb_contatos.endereco, tb_contatos.cidade, tb_contatos.estado, tb_contatos.bairro, tb_contatos.numero, tb_contatos.complemento, t2.user_nome")
            ->join('users as t2','tb_contatos.id_responsavel','=','t2.id')
            ->where('tb_contatos.id','=', $id)
            ->get();

        return view('contatos.leads.atender', ['contato' => $query]);
    }

    public function atender_ligar_depois($id)
    {
        $query = DB::table('tb_contatos')
            ->selectRaw("tb_contatos.id, tb_contatos.em_atendimento, tb_contatos.pos_atendimento, tb_contatos.nome_do_produto, tb_contatos.data_de_venda, tb_contatos.nome, tb_contatos.ddd, tb_contatos.telefone, tb_contatos.email, tb_contatos.obs_followup, tb_contatos.cep, tb_contatos.endereco, tb_contatos.cidade, tb_contatos.estado, tb_contatos.bairro, tb_contatos.numero, tb_contatos.complemento, tb_contatos.observacao, tb_contatos.data_ligar_depois, tb_contatos.enviar_kit, tb_contatos.status, tb_contatos.em_atendendo, tb_contatos.documento_usuario, tb_contatos.estado, tb_contatos.em_atendimento, tb_contatos.insercao_hotmart, tb_contatos.prioridade, tb_contatos.id_responsavel, t2.user_nome")
            ->join('users as t2','tb_contatos.id_responsavel','=','t2.id')
            ->where('tb_contatos.id','=', $id)
            ->get();

        return view('contatos.leads.atender-ligar-depois', ['contato' => $query]);
    }

    public function atender_ligar_depois_update(Request $request, $id)
    {
        #Update na tabela contatos com as informações
        $param = $request->all();
        $param = $request->except(['ligarDepois','ligarDepois-hora','_token','at_inicio_atendimento', 'sendForm']);
        $contatos = Contatos::where('id', '=', $id);
        $contatos->update($param);

        return response()->redirectToRoute('admin.leads')->with('msg',"Lead editado com sucesso");

    }

    public function atender_update(Request $request, $id)
    {
        #Update na tabela contatos com as informações
        $param = $request->all();

        $envkit = $param['enviar_kit'];
        $dia = $param['ligarDepois'];
        $horas = $param['ligarDepois-hora'];
        $token = $param['_token'];

        $param = $request->except(['ligarDepois','ligarDepois-hora','_token','at_inicio_atendimento', 'sendForm']);

        $param['data_ligar_depois'] = date('Y-m-d H:i:s', strtotime($dia.' '.$horas));


        #Qual email é pra buscar no sistema pra fazer o update
        $email = $param['email'];
        #E-mail nunca jamais poderá estar vazio
        if(empty($email))
        {
            return response()->redirectToRoute('admin.atender', $id)->with('msg-error', "Campo e-mail não pode estar vazio, procure o responsável pela inserção para adicionar um e-mail");
        }

        $contatos = Contatos::where('email', 'LIKE', $email);

        #Defino qual dado quero que atualize
        $dados = [ 'pos_atendimento' => $param['pos_atendimento'], 'enviar_kit' => $envkit ];

        #Assume o pós atendimento marcado para este contato, e todos os outros que tenham o mesmo email
        $up = $contatos->update($dados);

        $contatos->update($param);
        $idContato = $id;

        $dado = ['em_atendimento' => 0, 'em_atendendo' => NULL];
        $upd = DB::table('tb_contatos')
            ->where('id', $id)
            ->update($dado);

        #Update na tabela de atendimento
        $atendimento = DB::table('tb_atendimento')
            ->insertGetId(
                ['at_status' => 1, 'at_id_responsavel' => Auth::id(), 'at_id_contato' => $idContato, 'at_final_atendimento' => date('Y-m-d H:i:s'), 'at_nome_atendente' => Auth::user()->user_nome, 'token' => $token,]
            );

        $msg = "Lead atualizado com sucesso";

        return response()->redirectToRoute('admin.leads')->with('msg',$msg);
    }

    public function editar_update(Request $request, $id)
    {
        #Update na tabela contatos com as informações
        $param = $request->all();
        $param = $request->except(['ligarDepois','ligarDepois-hora','_token','at_inicio_atendimento', 'sendForm']);
        $email = $param['email'];

        #E-mail nunca jamais poderá estar vazio
        if(empty($email))
        {
            return response()->redirectToRoute('admin.leads.editar', $id)->with('msg-error', "Campo e-mail não pode estar vazio, procure o responsável pela inserção para adicionar um e-mail");
        }

        $contatos = Contatos::where('id', '=', $id);
        $contatos->update($param);

        return response()->redirectToRoute('admin.leads')->with('msg',"Lead editado com sucesso");
    }

    public function atender_cancelar($id){
        #Clicou em cancelar atendimento
        $dado = ['em_atendimento' => 0, 'em_atendendo' => NULL];
        $upd = DB::table('tb_contatos')
            ->where('id', $id)
            ->update($dado);
        return response()->redirectToRoute('admin.leads');
    }


    public function deletar(Request $request, $id){
        //Remove
        if(Contatos::destroy($id)){
            $msg = '<div class="alert alert-success"><strong>Lead</strong> apagado com sucesso</div>';
        }else{
            $msg = '<div class="alert alert-danger"><strong>Lead</strong> não apagado</div>';
        }

        return response()->redirectToRoute('admin.leads')->with('message',$msg);
    }

    public function add(){
        $produtos = DB::select('SELECT * FROM tb_produtos ORDER BY prod_id DESC');
        return view('contatos.leads.add', ['produtos' => $produtos]);
    }

    public function search(Request $request){

        $pesquisa =  $request['search'];

        $lead = DB::table('tb_contatos')
            ->selectRaw("*")
            ->whereRaw("email LIKE '%{$pesquisa}%' OR documento_usuario LIKE '%{$pesquisa}%' OR telefone LIKE '%{$pesquisa}%'")
            ->get();

        return view('contatos.leads.search', ['contatos' => $lead]);
    }

    public function cadastrar(Request $request){

        $param = $request->all();
        $email = $param['email'];

        #E-mail nunca jamais poderá estar vazio
        if(empty($email))
        {
            return response()->redirectToRoute('admin.lead.add')->with('msg-error', "Campo e-mail não pode estar vazio, insira um endereço de e-mail válido.");
        }

        #Fazer select de e-mail, se existir email notificar usuário de que não pode ter registro de email duplicado no sistema

        $lead = DB::table('tb_contatos')
            ->selectRaw("id, email")
            ->whereRaw("email LIKE '%{$email}%'")
            ->get();

        $retorno = $lead->count();

        if($retorno == 0){
            Contatos::create($request->all());
            $msg = '<div class="alert alert-success"><strong>Lead</strong> cadastrado com sucesso</div>';
        }else{
            foreach($lead as $reg);
            $id = $reg->id;
            $msg = '<div class="alert alert-danger"><strong></strong> Já existe um registro com este e-mail, clique aqui para atender
 este registro: <a href='.route('admin.atender', $id).'>'.$email.'</a></div>';
        }

        return response()->redirectToRoute('admin.lead.add')->with('message',$msg);

    }

}
