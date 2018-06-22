<?php

namespace App\Http\Controllers;

use App\Brindes;
use App\Contatos;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private $status;

    public function index()
    {
        return response()->redirectToRoute('admin.leads');
    }
    public function form(){
        return view('home.infusion');
    }

    public function infusion(Request $request)
    {
        $all['telefone'] = str_replace(" ", "", $request->input('inf_custom_DDDTelefone'));
        $all['telefone'] = str_replace("(", "", $all['telefone']);
        $all['telefone'] = str_replace(")", "", $all['telefone']);

        $ddd = substr($all['telefone'], 0, 2);
        $all['telefone'] = substr($all['telefone'], 2);

        $all['nome'] = $request->input('inf_field_FirstName');
        $all['email'] = $request->input('inf_field_Email');
        $all['documento_usuario'] = $request->input('inf_custom_CPF');
        $all['estado'] = $request->input('inf_custom_EstadoSigla');
        $all['cidade'] = $request->input('inf_field_City2');
        $all['cep'] = $request->input('inf_field_PostalCode2');
        $all['endereco'] = $request->input('inf_field_Address2Street1');
        $all['bairro'] = $request->input('inf_field_Address2Street2');
        $all['numero'] = $request->input('inf_custom_Numero');
        $all['complemento'] = $request->input('inf_custom_Complemento');
        $all['ddd'] = $ddd;
        $all['data_de_venda'] = date('d/m/Y H:i:s');
        $all['em_atendimento'] = NULL;
        $all['pais'] = 'Brasil';
        $all['id_responsavel'] = 10; //Sistema
        $all['pos_atendimento'] = 'Vendido';
        $all['insercao_hotmart'] = 'Página Externa LMBR';
        $all['prioridade']= 'Duvidas profundas sobre o curso';
        $all['enviar_kit'] = 1;
        $all['conferencia'] = 2;

        Brindes::create($all);

    }

    public function wb_brinde(Request $request)
    {
        $all['telefone'] = str_replace(" ", "", $request->input('inf_custom_DDDTelefone'));
        $all['telefone'] = str_replace("(", "", $all['telefone']);
        $all['telefone'] = str_replace(")", "", $all['telefone']);

        $ddd = substr($all['telefone'], 0, 2);
        $all['telefone'] = substr($all['telefone'], 2);

        $all['nome'] = $request->input('inf_field_FirstName');
        $all['email'] = $request->input('inf_field_Email');
        $all['documento_usuario'] = $request->input('inf_custom_CPF');
        $all['estado'] = $request->input('inf_custom_EstadoSigla');
        $all['cidade'] = $request->input('inf_field_City2');
        $all['cep'] = $request->input('inf_field_PostalCode2');
        $all['endereco'] = $request->input('inf_field_Address2Street1');
        $all['bairro'] = $request->input('inf_field_Address2Street2');
        $all['numero'] = $request->input('inf_custom_Numero');
        $all['complemento'] = $request->input('inf_custom_Complemento');
        $all['ddd'] = $ddd;
        $all['data_de_venda'] = date('d/m/Y H:i:s');
        $all['em_atendimento'] = NULL;
        $all['pais'] = 'Brasil';
        $all['id_responsavel'] = 10; //Sistema
        $all['pos_atendimento'] = 'Vendido';
        $all['insercao_hotmart'] = 'Add Brinde Webnário';
        $all['prioridade']= 'Duvidas profundas sobre o curso';
        $all['enviar_kit'] = 1;
        $all['conferencia'] = 2;

        Brindes::create($all);

    }

    public function brinde_pp(Request $request)
    {
        $all['telefone'] = str_replace(" ", "", $request->input('inf_custom_DDDTelefone'));
        $all['telefone'] = str_replace("(", "", $all['telefone']);
        $all['telefone'] = str_replace(")", "", $all['telefone']);

        $ddd = substr($all['telefone'], 0, 2);
        $all['telefone'] = substr($all['telefone'], 2);

        $all['nome'] = $request->input('inf_field_FirstName');
        $all['email'] = $request->input('inf_field_Email');
        $all['documento_usuario'] = $request->input('inf_custom_CPF');
        $all['estado'] = $request->input('inf_custom_EstadoSigla');
        $all['cidade'] = $request->input('inf_field_City2');
        $all['cep'] = $request->input('inf_field_PostalCode2');
        $all['endereco'] = $request->input('inf_field_Address2Street1');
        $all['bairro'] = $request->input('inf_field_Address2Street2');
        $all['numero'] = $request->input('inf_custom_Numero');
        $all['complemento'] = $request->input('inf_custom_Complemento');
        $all['ddd'] = $ddd;
        $all['data_de_venda'] = date('d/m/Y H:i:s');
        $all['em_atendimento'] = NULL;
        $all['pais'] = 'Brasil';
        $all['id_responsavel'] = 10; //Sistema
        $all['pos_atendimento'] = 'Vendido';
        $all['insercao_hotmart'] = 'Página Externa';
        $all['prioridade']= 'Duvidas profundas sobre o curso';
        $all['enviar_kit'] = 1;
        $all['conferencia'] = 2;

        Brindes::create($all);

    }

    public function hotmart(Request $request){

        function getWcHotmartStatus($Status = null)
        {
            $HotmartStatus = [
                'started' => 'Iniciado',
                'billet_printed' => 'Boleto Impresso',
                'pending_analysis' => 'Pendente',
                'delayed' => 'Atrasado',
                'canceled' => 'Cancelado',
                'approved' => 'Aprovado',
                'completed' => 'Concluído',
                'chargeback' => 'Chargeback',
                'blocked' => 'Bloqueado',
                'refunded' => 'Devolvido',
                'admin_free' => 'Cadastrado'
            ];
            if (!empty($Status)):
                return $HotmartStatus[$Status];
            else:
                return $HotmartStatus;
            endif;
        }

        header("access-control-allow-origin: https://app-vlc.hotmart.com");
        header('Content-Type: text/html; charset=UTF-8');

//GET HOTMART POST
        $HotmartSale = $request->all();

//LOG GENERATE
        if (1 && !empty($HotmartSale)):
            $HotmartLog = null;
            foreach ($HotmartSale as $key => $value):
                switch ($key){
                    case 'status':
                        getWcHotmartStatus($key);
                        $status = $value;
                        $this->status = $value;
                        break;
                    #The Magic goes here

                    case 'email':
                        $dado = ['status' =>  $this->status];
                        $sel = DB::table('tb_contatos')
                            ->where('email','LIKE', $value)
                            ->update($dado);
                        break;
                }
                $HotmartLog .= "{$key}: {$value}\r\n";



            endforeach;

            $HotmartLogFile = fopen(public_path().'/uploads/hotmart.txt', 'a');
            fwrite($HotmartLogFile, "\r\n########## " . date('d/m/Y H\hi') . " ##########\r\n\r\n" . $HotmartLog);
            fclose($HotmartLogFile);
        endif;

        if ($HotmartSale && !empty($request->input('hottok')) && $request->input('hottok') == 'qv82T5NcQDBW4lR8Yi4vkD5eAmTuYY123249'):
            //CLEAR DATA
            array_map('strip_tags', $HotmartSale);
            array_map('trim', $HotmartSale);
            array_map('rtrim', $HotmartSale);

            //GET HOTMART TRANSACTION
            $HotmartTransaction = (!empty($request->input('transaction_ext')) ? $request->input('transaction_ext') : $request->input('transaction'));

            //PRODUCT NEGATIVATE
            if (!empty('hotmartnegativeID')):
                $NegativateProductsExmplode = explode(',', 'hotmartnegativeID');
                $NegativateProductsTrim = array_map('trim', $NegativateProductsExmplode);
                $NegativateProducts = array_map('rtrim', $NegativateProductsTrim);

                if (in_array($request->input('prod'), $NegativateProducts)):
                    exit;
                endif;
            endif;
        endif;

    }

    public function form_hotmart(){
        return view('formhotmart');
    }
}
