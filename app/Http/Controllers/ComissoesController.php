<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Comissoes;
use App\Helpers;

class ComissoesController extends Controller
{

    public function conferencia()
    {
        //listagem das comissões a serem conferidas
        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.pos_atendimento ='Boleto Gerado' OR t1.pos_atendimento = 
'Vendido') AND (t1.insercao_hotmart != 'Pagina Externa') AND t1.conferencia = 0")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')->paginate(25);

        $count = $query->count();

        return view('comissoes.listar', ['contatos' => $query, 'count' => $count]);
    }


    public function conferidas()
    {
        //listagem das comissões a serem conferidas
        $queryAPROVADAS = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart,t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia = 1 AND t1.aprovado = 1) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL) AND (t1.comissao_gerada IS NULL) AND insercao_hotmart != 'Pagina Externa' AND insercao_hotmart != 'Pagina Externa WB 15-12'")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')->get();

        $count = $queryAPROVADAS->count();

        $queryNAOAPROVADAS = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart,t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia = 1 AND t1.aprovado IS NULL) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL) AND t2.id != 10 AND insercao_hotmart != 'Pagina Externa' AND insercao_hotmart != 'Pagina Externa WB 15-12'")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')->get();

        $count2 = $queryNAOAPROVADAS->count();

        return view('comissoes.conferidas', ['aprovadas' => $count, 'nao_aprovadas' => $count2]);
    }

    public function conferir(){
        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.pos_atendimento = 'Boleto Gerado' OR t1.pos_atendimento = 
'Vendido') AND (t1.insercao_hotmart != 'Pagina Externa') AND t1.conferencia = 0 AND completo = 0")
            ->orderBy('t1.id','ASC')->get();

        foreach($query as $resultado){
            $cpf = $resultado->documento_usuario;
            $email = $resultado->email;
            $telefone = $resultado->telefone;

            #Verifico resultados começando por CPF
            if ($cpf) {
                #Digo qual é a query que ele vai fazer, é por cpf e aprovado
                $query = "documento_usuario";
                $like = $cpf;

                $dados = [
                    'conferencia' => 1
                ];

                $upd = DB::table('tb_contatos')
                    ->where('documento_usuario', $cpf)
                    ->update($dados);

            #Se não tiver CPF, e existir e-mail, então faz update para todos como aquele e-mail
            }elseif(empty($cpf) && !empty($email)) {
                #Digo qual é a query que ele vai fazer, é por email e aprovado
                $query = "email";
                $like = $email;

                $dados = [
                    'conferencia' => 1
                ];

                $upd = DB::table('tb_contatos')
                    ->where('email', $email)
                    ->update($dados);

            #Se não tiver CPF, e e nem e-mail, então faz update para todos como telefone
            }elseif (empty($email) && empty($cpf)) {
                #Digo qual é a query que ele vai fazer, é por telefone e aprovado
                $query = "telefone";
                $like = $telefone;

                $dados = [
                    'conferencia' => 1
                ];
                $upd = DB::table('tb_contatos')
                    ->where('telefone', $telefone)
                    ->update($dados);
            }

            $queryString = DB::table('tb_contatos')
                ->selectRaw("email, documento_usuario, telefone")
                ->whereRaw("{$query} LIKE '%{$like}%' AND status = 'aprovado'")
                ->get();

            #Fiz um select com a query do caso acima, apenas para ver em tela os dados
        }
        return response()->redirectToRoute('admin.comissoes.listar')->with('message',"teste");
    }

    public function aprovar_manualmente(){

        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome_do_produto, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart,t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia = 1 AND t1.aprovado IS NULL) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL)")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')
            ->get();

        $count = $query->count();
        return view('comissoes.aprovar-manualmente', ['contatos' => $query, 'contagem' => $count]);
    }

    public function relatorio(){

        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart,t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia = 1 AND t1.aprovado IS NULL) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL)")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')
            ->get();

        #Cria o PDF de quem precisa aprovar manualmente
        $pdf= new \FPDF("P","pt","A4");
        $pdf->AddPage();
        $pdf->SetFont('arial','B',12);
        $pdf->Cell(0,15,'APROVAR MANUALMENTE',0,1,'L');
        $pdf->Ln();

        foreach ($query as $dados){
            $pdf->Cell(0,15,$dados->nome,0,1,'L');
            $pdf->Cell(0,15,"DDD: ".$dados->ddd,0,1,'L');
            $pdf->Cell(0,15,"Telefone: ".$dados->telefone,0,1,'L');
            $pdf->Cell(0,15,"E-mail: ".$dados->email,0,1,'L');
            $pdf->Cell(0,15,"CPF: ".$dados->documento_usuario,0,1,'L');
            $pdf->Ln();
        }

        $pdf->Ln(8);
        $pdf->Output("aprovar-manualmente.pdf","D");
    }

    public function aprovar($id){
        $dados = [ 'aprovado' => 1 ];
        $update = DB::table('tb_contatos')
            ->where('id', $id)
            ->update($dados);
        return $id;
    }

    public function reprovar($id){
        $dados = [ 'aprovado' => 0 ];
        $update = DB::table('tb_contatos')
            ->where('id', $id)
            ->update($dados);
        return $id;
    }

    public function comissionar_pendentes(){
        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.nome_do_produto, t1.data_de_venda, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t2.user_nome, t2.id")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia = 1 AND t1.aprovado = 1) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != 
            NULL) AND (t1.comissao_gerada IS NULL AND insercao_hotmart != 'Pagina Externa' AND insercao_hotmart != 'Pagina Externa WB 15-12')")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')
            ->get();
        $count = $query->count();

        return view('comissoes.comissionar-pendentes', ['contatos' => $query, 'contagem' => $count]);
    }

    public function relatorio_comissinar_pendente(){
        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.nome_do_produto, t1.data_de_venda, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t2.user_nome, t2.id")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia = 1 AND t1.aprovado = 1) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != 
            NULL) AND (t1.comissao_gerada IS NULL AND insercao_hotmart != 'Pagina Externa' AND insercao_hotmart != 'Pagina Externa WB 15-12')")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')
            ->get();
        $count = $query->count();

        #Cria o PDF de quem precisa aprovar manualmente
        $pdf= new \FPDF("P","pt","A4");
        $pdf->AddPage();
        $pdf->SetFont('arial','B',12);
        $pdf->Cell(0,15,'Comissinar Pendentes',0,1,'L');
        $pdf->Ln();

        foreach ($query as $dados){
            $pdf->Cell(0,15,date('d/m/Y H:i:s'),0,1,'L');
            $pdf->Ln();
            $pdf->Cell(0,15,$dados->nome,0,1,'L');
            $pdf->Cell(0,15,"Telefone: ".$dados->telefone,0,1,'L');
            $pdf->Cell(0,15,"Produto: ".$dados->nome_do_produto,0,1,'L');
            $pdf->Cell(0,15,"E-mail: ".$dados->email,0,1,'L');
            $pdf->Cell(0,15,"CPF: ".$dados->documento_usuario,0,1,'L');
            $pdf->Ln();
        }

        $pdf->Ln(8);
        $pdf->Output("comissionar-pendentes-".date('d-m-Y').".pdf","D");
    }

    public function comissionar(Request $request){

        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t2.user_nome, t2.id")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia = 1 AND t1.aprovado = 1) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL) AND (t1.comissao_gerada IS NULL AND insercao_hotmart != 'Pagina Externa' AND insercao_hotmart != 'Pagina Externa WB 15-12')")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')
            ->get();

        foreach ($query as $contato) {
            #Atribui comissão gerada pros e-mails aprovados
            $email = $contato->email;
            $dados = [
                'comissao_gerada' => 1,
                'completo' => 1
            ];
            $update = DB::table('tb_contatos')
                ->where('email', $email)
                ->update($dados);
        }

        #Criar Planilha de Comissão Geral
        $queryPlanilha = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.aprovado, t1.nome_do_produto, t1.conferencia, t1.comissao_gerada, t2.at_id_contato, t2.at_id_responsavel, t2.at_nome_atendente, t2.at_final_atendimento")
            ->join('tb_atendimento as t2','t1.id','=','t2.at_id_contato')
            ->whereRaw("(t1.aprovado = 1 AND t1.conferencia = 1) AND (t1.comissao_gerada = 1) AND completo = 1")
            ->get();

        $csv = new Helpers\CSV();

        foreach ($queryPlanilha as $comissoesMes):
            $csv->addLine(new Helpers\CSVLine($comissoesMes->at_id_responsavel, $comissoesMes->at_id_contato, $comissoesMes->at_final_atendimento, $comissoesMes->nome_do_produto, $comissoesMes->at_nome_atendente));
        endforeach;
        $csv->save("uploads/planilhas/comissoes-geradas-".date('d-m').".csv");

        foreach ($query as $contato) {
            #Atribui completo pros e-mails aprovados e ja adicionados na planilha
            $email = $contato->email;
            $dados = [
                'completo' => 2
            ];
            $update = DB::table('tb_contatos')
                ->where('email', $email)
                ->update($dados);
        }
        #Cria planilha, lê ela e insere os dados dela na tabela de comissões
        $this->geraPlanilha();

        #Tem que deletar pra não duplicar comissões
        $deletar = unlink('uploads/planilhas/comissoes-geradas-'.date('d-m').'.csv');

        return response()->redirectToRoute('admin.comissoes.listar');

    }


    public function geraPlanilha(){

        /*****LER CSV e COLOCAR NA TABELA COMISSÕES******/
        /**Precisa ser inserir no banco os registros dos arquivos pra não processar o banco de dados de novo*/
        $handle = fopen('uploads/planilhas/comissoes-geradas-'.date('d-m').'.csv', "r+");

        while (!feof($handle)) {

            // Ler uma linha do arquivo
            $data = fgetcsv($handle, 0, ";",  '"');
            if (!$data) {
                continue;
            }

            $id_atendente = $data[0];
            $id_contato = $data[1];
            $mes_e_ano = $data[2];
            $produto = $data[3];
            $atendenteNome = $data[4];

            #Aqui ele pega a data de final de atendimento e atribui ao mês para gerar comissão
            $mes = date('m', strtotime($data[2]));
            $ano = date('Y', strtotime($data[2]));


            switch ($produto):
                case 'Pompoarismo Cátia Damasceno':
                    #Pegar o valor do produto de pompoarismo, e o valor da comissão
                    $queryProd = DB::table('tb_produtos')
                        ->select('*')
                        ->where('prod_id', '=', 1)
                        ->get();

                    foreach($queryProd as $p);
                        $valor_produto = $p->prod_valor_do_produto;
                        $comissao = $p->prod_valor_comissao;

                        $dadosEntrada = [
                            'com_id_user' => $id_atendente,
                            'com_id_contato' => $id_contato,
                            'com_ano' => $ano,
                            'com_mes' => $mes,
                            'com_produto' => $produto,
                            'com_valor_produto' => $valor_produto,
                            'com_final' => $comissao,
                            'com_pago' => 0
                        ];
                        DB::table('tb_comissoes')->insert($dadosEntrada);

                    break;

                case 'Principios da Atração':
                    #Pegar o valor do produto de pompoarismo, e o valor da comissão
                    $queryProd = DB::table('tb_produtos')
                        ->select('*')
                        ->where('prod_id', '=', 2)
                        ->get();

                    foreach($queryProd as $p);
                    $valor_produto = $p->prod_valor_do_produto;
                    $comissao = $p->prod_valor_comissao;

                    $dadosEntrada = [
                        'com_id_user' => $id_atendente,
                        'com_id_contato' => $id_contato,
                        'com_ano' => $ano,
                        'com_mes' => $mes,
                        'com_produto' => $produto,
                        'com_valor_produto' => $valor_produto,
                        'com_final' => $comissao,
                        'com_pago' => 0
                    ];
                    DB::table('tb_comissoes')->insert($dadosEntrada);

                    break;
            endswitch;
        }
        fclose($handle);
        return $this;
    }

    public function geradas(){
        $query = DB::table('tb_comissoes as t1')
            ->selectRaw("COUNT(t1.com_id_user) as count_id_user, SUM(t1.com_final) as soma_final, t1.com_id_user, t1.com_mes, t1.com_ano, t1.com_final, t1.com_pago, t1.com_produto, t2.user_nome, t2.avatar")
            ->join('users as t2','t1.com_id_user','=','t2.id')
            ->where("t2.id",'!=', 10)
            ->groupBy('t1.com_id_user', 't1.com_mes', 't1.com_ano')
            ->orderBy('t1.com_id','DESC')
            ->get();

    $count = $query->count();

        return view('comissoes.comissoes-geradas', ['contatos' => $query, 'contagem' => $count]);
    }
}