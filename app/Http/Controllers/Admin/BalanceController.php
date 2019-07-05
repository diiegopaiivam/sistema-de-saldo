<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Balances;

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

    public function transferStore(Request $request){

        dd($request->all());
        
    }
}
