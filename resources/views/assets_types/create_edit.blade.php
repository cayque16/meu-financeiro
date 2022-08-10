@extends('adminlte::page')

@section('title', 'Tipo de Ativo')

@section('content_header')
    <h1>{{ $titulo }} Tipo de Ativo</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @php
        echo $btnVoltar;
        $vNome = isset($assetsType) ? $assetsType->nome : '';
        $vDescricao = isset($assetsType) ? $assetsType->descricao : '';
    @endphp
    <form action="{{ $action }}" method="post">
        {{ csrf_field() }}
        <div class="row">
            <x-adminlte-input name="nome" label="Nome" placeholder="Insira o nome do ativo..."
                fgroup-class="col-md-4" value='{{ $vNome}}' disable-feedback/>
            <x-adminlte-input name="descricao" label="Descrição" placeholder="Insira a descrição do ativo..."
            fgroup-class="col-md-8" value='{{ $vDescricao }}' disable-feedback/>
        </div>
        <div class="div-btn-salvar">
            <x-adminlte-button class="btn-success" type="submit" label=" Salvar" theme="success" icon="fas fa-save"/>
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/app.css">
@stop 

@section('js')
    
@stop
