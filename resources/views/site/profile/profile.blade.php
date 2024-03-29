@extends('site.layouts.app')

@section('title','Meu Perfil')

@section('content')
<h1> Meu Perfil </h1>

@include('admin.includes.alerts')

<div class="box-body">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" value="{{ auth()->user()->name }}" name="name" placeholder="nome" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" value="{{ auth()->user()->email }}" name="email" placeholder="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Senha:</label>
            <input type="password" name="password" placeholder="Senha" class="form-control">
        </div>
        <div class="form-group">

            @if (auth()->user()->image != null)
                <img src="{{ url('storage/users/'.auth()->user()->image) }}" alt="{{ auth()->user()->name }}" style="max-width: 50px;">
            @endif

            <label for="image">Imagem:</label>
            <input type="file" name="image" placeholder="imagem" class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
        </div>
    </form>
</div>

@endsection