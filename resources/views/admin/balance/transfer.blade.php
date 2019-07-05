@extends('adminlte::page')

@section('title', 'Transferência')

@section('content_header')
    <h1>Fazer transferência</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Transferir</a></li>
    </ol>
@stop

@section('content')
    
    <div class="box">
        <div class="box-header">
            <h3>Fazer Transferência (Informe o recebedor)</h3>
        </div>

        <div class="box-body">
            @include('admin.includes.alerts')

            <form method="POST" action="{{ route('transfer.store') }}">
                {!! csrf_field() !!}

                
                <div class="form-group">
                    <input type="text" name="sender" placeholder="Informe o email ou o nome da pessoa que receberá a transferência">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Próxima Etapa</button>
                </div>
            </form>
        </div>
        
    </div>
@stop