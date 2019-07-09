<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Balances;
use App\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use App\Http\Requests\UpdateProfileFormRequest;

class BalanceController extends Controller
{

    
    public function index(){
        
        $balance = auth()->user()->balance;
        $amount = $balance ? $balance->amount : 0;

        return view ('admin.balance.index', compact('amount'));
    }

    public function deposit(){

        return view('admin.balance.deposit');
    }

    public function depositStore(Request $request){

        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->deposit($request->value);

        if($response)
            return redirect()->route('admin.balance')->with('success',$response['message']);

        return redirect()->back()->with('error',$response['message']);
    }

    public function withdrawn(){

        return view('admin.balance.withdrawn');
    }

    public function withdrawnStore(Request $request){

        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->withdrawn($request->value);

        if($response)
            return redirect()->route('admin.balance')->with('success',$response['message']);

        return redirect()->back()->with('error',$response['message']);
    }

    public function transfer(){

        return view('admin.balance.transfer');
    }

    public function transferStore(Request $request, User $user){

        if(!$sender = $user->getSender($request->sender)){

            return redirect()->back()->with('error','Usuário inexistente!');
        }

        if($sender->id === auth()->user()->id){

            return redirect()->back()->with('error','Você não pode transferir para você mesmo!');
        }

        $balance = auth()->user()->balance;

        return view ('admin.balance.transfer-confirm', compact('sender','balance'));
            
    }

    public function transferConcluir (Request $request, User $user){

        if (!$sender = $user->find($request->sender_id))
            return redirect()->route('balance.transfer')->with('success','Recebedor não encontrado!');

        

        $balance = auth()->user()->balance();
        $response = $balance->transfer($request->value);

        if($response)
            return redirect()->route('admin.balance')->with('success',$response['message']);

        return redirect()->back()->with('error',$response['message']);
    }

    public function historic() {

        $historics = auth()->user()->historics()->get();
        

        return view('admin.balance.historic', compact('historics'));
    }
}
