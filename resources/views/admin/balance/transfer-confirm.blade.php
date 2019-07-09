@extends('adminlte::page')

@section('title', 'Confirmar transferência de Saldo')

@section('content_header')
    <h1>Confirmar transferência</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Transferir</a></li>
        <li><a href="">Confirmar Transferência</a></li>
    </ol>
@stop

@section('content')
    
    <div class="box">
        <div class="box-header">
            <h3>Fazer Transferência (Informe o valor)</h3>
        </div>

        <div class="box-body">
            @include('admin.includes.alerts')

            <p><strong>Nome do Recebedor: </strong>{{ $sender->name }}</p>
            <p><strong>Email do Recebedor: </strong>{{ $sender->email }}</p>
            <p><strong>Seu saldo atual é: </strong>{{ number_format($balance->amount, 2 , ',', '') }}</p>

            <form method="POST" action="{{ route('transfer.concluir') }}">
                {!! csrf_field() !!}

                <input type="hidden" name="sender_id" value="{{ $sender->id }}">

                <div class="form-group">
                    <input type="text" name="value" placeholder="Informe o valor">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Transferir</button>
                </div>
            </form>
        </div>
        
    </div>
@stop