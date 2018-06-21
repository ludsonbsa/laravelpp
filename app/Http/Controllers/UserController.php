<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Image;

class UserController extends Controller
{

    public function index()
    {
        $listar = User::all();
        return view('usuarios.listar', ['usuarios' => $listar]);
    }

    public function add(){
        return view('usuarios.add');
    }


    public function cadastrar(Request $request)
    {
        $param = $request->all();

        if($request->input('role')){
            switch ($request->input('role')){
                case 1:
                    $request->merge(array('role_name' => "Administrador"));
                    break;

                case 2:
                    $request->merge(array('role_name' => "Responsável"));
                    break;

                case 3:
                    $request->merge(array('role_name' => "Atendente"));
                    break;

                case 4:
                    $request->merge(array('role_name' => "Suporte"));
                    break;

                case 5:
                    $request->merge(array('role_name' => "Aux. Admin"));
                    break;

                case 6:
                    $request->merge(array('role_name' => "At. Temporário"));
                    break;
            }

        }

        if($request->hasFile('avatar')){
            $file = Input::file('avatar');
            $avatar = $request->file('avatar');
            $filename = time() . '.' .$avatar->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/avatar/');
            try{
                $file->move($destinationPath, $filename);

            }catch (FileNotFoundException $e){
                echo $e;
            }
            $param['avatar'] = '/uploads/avatar/'.$filename;
        }else{
            $param = $request->except(['_token','sendForm','avatar']);
        }

        User::create($request->all());
        return response()->redirectToRoute('admin.listar.usuarios');

    }



    public function editar($id)
    {
        $listar = DB::select('SELECT * FROM users WHERE id = '.$id);
        return view('usuarios.editar', ['usuario' => $listar]);
    }


    public function editar_update(Request $request, $id)
    {

        $param = $request->all('user_nome','email','role','role_name','status');

        switch ($param['role']){
            case 1:
                $param['role_name'] = 'Administrador';
                break;

            case 2:
                $param['role_name'] = 'Responsável';
                break;

            case 3:
                $param['role_name'] = 'Atendente';
                break;

            case 4:
                $param['role_name'] = 'Suporte';
                break;

            case 5:
                $param['role_name'] = 'At. Temporário';
                break;

        }

        $validator = Validator::make($request->all(), [
            'file' => 'max:500000',
        ]);



        if($request->hasFile('avatar')){
            $file = Input::file('avatar');
            $avatar = $request->file('avatar');
            $filename = time() . '.' .$avatar->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/avatar/');
            try{
                $file->move($destinationPath, $filename);

            }catch (\FileNotFoundException $e){
                echo $e;
            }
            $param['avatar'] = '/uploads/avatar/'.$filename;
        }


        $user = User::where('id', '=', $id);
        $user->update($param);
        return response()->redirectToRoute('admin.listar.usuarios');
    }


    public function status($status, $id)
    {
        if($status == 'desativado'){
            $param = ['status' => 1];

            $user = User::where('id', '=', $id);
            $user->update($param);

        }elseif($status == 'ativado'){
            $param = ['status' => 0];
            $user = User::where('id', '=', $id);
            $user->update($param);
        }

        return response()->redirectToRoute('admin.listar.usuarios');
    }


    public function excluir($id)
    {
        $user = User::where('id', '=', $id);
        User::destroy($id);

        return response()->redirectToRoute('admin.listar.usuarios');
    }

    public function cadastrar_senha(Request $request, $id){
        $senha = $request->input('password');
        $confirm_senha = $request->input('confirm_password');


        if($confirm_senha == $senha && !empty($senha)){

            #Encripto a senha
            $password = bcrypt($senha);

            #Seleciono o usuário
            $user = User::where('id', '=', $id);
            $param = [
                'password' => $password
            ];
            $user->update($param);

            return redirect()->route('admin.editar.usuario',$id)->with('msg',"Senha cadastrada com sucesso.");

        }else{
            return redirect()->route('admin.editar.usuario',$id)->with('msg-error',"Senha não cadastrada, campo senha não pode estar vazio ou senhas não batem.");
        }

    }
}
